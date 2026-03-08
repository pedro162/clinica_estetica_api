<?php

namespace App\Application\Services\AccountReceivableItem;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\Application\Commands\AccountReceivableItem\CreateAccountReceivableItemCommand;
use App\Application\Handlers\AccountReceivable\GetAccountReceivableByIdHandler;
use App\Application\Handlers\AccountReceivable\UpdateAccountReceivableHandler;
use App\Application\Handlers\AccountReceivableItem\CreateAccountReceivableItemHandler;
use App\Application\Handlers\AccountReceivableItem\GetAccountReceivableItemByIdHandler;
use App\Application\Handlers\AccountReceivableItem\GetAllAccountReceivableItemHandler;
use App\Application\Handlers\AccountReceivableItem\UpdateAccountReceivableItemHandler;
use App\ContaReceber;
use App\ContaREceberItem;
use App\Exceptions\CobrancaReceberException;
use App\FormaPagamento;
use App\Helpers\ContaReceberItemHelper;
use App\Utilitarios;
use App\Validators\AccountReceivable\AccountReceivableValidator;
use Illuminate\Support\Collection;

class AccountReceivableItemApplicationService implements AccountReceivableItemApplicationServiceInterface
{
    private CreateAccountReceivableItemHandler $createAccountReceivableItemHandler;
    protected GetAllAccountReceivableItemHandler $getAllAccountReceivableItemHandler;
    protected UpdateAccountReceivableItemHandler $updateAccountReceivableItemHandler;
    protected GetAccountReceivableItemByIdHandler $getAccountReceivableItemByIdHandler;
    protected AccountReceivableValidator $accountReceivableValidator;
    protected GetAccountReceivableByIdHandler $getAccountReceivableByIdHandler;
    protected UpdateAccountReceivableHandler $updateAccountReceivableHandler;
    protected ContaReceberItemHelper $accountReceivableItemHelper;

    public function __construct(
        CreateAccountReceivableItemHandler $createAccountReceivableItemHandler,
        GetAllAccountReceivableItemHandler $getAllAccountReceivableItemHandler,
        UpdateAccountReceivableItemHandler $updateAccountReceivableItemHandler,
        GetAccountReceivableItemByIdHandler $getAccountReceivableItemByIdHandler,
        AccountReceivableValidator $accountReceivableValidator,
        GetAccountReceivableByIdHandler $getAccountReceivableByIdHandler,
        UpdateAccountReceivableHandler $updateAccountReceivableHandler,
        ContaReceberItemHelper $accountReceivableItemHelper
    ) {
        $this->createAccountReceivableItemHandler = $createAccountReceivableItemHandler;
        $this->getAllAccountReceivableItemHandler = $getAllAccountReceivableItemHandler;
        $this->updateAccountReceivableItemHandler = $updateAccountReceivableItemHandler;
        $this->getAccountReceivableItemByIdHandler = $getAccountReceivableItemByIdHandler;
        $this->accountReceivableValidator = $accountReceivableValidator;
        $this->getAccountReceivableByIdHandler = $getAccountReceivableByIdHandler;
        $this->updateAccountReceivableHandler = $updateAccountReceivableHandler;
        $this->accountReceivableItemHelper = $accountReceivableItemHelper;
    }

    public function store(
        CreateAccountReceivableItemCommand $command
    ): ?Collection {

        $propertiesData = $command->getDataProperties();

        $accountReceivable = $this->getAccountReceivableByIdHandler->handler(
            CreateAccountReceivableCommand::build([
                'id' => $propertiesData['receivableAccountId']
            ])
        );

        $result = $this->accountReceivableItemHelper->gerarCobrancaItem(
            $accountReceivable,
            (float) $propertiesData['grossValue'],
            (int) $propertiesData['paymentMethodId'],
            (int) $propertiesData['paymentPlanId'],
            (int) $propertiesData['financialOperatorId'],
            $propertiesData
        );

        $resultAccountReceivable = $result['data_cob_receber_item'] ?? [];
        $createdRecords = collect();

        foreach ($resultAccountReceivable as $accountReceivable) {
            $createdRecords->push($accountReceivable);
        }

        return $createdRecords;
    }

    public function update(
        CreateAccountReceivableItemCommand $command
    ): void {

        $this->updateAccountReceivableItemHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllAccountReceivableItemHandler->handler($data);
    }

