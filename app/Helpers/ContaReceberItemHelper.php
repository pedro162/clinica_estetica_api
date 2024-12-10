<?php

namespace App\Helpers;

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

class ContaReceberItemHelper
{

    public function validaGerCobrancaItem(ContaReceber $objCobReceber, float $vrCobranca, int $idFormaPagamento, int $idPlanoPagamento, $idOperadorFinanceiro = null, array $dados = []): array
    {
        $erros = [];

        $objFormaPagamento      = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $idFormaPagamento)->first();
        $objPlanoPagamento      = $objFormaPagamento->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')->where('plano_pagamentos.id', '=', $idPlanoPagamento)->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objOperadorFinanceiro  = $objFormaPagamento->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')->where('operador_financeiros.id', '=', $idOperadorFinanceiro)->first();
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

        if (! $objFormaPagamento) {
            $erros[] = 'A forma de pagamento de código nº ' . $idFormaPagamento . ' não foi identificada.';
        }

        if (! $objPlanoPagamento) {
            $erros[] = 'O plano de pagamento de código nº ' . $idPlanoPagamento . ' não foi identificado.';
        }

        if (!$objOperadorFinanceiro) {
            if ($objFormaPagamento->hasOperadorFinanceiro == 'yes') {
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
        $objFormaPagamento      = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $idFormaPagamento)->first();
        $objPlanoPagamento      = $objFormaPagamento->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')->where('plano_pagamentos.id', '=', $idPlanoPagamento)->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objOperadorFinanceiro  = $objFormaPagamento->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')->where('operador_financeiros.id', '=', $idOperadorFinanceiro)->first();
        $objPessoa              = $objCobReceber->pessoa;

        $vrCobranca   = Utilitarios::removeMaskMoney($vrCobranca);
        $erros = $this->validaGerCobrancaItem($objCobReceber, $vrCobranca, $idFormaPagamento, $idPlanoPagamento, $idOperadorFinanceiro, $dados);

        if ((is_array($erros) && count($erros) > 0)) {
            throw new CobrancaReceberException(implode('<br/>', $erros));
        }

        $qtdParcela         = $objPlanoPagamento->qtdParcelas ?? 1;;
        $dataParcelas       = [];
        $qtdDiasIntervalo   = $objPlanoPagamento->qtdDiasIntervaloParcelas ?? 0;
        $qtdDiasPriParcela  = $objPlanoPagamento->qtd_dias_pri_parcela ?? 0;
        $vrParcelaBase      = $vrCobranca / $qtdParcela;
        $vrParcelaBase      = number_format($vrParcelaBase, 2, '.', ',');
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
                'ds_estorno' => null,
                'vrBruto' => $vrParcelaBase,
                'vrLiquido' => $vrParcelaBase,
                'vrDevolvido' => 0,
                'vrPago' => $vrPago,
                'vrTaxa' => $dados['vrTaxa'] ?? null,
                'vrDesconto' => $dados['vrDesconto'] ?? null,
                'vrJuros' => $dados['vrJuros'] ?? null,
                'status' => $tpStatusCobranca,
                'forma_pagamentos_id' => $objFormaPagamento->id,
                'plano_pagamento_id' => $objPlanoPagamento->id,
                'operador_financeiro_id' => $objOperadorFinanceiro->id ?? 0,
                'user_id' => \Auth::User()->id,
                'conta_receber_id' => $objCobReceber->id,
                'pessoa_estorno_id' => null,
                'pessoa_baixa_id' => null,
                'pessoa_devolucao_id' => null,
                'active' => 'yes',
                'caixa_id' => $idCaixaBaixa,
                'tpBaixa' => $tpBaixa,
                'rashBaixa' => $rashbaixa,

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

        if (trim($objFormaPagamento->tipo) == 'cartao_credito' || trim($objFormaPagamento->tipo) == 'cartao_debito') {

            $dtVencimento = $objDtVencimento->format("Y-m-d H:i:s");
            $dtPagamento        = null;
            $dtBaixa            = null;
            $rashbaixa          = null;
            $vrPago             = 0;
            $tpStatusCobranca    = 'aberto';

            if (isset($dados['documento']) && strlen(trim($dados['documento'])) >= 3) {
                $tpStatusCobranca = 'pago';
            }

            //--- Defino alguns datos de baixa -----------------------------------
            if ($tpStatusCobranca == 'pago') {
                $dtPagamento        = date('Y-m-d H:i:s');
                $dtBaixa            = date('Y-m-d H:i:s');
                $randId             = rand(111111111, 999999999);
                $vrPago             = $vrParcelaBase;
                $rashbaixa          = $objPessoa->id . '' . $randId . '' . date('ymdhis');
            }

            //--- Salvo o item do contas a receber na baixa-----------------------------------
            $dataParcela = [
                'documento' => $dados['documento'] ?? null,
                'dtPagamento' => $dtPagamento,
                'dtBaixa' => $dtBaixa,
                'descricao' => $dados['descricao'] ?? "Recita financeira",
                'ds_estorno' => null,
                'vrBruto' => $vrParcelaBase,
                'vrLiquido' => $vrParcelaBase,
                'vrDevolvido' => 0,
                'vrPago' => $vrPago,
                'vrTaxa' => $dataParcela['vrTaxa'] ?? 0,
                'vrDesconto' => $dataParcela['vrDesconto'] ?? 0,
                'vrJuros' => $dataParcela['vrJuros'] ?? 0,
                'status' => $tpStatusCobranca,
                'forma_pagamentos_id' => $objFormaPagamento->id,
                'plano_pagamento_id' => $objPlanoPagamento->id,
                'operador_financeiro_id' => $objOperadorFinanceiro->id ?? 0,
                'user_id' => \Auth::User()->id,
                'conta_receber_id' => $objCobReceber->id,
                'pessoa_estorno_id' => null,
                'pessoa_baixa_id' => null,
                'pessoa_devolucao_id' => null,
                'active' => 'yes',
                'caixa_id' => null,
                'tpBaixa' => 'user', //cartao==Criar campo para adicionar essa informação
                'rashBaixa' => $rashbaixa,

            ];

            $objCobReceberItem  = ContaReceberItem::create($dataParcela);

            if (! $objCobReceberItem) {
                throw new CobrancaReceberException('Não foi possível realizar a baixa do contas a receber vinculado ao cartão informado. Tente novamente ou entre em contato com o suporte.');
            }

            //--- Salvo a carteira de cartões -----------------------------------

            $objCobCartHelper   = new ContaReceberCartaoHelper();
            $idBandeira         = $dados['bandeira_cartao_id'] ?? 1; //Gravar a bandeira do cartão na tabela de cobranças
            $dataCartoes        = $objCobCartHelper->gerarCarteiraCartao(
                $objCobReceberItem->id,
                $idBandeira,
                [
                    'status' => 'aberto',
                    'nr_doc' => $dataParcela['nr_doc'] ?? $dataParcela['documento']
                ]
            );

            if (! $dataCartoes) {
                throw new CobrancaReceberException('Não foi possível gerar a carteira de cartões.Tente novamente ou entre em contato com o suporte.');
            }

            if ($tpStatusCobranca == 'pago') {
                //---Atualizo o cabeçalho do contas a receber -------------------------------------------------
                $objCobReceber->update(['vrPago' => $objCobReceber->vrPago + $vrParcelaBase]);
            }

            $datacobReceberObjArr['data_cob_receber_item'][]    = $objCobReceberItem;
            $datacobReceberObjArr['data_cob_receber_cartoes'][] = $dataCartoes;
        } else {

            if (is_array($dataParcelas) && count($dataParcelas) > 0) {

                foreach ($dataParcelas as $key => $val) {
                    //--- Salvo o item do contas a receber na baixa-----------------------------------

                    $objCobReceberItem = ContaReceberItem::create($val);
                    if (! $objCobReceberItem) {
                        throw new CobrancaReceberException('Não foi possível gerar os contas a receber.Tente novamente ou entre em contato com o suporte.');
                    }

                    if ($tpStatusCobranca == 'pago') {
                        //---Atualizo o cabeçalho-------------------------
                        $objCobReceber->update(['vrPago' => $objCobReceber->vrPago + $val['vrPago']]);
                    }

                    $datacobReceberObjArr['data_cob_receber_item'][] = $objCobReceberItem;
                }
            } else {
                throw new CobrancaReceberException('Não foi possível identificar quantas parcelas deveriam ser geradas. Tente novamente ou entre em contato com o suporte.');
            }
        }

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
        // throw new CobrancaReceberException('teste');

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
