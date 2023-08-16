<?php

namespace App\Helpers;

use \App\Utilitarios;
use \App\ContaReceber;
use \App\ContaReceberItem;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\ContaReceberCartao;
use \App\ContaReceberCartaoHelper;
use \App\Pessoa;
use \App\Exceptions\CobrancaReceberException;

class ContaReceberItemHelper{

    public function validaGerCobrancaItem(ContaReceber $objCobReceber, float $vrCobranca, int $idFormaPagamento, int $idPlanoPagamento, $idOperadorFinanceiro=null, array $dados=[]):array{
        $erros = [];

        $objFormaPagamento      = FormaPagamento::where('active','=', 'yes')->where('id', '=', $idFormaPagamento)->first();
        $objPlanoPagamento      = $objFormaPagamento->planoPagamento()->where('plano_pagamentos.active','=', 'yes')->where('plano_pagamentos.id', '=', $idPlanoPagamento)->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objOperadorFinanceiro  = $objFormaPagamento->operadorFinanceiro()->where('operador_financeiros.active','=', 'yes')->where('operador_financeiros.id', '=', $idOperadorFinanceiro)->first();
        //$objPrazo               = $objFormaPagamento->prazoPagamento()->where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        
        $objPessoa              = $objCobReceber->pessoa;
        //$objPessoa              = Pessoa::where('active','=', 'yes')->where('id', '=', $idPessoa)->first();
        

        //tipo_pagamento



        $vrCobranca   = Utilitarios::removeMaskMoney($vrCobranca);        
        
        if(! $objPessoa){
            $erros[] = 'A pessoa de código nº '.$objCobReceber->pessoa_id.' não foi identificada.';
        }

        if(! $objFormaPagamento){
            $erros[] = 'A forma de pagamento de código nº '.$idFormaPagamento.' não foi identificada.';
        }

        /* if(! $objPrazo){
            throw new CobrancaReceberException('O prazo de pagamento de código nº '.$idPlanoPagamento.' não foi identificado.');
        } */

        if(! $objPlanoPagamento){
            $erros[] = 'O plano de pagamento de código nº '.$idPlanoPagamento.' não foi identificado.';
        }
        
        if( !$objOperadorFinanceiro){
            if($objFormaPagamento->hasOperadorFinanceiro == 'yes'){
                $erros[] = 'O operador financeiro de código nº '.$idOperadorFinanceiro.' não foi identificado.';
            }
        }

        if( !$vrCobranca){
            $erros[] = 'O valor da cobrança informado é inválido.';
        }

        return $erros;
    }