    public function findById(
        CreateAccountReceivableItemCommand $command
    ): ?ContaREceberItem {

        return $this->getAccountReceivableItemByIdHandler->handler($command);
    }
    protected function accountReceivableParseData(array $data)
    {
        return [
            ...$data,
            'descricao' => $data['descricao'] ?? 'Recita financeira',
            'documento' => $data['documento'] ?? null,
            'dtVencimentoOriginal' => $data['dtVencimentoOriginal'],
            'dtVencimento' => $data['dtVencimento'] ?? null,
            'vrPago' => $data['vrPago'] ?? 0,
            'vrBruto' => $data['vrBruto'] ?? 0,
            'vrLiquido' => $data['vrLiquido'] ?? 0,
            'vrDevolvido' => $data['vrDevolvido'] ?? 0,
            'vrTaxa' => $data['vrTaxa'] ?? 0,
            'vrDesconto' => $data['vrDesconto'] ?? 0,
            'vrJuros' => $data['vrJuros'] ?? 0,
            'importacao_dados' => $data['importacao_dados'] ?? 'no',
            'referencia_id' => $data['referencia_id'] ?? null,
            'referencia' => $data['referencia'] ?? null,
            'filial_id' => $data['filial_id'] ?? null,
            'responsavel_id' => $data['responsavel_id'] ?? 0,
            'forma_pagamentos_id' => $data['forma_pagamentos_id'] ?? null,
            'plano_pagamento_id' => $data['plano_pagamento_id'] ?? null,
            'operador_financeiro_id' => $data['operador_financeiro_id'] ?? null,
            'status' => $data['status'] ?? 'aberto',
            'conta_receber_id' => $data['conta_receber_id'] ?? null,
            'pessoa_estorno_id' => $data['pessoa_estorno_id'] ?? null,
            'pessoa_baixa_id' => $data['pessoa_baixa_id'] ?? null,
            'pessoa_devolucao_id' => $data['pessoa_devolucao_id'] ?? null,
            'caixa_id' => $data['caixa_id'] ?? null,
            'tpBaixa' => 'user', //cartao==Criar campo para adicionar essa informação
            'rashBaixa' => $data['rashBaixa'] ?? null,
            'bandeira_cartao_id' => $data['bandeira_cartao_id'] ?? 0,
            'is_cartao' => $data['is_cartao'] ?? false,
        ];
    }

    public function validaGerCobrancaItem(ContaReceber $accountReceivableObject, array $data = []): array
    {
        $erros = [];

        $paymentMethodObject      = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $data['forma_pagamentos_id'])->first();
        $paymentPlanObject      = $paymentMethodObject->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')->where('plano_pagamentos.id', '=', $data['plano_pagamento_id'])->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $data['plano_pagamento_id'])->first();
        $finantialOperatorObject  = $paymentMethodObject->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')->where('operador_financeiros.id', '=', $data['operador_financeiro_id'])->first();
        $personObject              = $accountReceivableObject->pessoa;
        $vrSaldoCobrancas   = $accountReceivableObject->vrLiquido - $accountReceivableObject->vrPago;

        $vrCobranca         = Utilitarios::removeMaskMoney($data['vrCobranca']);
        $difSaldoCob        =  $vrSaldoCobrancas - $vrCobranca;
        $difSaldoCobAbs     = abs($difSaldoCob);
        $difSaldoCobFormat  = number_format($vrSaldoCobrancas, 2, ',', '.');

        if (! ($vrSaldoCobrancas >= $vrCobranca)) {
            if ($difSaldoCobAbs > 0.02) {
                $erros[] = 'O saldo para novas cobranças é de ' . $difSaldoCobFormat . ' .';
            }
        }

        if (! $personObject) {
            $erros[] = 'A pessoa de código nº ' . $accountReceivableObject->pessoa_id . ' não foi identificada.';
        }

        if (! $paymentMethodObject) {
            $erros[] = 'A forma de pagamento de código nº ' . $data['forma_pagamentos_id'] . ' não foi identificada.';
        }

        if (! $paymentPlanObject) {
            $erros[] = 'O plano de pagamento de código nº ' . $data['plano_pagamento_id'] . ' não foi identificado.';
        }

        if (!$finantialOperatorObject) {
            if ($paymentMethodObject->hasOperadorFinanceiro == 'yes') {
                $erros[] = 'O operador financeiro de código nº ' . $data['operador_financeiro_id'] . ' não foi identificado.';
            }
        }

        if (!$vrCobranca) {
            $erros[] = 'O valor da cobrança informado é inválido.';
        }

