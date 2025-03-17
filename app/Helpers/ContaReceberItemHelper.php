<?php

namespace App\Helpers;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\Application\Commands\AccountReceivableItem\CreateAccountReceivableItemCommand;
use App\Application\Handlers\AccountReceivable\GetAccountReceivableByIdHandler;
use App\Application\Handlers\AccountReceivable\GetAllAccountReceivableHandler;
use App\Application\Handlers\AccountReceivable\UpdateAccountReceivableHandler;
use App\Application\Handlers\AccountReceivableItem\CreateAccountReceivableItemHandler;
use App\Application\Handlers\AccountReceivableItem\GetAccountReceivableItemByIdHandler;
use App\Application\Handlers\AccountReceivableItem\GetAllAccountReceivableItemHandler;
use App\Application\Handlers\AccountReceivableItem\UpdateAccountReceivableItemHandler;
use \App\Utilitarios;
use \App\ContaReceber;
use \App\ContaReceberItem;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\Helpers\ContaReceberCartao;
use \App\Helpers\ContaReceberCartaoHelper;
use \App\Helpers\FinanceiroMovimentacoeHelper;
use \App\Validators\CaixaValidator;
use \App\Validators\ContaReceberItemValidator;
use \App\Pessoa;
use \App\Caixa;
use \App\Exceptions\CobrancaReceberException;
use App\Validators\AccountReceivable\AccountReceivableValidator;

class ContaReceberItemHelper
{
    protected GetAllAccountReceivableHandler $getAllAccountReceivableHandler;
    protected GetAllAccountReceivableItemHandler $getAllAccountReceivableItemHandler;
    protected UpdateAccountReceivableHandler $updateAccountReceivableHandler;
    protected UpdateAccountReceivableItemHandler $updateAccountReceivableItemHandler;
    protected GetAccountReceivableByIdHandler $getAccountReceivableByIdHandler;
    protected GetAccountReceivableItemByIdHandler $getAccountReceivableItemByIdHandler;
    protected AccountReceivableValidator $accountReceivableValidator;
    protected CreateAccountReceivableItemHandler $createAccountReceivableItemHandler;

    public function __construct(
        GetAllAccountReceivableHandler $getAllAccountReceivableHandler,
        GetAllAccountReceivableItemHandler $getAllAccountReceivableItemHandler,
        UpdateAccountReceivableItemHandler $updateAccountReceivableItemHandler,
        GetAccountReceivableItemByIdHandler $getAccountReceivableItemByIdHandler,
        GetAccountReceivableByIdHandler $getAccountReceivableByIdHandler,
        CreateAccountReceivableItemHandler $createAccountReceivableItemHandler,
        UpdateAccountReceivableHandler $updateAccountReceivableHandler
    ) {
        $this->getAllAccountReceivableItemHandler = $getAllAccountReceivableItemHandler;
        $this->getAllAccountReceivableHandler = $getAllAccountReceivableHandler;
        $this->updateAccountReceivableHandler = $updateAccountReceivableHandler;
        $this->updateAccountReceivableItemHandler = $updateAccountReceivableItemHandler;
        $this->getAccountReceivableByIdHandler = $getAccountReceivableByIdHandler;
        $this->getAccountReceivableItemByIdHandler = $getAccountReceivableItemByIdHandler;
        $this->createAccountReceivableItemHandler = $createAccountReceivableItemHandler;
    }