    public function gerarCobrancaItem(ContaReceber $objCobReceber, float $vrCobranca, int $idFormaPagamento, int $idPlanoPagamento, $idOperadorFinanceiro=null, array $dados=[]){
        $objFormaPagamento      = FormaPagamento::where('active','=', 'yes')->where('id', '=', $idFormaPagamento)->first();
        $objPlanoPagamento      = $objFormaPagamento->planoPagamento()->where('plano_pagamentos.active','=', 'yes')->where('plano_pagamentos.id', '=', $idPlanoPagamento)->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objOperadorFinanceiro  = $objFormaPagamento->operadorFinanceiro()->where('operador_financeiros.active','=', 'yes')->where('operador_financeiros.id', '=', $idOperadorFinanceiro)->first();
        //$objPrazo               = $objFormaPagamento->prazoPagamento()->where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objPessoa              = $objCobReceber->pessoa;
        //$objPessoa              = Pessoa::where('active','=', 'yes')->where('id', '=', $idPessoa)->first();
        

        //tipo_pagamento



        $vrCobranca   = Utilitarios::removeMaskMoney($vrCobranca);        
        $erros = $this->validaGerCobranca($idPessoa, $vrCobranca, $idFormaPagamento, $idPlanoPagamento, $idOperadorFinanceiro, $dados);
        
        if( (is_array($erros) && count($erros) > 0) ){
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

        if($qtdDiasPriParcela > 0){
            $objDtVencimento->add(new \DateInterval('P'.$qtdDiasPriParcela.'D'));
        }

        $vrTotalParelasGeradas = 0;

        
        $dtPagamento        = null;
        $dtBaixa            = null;
        $rashbaixa          = null;
        $vrPago             = null;
        $tpBaixa            = null;
        $tpStatusCobranca   = 'pago';//aberto
        $rashbaixa          = null;
        $idCaixaBaixa       = null;
        

        for($i=0; !($i == $qtdParcela); $i++){
            
            if($tpStatusCobranca == 'pago'){
                $dtPagamento        = date('Y-m-d H:i:s');
                $dtBaixa            = date('Y-m-d H:i:s');
                $randId             = rand(111111111, 999999999);
                $vrPago             = $vrParcelaBase;
                $rashbaixa          = ($i+1).''.$objPessoa->id.''.$randId.''.date('ymdhis');
                $idCaixaBaixa       = null;
    
            }

            $dtVencimento = $objDtVencimento->format("Y-m-d H:i:s");
            
            //--- Preparo os dados para salvar -----------------------------------
            
            $dataParcela = [
                'documento'=>$dados['documento'] ?? null,
                'dtPagamento'=>$dtPagamento,
                'dtBaixa'=>$dtBaixa,
                'descricao'=>$dados['descricao'] ?? "Baixa contas a receber códigonº {$objCobReceber->id}",
                'ds_estorno'=>null,
                'vrBruto'=>$vrParcelaBase,
                'vrLiquido'=>$vrParcelaBase,
                'vrDevolvido'=>null,
                'vrPago'=>$vrPago,
                'vrTaxa'=>$dados['vrTaxa'] ?? null,
                'vrDesconto'=>$dados['vrDesconto'] ?? null,
                'vrJuros'=>$dados['vrJuros'] ?? null,
                'status'=>$tpStatusCobranca,
                'forma_pagamentos_id'=>$objFormaPagamento->id,
                'plano_pagamento_id'=>$objPlanoPagamento->id,
                'operador_financeiro_id'=>$objOperadorFinanceiro->id ?? 0,
                'user_id'\Auth::User()->id,
                'conta_receber_id'=>$objCobReceber->id,
                'pessoa_estorno_id'=>null,
                'pessoa_baixa_id'=>null,
                'pessoa_devolucao_id'=>null,
                'active'=>'yes',
                'caixa_id'=>$idCaixaBaixa,
                'tpBaixa'=>$tpBaixa,
                'rashBaixa'=>$rashbaixa,
            
            ];

            if($qtdDiasIntervalo > 0){

                $objDtVencimento->add(new \DateInterval('P'.$qtdDiasIntervalo.'D'));
            }

            $vrTotalParelasGeradas += $vrParcelaBase;           

        }

        $difParcelas    = $vrParcelaBase - $vrTotalParelasGeradas;
        $difParcelasAbs = abs($difParcelas);

        //-- Tento jogar a diferença das parcela na primeira parcela
        if($difParcelasAbs > 0.02 && is_array($dataParcelas) && count($dataParcelas) > 0){
            $dataParcelas[0]['vrPago']      += 0;
            $dataParcelas[0]['vrBruto']     += $difParcelas;
            $dataParcelas[0]['vrLiquido']   += $difParcelas;
        }
        
        $datacobReceberObjArr = [
            'data_cob_receber_item'=>[],
            'data_cob_receber_cartoes'=>[],
            'data_cob_receber_boletos'=>[],
        ];
        
        if(trim($objFormaPagamento->tipo) == 'cartao_credito' || trim($objFormaPagamento->tipo) == 'cartao_debito' ){
            
            $dtVencimento = $objDtVencimento->format("Y-m-d H:i:s");
            $dtPagamento        = null;
            $dtBaixa            = null;
            $rashbaixa          = null;
            $vrPago             = null;
            $tpStatusCobranca    = 'aberto';

            if(isset($dados['documento']) && strlen(trim($dados['documento'])) >= 3){
                $tpStatusCobranca = 'pago';
            }

            //--- Defino alguns datos de baixa -----------------------------------
            if($tpStatusCobranca == 'pago'){
                $dtPagamento        = date('Y-m-d H:i:s');
                $dtBaixa            = date('Y-m-d H:i:s');
                $randId             = rand(111111111, 999999999);
                $vrPago             = $vrParcelaBase;
                $rashbaixa          = $objPessoa->id.''.$randId.''.date('ymdhis');

            }
            
            //--- Salvo o item do contas a receber na baixa-----------------------------------
            
            $dataParcela = [
                'documento'=>$dados['documento'] ?? null,
                'dtPagamento'=>$dtPagamento,
                'dtBaixa'=>$dtBaixa,
                'descricao'=>$dados['descricao'] ?? "Recita financeira",
                'ds_estorno'=>null,
                'vrBruto'=>$vrParcelaBase,
                'vrLiquido'=>$vrParcelaBase,
                'vrDevolvido'=>null,
                'vrPago'=>$vrPago,
                'vrTaxa'=>$dataParcela['vrTaxa'] ?? null,
                'vrDesconto'=>$dataParcela['vrDesconto'] ?? null,
                'vrJuros'=>$dataParcela['vrJuros'] ?? null,
                'status'=>$tpStatusCobranca,
                'forma_pagamentos_id'=>$objFormaPagamento->id,
                'plano_pagamento_id'=>$objPlanoPagamento->id,
                'operador_financeiro_id'=>$objOperadorFinanceiro->id ?? 0,
                'user_id'\Auth::User()->id,
                'conta_receber_id'=>$objCobReceber->id,
                'pessoa_estorno_id'=>null,
                'pessoa_baixa_id'=>null,
                'pessoa_devolucao_id'=>null,
                'active'=>'yes',
                'caixa_id'=>null,
                'tpBaixa'=>'cartao',
                'rashBaixa'=>$rashbaixa,
            
            ];
            
            $objCobReceberItem  = ContaReceberItem::crate($dataParcela);

            if(! $objCobReceberItem){
                throw new CobrancaReceberException('Não foi possível realizar a baixa do contas a receber vinculado ao cartão informado. Tente novamente ou entre em contato com o suporte.');
            }

            //--- Salvo a carteira de cartões -----------------------------------
            
            $objCobCartHelper   = new ContaReceberCartaoHelper();
            $idBandeira         = $dados['bandeira_cartao_id'] ?? null;
            $dataCartoes        = $objCobCartHelper->gerarCarteiraCartao($objCobReceberItem->id, $idBandeira,
                [
                    'status'=>'pendente', 'nr_doc'=>$dataParcela['nr_doc'] ?? $dataParcela['documento']
                ]
            );

            if(! $dataCartoes){
                throw new CobrancaReceberException('Não foi possível gerar a carteira de cartões.Tente novamente ou entre em contato com o suporte.');
            }

            if($tpStatusCobranca == 'pago'){
                //---Atualizo o cabeçalho do contas a receber -------------------------------------------------
                $objCobReceber->update(['vrPago'=>$objCobReceber->vrPago+$vrParcelaBase]);
            }

            $datacobReceberObjArr['data_cob_receber_item'][]    = $objCobReceberItem;
            $datacobReceberObjArr['data_cob_receber_cartoes'][] = $dataCartoes;

        }else{

            if(is_array($dataParcelas) && count($dataParcelas) > 0){

                foreach($dataParcelas as $key=>$val){

                    //--- Salvo o item do contas a receber na baixa-----------------------------------

                    $objCobReceberItem = ContaReceberItem::create($val);
                    if(! $objCobReceberItem){
                        throw new CobrancaReceberException('Não foi possível gerar os contas a receber.Tente novamente ou entre em contato com o suporte.');
                    }

                    if($tpStatusCobranca == 'pago'){
                        //---Atualizo o cabeçalho-------------------------
                        $objCobReceber->update(['vrPago'=>$objCobReceber->vrPago+$val['vrPago']]);
                    }

                    $datacobReceberObjArr['data_cob_receber_item'][] = $objCobReceberItem;
                }

            }else{
                throw new CobrancaReceberException('Não foi possível identificar quantas parcelas deveriam ser geradas. Tente novamente ou entre em contato com o suporte.');
            }
        }

        return $datacobReceberObjArr;
    }
}