        return $erros;
    }

    protected function generateInstallMents(array $data = []): array
    {
        $accountReceivableObject = $this->getAccountReceivableByIdHandler->handler(
            CreateAccountReceivableCommand::build(['id' => $data['conta_receber_id']])
        );

        $paymentMethodObject        = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $data['forma_pagamento_id'])->first();
        $paymentPlanObject          = $paymentMethodObject->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')->where('plano_pagamentos.id', '=', $data['plano_pagamento_id'])->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $data['plano_pagamento_id'])->first();
        $finantialOperatorObject    = $paymentMethodObject->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')->where('operador_financeiros.id', '=', $data['operador_financeiro_id'])->first();
        $personObject               = $accountReceivableObject->pessoa;

        $vrCobranca   = Utilitarios::removeMaskMoney($data['vrCobranca']);
        $erros = $this->validaGerCobrancaItem($accountReceivableObject, $data);

        if ((is_array($erros) && count($erros) > 0)) {
            throw new CobrancaReceberException(implode('<br/>', $erros));
        }

        $qtdParcela         = $data['qtdParcelas'] ?? $paymentPlanObject->qtdParcelas ?? 1;
        $installMents       = [];
        $qtdDiasIntervalo   = $paymentPlanObject->qtdDiasIntervaloParcelas ?? 0;
        $qtdDiasPriParcela  = $paymentPlanObject->qtd_dias_pri_parcela ?? 0;

        if ($qtdParcela == 1) {
            $qtdDiasIntervalo   = 0;
        }

        $vrParcelaBase   = $vrCobranca / $qtdParcela;
        $vrParcelaBase   = number_format($vrParcelaBase, 2, '.', ',');
        $vrParcelaBase   = (float) $vrParcelaBase;
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
        $tpStatusCobranca   = 'aberto';
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
                $rashbaixa          = ($i + 1) . '' . $personObject->id . '' . $randId . '' . date('ymdhis');
                $idCaixaBaixa       = null;
            }

            $dtVencimento = $objDtVencimento->format('Y-m-d H:i:s');

            //--- Preparo os dados para salvar -----------------------------------
            $installMent = $this->accountReceivableParseData([
                'documento' => $data['documento'] ?? null,
                'dtPagamento' => $dtPagamento,
                'dtBaixa' => $dtBaixa,
                'descricao' => $data['descricao'] ?? "Baixa contas a receber códigonº {$accountReceivableObject->id}",
                'ds_estorno' => null,
                'vrBruto' => $vrParcelaBase,
                'vrLiquido' => $vrParcelaBase,
                'vrDevolvido' => 0,
                'vrPago' => $vrPago,
                'vrTaxa' => $data['vrTaxa'] ?? null,
                'vrDesconto' => $data['vrDesconto'] ?? null,
                'vrJuros' => $data['vrJuros'] ?? null,
                'status' => $tpStatusCobranca,
                'forma_pagamentos_id' => $paymentMethodObject->id,
                'plano_pagamento_id' => $paymentPlanObject->id,
                'operador_financeiro_id' => $finantialOperatorObject->id ?? 0,
                'conta_receber_id' => $accountReceivableObject->id,
                'pessoa_estorno_id' => null,
                'pessoa_baixa_id' => null,
                'pessoa_devolucao_id' => null,
                'active' => 'yes',
                'caixa_id' => $idCaixaBaixa,
                'tpBaixa' => $tpBaixa,
                'rashBaixa' => $rashbaixa,
                'bandeira_cartao_id' => $data['bandeira_cartao_id'],
                'is_cartao' => $isCreditCard,

            ]);

            $installMents[] = $installMent;

            if ($qtdDiasIntervalo > 0) {
                $objDtVencimento->add(new \DateInterval('P' . $qtdDiasIntervalo . 'D'));
            }

            $vrTotalParelasGeradas += $vrParcelaBase;
        }

        $difParcelas    = $vrParcelaBase - $vrTotalParelasGeradas;
        $difParcelasAbs = abs($difParcelas);

        //-- Tento jogar a diferença das parcela na primeira parcela
        if ($difParcelasAbs > 0.02 && is_array($installMents) && count($installMents) > 0) {
            $installMents[0]['vrPago']      += 0;
            $installMents[0]['vrBruto']     += $difParcelas;
            $installMents[0]['vrLiquido']   += $difParcelas;
        }

        return $installMents;
    }
}