    public function validaGerCobrancaItem(ContaReceber $objCobReceber, float $vrCobranca, int $idFormaPagamento, int $idPlanoPagamento, $idOperadorFinanceiro = null, array $dados = []): array
    {
        $erros = [];

        $paymentMethodObject      = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $idFormaPagamento)->first();
        $objPlanoPagamento      = $paymentMethodObject->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')->where('plano_pagamentos.id', '=', $idPlanoPagamento)->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objOperadorFinanceiro  = $paymentMethodObject->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')->where('operador_financeiros.id', '=', $idOperadorFinanceiro)->first();
        $objPessoa              = $objCobReceber->pessoa;
        $vrSaldoCobrancas   = $objCobReceber->vrLiquido - $objCobReceber->vrPago;

        $vrCobranca         = Utilitarios::removeMaskMoney($vrCobranca);

        $difSaldoCob        =  $vrSaldoCobrancas - $vrCobranca;
        $difSaldoCobAbs     = abs($difSaldoCob);
        $difSaldoCobFormat  = number_format($vrSaldoCobrancas, 2, ',', '.');

        if (! ($vrSaldoCobrancas >= $vrCobranca)) {
            if ($difSaldoCobAbs > 0.02) {
                $erros[] = 'O saldo para novas cobranças é de ' . $difSaldoCobFormat . ' .';
            }
        }

        if (! $objPessoa) {
            $erros[] = 'A pessoa de código nº ' . $objCobReceber->pessoa_id . ' não foi identificada.';
        }

        if (! $paymentMethodObject) {
            $erros[] = 'A forma de pagamento de código nº ' . $idFormaPagamento . ' não foi identificada.';
        }

        if (! $objPlanoPagamento) {
            $erros[] = 'O plano de pagamento de código nº ' . $idPlanoPagamento . ' não foi identificado.';
        }

        if (!$objOperadorFinanceiro) {
            if ($paymentMethodObject->hasOperadorFinanceiro == 'yes') {
                $erros[] = 'O operador financeiro de código nº ' . $idOperadorFinanceiro . ' não foi identificado.';
            }
        }

        if (!$vrCobranca) {
            $erros[] = 'O valor da cobrança informado é inválido.';
        }

        return $erros;
    }

    public function gerarCobrancaItem(ContaReceber $objCobReceber, float $vrCobranca, int $idFormaPagamento, int $idPlanoPagamento, $idOperadorFinanceiro = null, array $dados = [])
    {
        $paymentMethodObject      = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $idFormaPagamento)->first();
        $objPlanoPagamento      = $paymentMethodObject->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')->where('plano_pagamentos.id', '=', $idPlanoPagamento)->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objOperadorFinanceiro  = $paymentMethodObject->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')->where('operador_financeiros.id', '=', $idOperadorFinanceiro)->first();
        $objPessoa              = $objCobReceber->pessoa;

        $vrCobranca   = Utilitarios::removeMaskMoney($vrCobranca);
        $erros = $this->validaGerCobrancaItem($objCobReceber, $vrCobranca, $idFormaPagamento, $idPlanoPagamento, $idOperadorFinanceiro, $dados);

        if ((is_array($erros) && count($erros) > 0)) {
            throw new CobrancaReceberException(implode('<br/>', $erros));
        }

        $qtdParcela         = $dados['qtdParcelas'] ?? $objPlanoPagamento->qtdParcelas ?? 1;;
        $dataParcelas       = [];
        $qtdDiasIntervalo   = $objPlanoPagamento->qtdDiasIntervaloParcelas ?? 0;
        $qtdDiasPriParcela  = $objPlanoPagamento->qtd_dias_pri_parcela ?? 0;
        $vrParcelaBase      = $vrCobranca / $qtdParcela;
        $vrParcelaBase      = (float) $vrParcelaBase;

        $objDtVencimento = new \DateTime();

        if ($qtdDiasPriParcela > 0) {
            $objDtVencimento->add(new \DateInterval('P' . $qtdDiasPriParcela . 'D'));
        }

        $vrTotalParelasGeradas = 0;

        $dtPagamento        = null;
        $dtBaixa            = null;
        $rashbaixa          = null;
        $vrPago             = 0;
        $tpBaixa            = 'user';
        $tpStatusCobranca   = 'pago'; //aberto
        $rashbaixa          = null;
        $idCaixaBaixa       = null;
        $isCreditCard       = false;

        if (trim($paymentMethodObject->tipo) == 'cartao_credito' || trim($paymentMethodObject->tipo) == 'cartao_debito') {
            if (isset($data['documento']) && strlen(trim($data['documento'])) >= 3) {
                $tpStatusCobranca = 'pago';
            }
        }

        if (trim($paymentMethodObject->tipo) == 'cartao_credito' || trim($paymentMethodObject->tipo) == 'cartao_debito') {
            $isCreditCard = true;
        }

        for ($i = 0; !($i == $qtdParcela); $i++) {

            if ($tpStatusCobranca == 'pago') {
                $dtPagamento        = date('Y-m-d H:i:s');
                $dtBaixa            = date('Y-m-d H:i:s');
                $randId             = rand(111111111, 999999999);
                $vrPago             = $vrParcelaBase;
                $rashbaixa          = ($i + 1) . '' . $objPessoa->id . '' . $randId . '' . date('ymdhis');
                $idCaixaBaixa       = null;
            }

            $dtVencimento = $objDtVencimento->format("Y-m-d H:i:s");

            //--- Preparo os dados para salvar -----------------------------------
            $dataParcela = [
                'documento' => $dados['documento'] ?? null,
                'dtPagamento' => $dtPagamento,
                'dtBaixa' => $dtBaixa,
                'descricao' => $dados['descricao'] ?? "Baixa contas a receber códigonº {$objCobReceber->id}",
                'vrBruto' => $vrParcelaBase,
                'vrLiquido' => $vrParcelaBase,
                'vrPago' => $vrPago,
                'vrTaxa' => $dados['vrTaxa'] ?? null,
                'vrDesconto' => $dados['vrDesconto'] ?? null,
                'vrJuros' => $dados['vrJuros'] ?? null,
                'status' => $tpStatusCobranca,
                'forma_pagamentos_id' => $paymentMethodObject->id,
                'plano_pagamento_id' => $objPlanoPagamento->id,
                'operador_financeiro_id' => $objOperadorFinanceiro->id ?? 0,
                'conta_receber_id' => $objCobReceber->id,
                'caixa_id' => $idCaixaBaixa,
                'tpBaixa' => $tpBaixa,
                'rashBaixa' => $rashbaixa,
                'bandeira_cartao_id' => $dados['bandeira_cartao_id'] ?? null,
                'is_cartao' => $isCreditCard,
            ];

            $dataParcelas[] = $dataParcela;

            if ($qtdDiasIntervalo > 0) {

                $objDtVencimento->add(new \DateInterval('P' . $qtdDiasIntervalo . 'D'));
            }

            $vrTotalParelasGeradas += $vrParcelaBase;
        }

        $difParcelas    = $vrParcelaBase - $vrTotalParelasGeradas;
        $difParcelasAbs = abs($difParcelas);

        //-- Tento jogar a diferença das parcela na primeira parcela
        if ($difParcelasAbs > 0.02 && is_array($dataParcelas) && count($dataParcelas) > 0) {
            $dataParcelas[0]['vrPago']      += 0;
            $dataParcelas[0]['vrBruto']     += $difParcelas;
            $dataParcelas[0]['vrLiquido']   += $difParcelas;
        }

        $datacobReceberObjArr = [
            'data_cob_receber_item' => [],
            'data_cob_receber_cartoes' => [],
            'data_cob_receber_boletos' => [],
        ];

        $totalValuePayed = 0;

        if (is_array($dataParcelas) && count($dataParcelas) > 0) {

            foreach ($dataParcelas as $key => $val) {
                $accountReceivableItem = $this->createAccountReceivableItemHandler->handler(
                    CreateAccountReceivableItemCommand::build($val)
                );

                if (! $accountReceivableItem) {
                    throw new CobrancaReceberException('Não foi possível gerar os contas a receber.Tente novamente ou entre em contato com o suporte.');
                }

                if ($tpStatusCobranca == 'pago') {
                    $totalValuePayed += $accountReceivableItem->vrPago;
                }

                if (!empty($val['is_cartao']) && $val['is_cartao']) {

                    $objCobCartHelper   = new ContaReceberCartaoHelper();
                    $idBandeira         = $dados['bandeira_cartao_id'] ?? 1; //Gravar a bandeira do cartão na tabela de cobranças
                    $dataCartoes        = $objCobCartHelper->gerarCarteiraCartao(
                        $accountReceivableItem->id,
                        $idBandeira,
                        [
                            'status' => 'aberto',
                            'nr_doc' => $dataParcela['nr_doc'] ?? $dataParcela['documento']
                        ]
                    );

                    if (! $dataCartoes) {
                        throw new CobrancaReceberException('Não foi possível gerar a carteira de cartões.Tente novamente ou entre em contato com o suporte.');
                    }

                    $datacobReceberObjArr['data_cob_receber_cartoes'][] = $dataCartoes;
                }

                $datacobReceberObjArr['data_cob_receber_item'][] = $accountReceivableItem;
            }
        } else {
            throw new CobrancaReceberException('Não foi possível identificar quantas parcelas deveriam ser geradas. Tente novamente ou entre em contato com o suporte.');
        }

        $accountReceivableObject = $this->getAccountReceivableByIdHandler->handler(
            CreateAccountReceivableCommand::build(['id' => $objCobReceber->id])
        );

        $accountReceivableObject->vrPago += $totalValuePayed;

        $this->updateAccountReceivableHandler->handler(
            CreateAccountReceivableCommand::build([
                'id' => $accountReceivableObject->id,
                'vrPago' => $accountReceivableObject->vrPago
            ])
        );

        return $datacobReceberObjArr;
    }

    public function baixar(array $dados, int $id)
    {
        $erros = [];

        $id             = $id ?? $dados['id'];
        $callBack       = $dados['callBack'] ?? '';
        $caixa_id       = $dados['caixa_id'] ?? 0;

        if ($id <= 0) {
            throw new CobrancaReceberException('Parâmetro ínválido');
        }

        if (! ($caixa_id > 0)) {
            throw new CobrancaReceberException('Parâmetro ínválido para o caixa de baixa');
        }

        $objCaixaValidator  = new CaixaValidator();
        $errosEncontrados   = $objCaixaValidator->validarCaixaBaixar($caixa_id, $dados);

        if (is_array($errosEncontrados) && count($errosEncontrados) > 0) {
            $erros = array_merge($erros, $errosEncontrados);
        }

        $objContaReceberItemValidator   = new ContaReceberItemValidator();
        $errosEncontrados               = $objContaReceberItemValidator->validarBaixar($id, $dados);
        if (is_array($errosEncontrados) && count($errosEncontrados) > 0) {
            $erros = array_merge($erros, $erros);
        }

        if (is_array($erros) && count($erros) > 0) {
            throw new CobrancaReceberException(implode('<br/>', $erros));
        }

        $objCaixa = Caixa::where('active', '=', 'yes')
            ->where('id', '=', $caixa_id)->first();

        if (! $objCaixa) {
            throw new CobrancaReceberException('Caixa não identificao. Tente novamente ou entre em contato com o suporte.');
        }

        $registro = ContaReceberItem::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if (! $registro) {
            throw new CobrancaReceberException('Contas a receber não identificado. Tente novamente ou entre em contato com o suporte.');
        }

        $objCobrancaReceber = $registro->contaReceber;

        if (! $objCobrancaReceber) {
            throw new CobrancaReceberException('O cabeçalho do contas a receber não foi identificado. Tente novamente ou entre em contato com o suporte.');
        }

        //--------------------- Gerar movimentação de caixa ----------------------------------------
        $objMovimentacaoHelper = new FinanceiroMovimentacoeHelper();

        $dadosRequest = [];

        $dadosRequest['referencia']         = 'conta_recebers';
        $dadosRequest['referencia_id']      = $registro->conta_receber_id;
        //$dadosRequest['sub_referencia']     = 'conta_receber_items';
        //$dadosRequest['sub_referencia_id']  = $registro->id;
        $dadosRequest['historico']          = 'Baixa parcial contas a receber código nº ' . $registro->conta_receber_id . ' - Cliente: ' . $objCobrancaReceber->pessoa->name;
        $dadosRequest['caixa_id']           = $objCaixa->id;
        $dadosRequest['vr_movimentacao']    = $registro->vrLiquido;
        $dadosRequest['conciliado']         = 'no';
        $dadosRequest['estornado']          = 'no';
        $dadosRequest['hash_operacao']      = null;

        $registroMovimentacao = $objMovimentacaoHelper->store($dadosRequest);

        if (! $registroMovimentacao) {
            throw new CobrancaReceberException('Não foi possível gerar movimentação de caixa. Tente novamente ou entre em contato com o suporte.');
        }

        //--------------------- Marcar o contas a receber como pago ----------------------------------------
        $dadosRequest = [];

        $dadosRequest['status']                  = 'pago';
        $dadosRequest['vrPago']                  = $registro->vrLiquido;
        $dadosRequest['user_update_id']          = \Auth::User()->id;

        $registro->update($dadosRequest);
        if (! $registro) {
            throw new CobrancaReceberException('Não foi possível baixar o contas a receber. Tente novamente ou entre em contato com o suporte.');
        }

        //---Atualizo o cabeçalho-------------------------
        $dadosRequestBKP = $dadosRequest;
        $vrPagoToal = $objCobrancaReceber->vrPago + $dadosRequestBKP['vrPago'];
        $dadosRequest = ['vrPago' => $vrPagoToal];
        if ($dadosRequest['vrPago'] >= $objCobrancaReceber->vrLiquido) {
            $dadosRequest['status'] = 'pago';
        }
        $objCobrancaReceber->update($dadosRequest);

        if (! $objCobrancaReceber) {
            throw new CobrancaReceberException('Não foi possível atualizar o valor pago do contas a receber. Tente novamente ou entre em contato com o suporte.');
        }

        return $registro;
    }
}
