<?php

namespace App\Helpers;

use \App\Utilitarios;
use \App\ContaReceber;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\ContaReceberCartao;
use \App\ContaReceberCartaoHelper;
use \App\Pessoa;
use \App\Exceptions\CobrancaReceberException;

class ContaReceberHelper{

    public function validaGerCobranca(int $idPessoa, float $vrCobranca, int $idFormaPagamento, int $idPlanoPagamento, $idOperadorFinanceiro=null, array $dados=[]):array{
        $erros = [];

        $objFormaPagamento      = FormaPagamento::where('active','=', 'yes')->where('id', '=', $idFormaPagamento)->first();
        $objPlanoPagamento      = $objFormaPagamento->planoPagamento()->where('plano_pagamentos.active','=', 'yes')->where('plano_pagamentos.id', '=', $idPlanoPagamento)->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objOperadorFinanceiro  = $objFormaPagamento->operadorFinanceiro()->where('operador_financeiros.active','=', 'yes')->where('operador_financeiros.id', '=', $idOperadorFinanceiro)->first();
        //$objPrazo               = $objFormaPagamento->prazoPagamento()->where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objPessoa              = Pessoa::where('active','=', 'yes')->where('id', '=', $idPessoa)->first();
        

        //tipo_pagamento



        $vrCobranca   = Utilitarios::removeMaskMoney($vrCobranca);        
        
        if(! $objPessoa){
            $erros[] = 'A pessoa de código nº '.$idPessoa.' não foi identificada.';
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

    public function gerarCobranca(int $idPessoa, float $vrCobranca, int $idFormaPagamento, int $idPlanoPagamento, $idOperadorFinanceiro=null, array $dados=[]){
        $objFormaPagamento      = FormaPagamento::where('active','=', 'yes')->where('id', '=', $idFormaPagamento)->first();
        $objPlanoPagamento      = $objFormaPagamento->planoPagamento()->where('plano_pagamentos.active','=', 'yes')->where('plano_pagamentos.id', '=', $idPlanoPagamento)->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objOperadorFinanceiro  = $objFormaPagamento->operadorFinanceiro()->where('operador_financeiros.active','=', 'yes')->where('operador_financeiros.id', '=', $idOperadorFinanceiro)->first();
        //$objPrazo               = $objFormaPagamento->prazoPagamento()->where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objPessoa              = Pessoa::where('active','=', 'yes')->where('id', '=', $idPessoa)->first();
        

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

        for($i=0; !($i == $qtdParcela); $i++){
            $dtVencimento = $objDtVencimento->format("Y-m-d H:i:s");
            $dataParcelas[] = [
                'pessoa_id'=>$objPessoa->id,
                'descricao'=>$dados['descricao'] ?? "Recita financeira",
                'documento'=>$dados['documento'] ?? null,
                'dtVencimentoOriginal'=>$dtVencimento,
                'dtVencimento'=>$dtVencimento,
                'vrPago'=>0,
                'vrBruto'=>$vrParcelaBase,
                'vrLiquido'=>$vrParcelaBase,
                'vrDevolvido'=>0,
                'vrTaxa'=>0,
                'vrDesconto'=>0,
                'vrJuros'=>0,
                'user_id'=>\Auth::User()->id,
                'active'=>'yes',
                'importacao_dados'=>'no',
                'referencia_id'=>$dados['referencia_id'] ?? null,
                'referencia'=>$dados['referencia'] ?? null,
                'filial_id'=>$dados['filial_id'] ?? null,
                'responsavel_id'=>$dados['responsavel_id'] ?? 0,
                'forma_pagamento_id'=>$objFormaPagamento->id,
                'plano_pagamento_id'=>$objPlanoPagamento->id,
                'operador_financeiro_id'=>$objOperadorFinanceiro->id ?? 0,
                'status'=>'aberto',
            
            ];//responsavel_id

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
            'data_cob_receber'=>[],
            'data_cob_receber_cartoes'=>[],
            'data_cob_receber_boletos'=>[],
        ];
        
        if(trim($objFormaPagamento->tipo) == 'cartao_credito' || trim($objFormaPagamento->tipo) == 'cartao_debito' ){
            
            $dtVencimento = $objDtVencimento->format("Y-m-d H:i:s");
            $dataParcela = [
                'pessoa_id'=>$objPessoa->id,
                'descricao'=>$dados['descricao'] ?? "Recita financeira",
                'documento'=>$dados['documento'] ?? null,
                'dtVencimentoOriginal'=>$dtVencimento,
                'dtVencimento'=>$dtVencimento,
                'vrPago'=>0,
                'vrBruto'=>$vrCobranca,
                'vrLiquido'=>$vrCobranca,
                'vrDevolvido'=>0,
                'vrTaxa'=>0,
                'vrDesconto'=>0,
                'vrJuros'=>0,
                'user_id'=>\Auth::User()->id,
                'active'=>'yes',
                'importacao_dados'=>'no',
                'referencia_id'=>$dados['referencia_id'] ?? null,
                'referencia'=>$dados['referencia'] ?? null,
                'filial_id'=>$dados['filial_id'] ?? null,
                'responsavel_id'=>$dados['responsavel_id'] ?? 0,
                'qtd_parcelas'=>$qtdParcela ?? 1,
                'nr_parcela'=>$qtdParcela ?? 1,
                'forma_pagamento_id'=>$objFormaPagamento->id,
                'plano_pagamento_id'=>$objPlanoPagamento->id,
                'operador_financeiro_id'=>$objOperadorFinanceiro->id ?? 0,
                'status'=>'aberto',
            
            ];
            $idBandeira = $dados['bandeira_cartao_id'] ?? null;
            $objCobReceber = ContaReceber::create($dataParcela);
            
            $objCobCartHelper = new ContaReceberCartaoHelper();

            $dataCartoes = $objCobCartHelper->gerarCarteiraCartao($objCobReceber->id, $idBandeira,
                [
                    'status'=>'pendente', 'nr_doc'=>$dataParcela['nr_doc'] ?? $dataParcela['documento']
                ]
            );

            $datacobReceberObjArr['data_cob_receber'][]         = $objCobReceber;
            $datacobReceberObjArr['data_cob_receber_cartoes'][] = $dataCartoes;

        }else{

            if(is_array($dataParcelas) && count($dataParcelas) > 0){
                foreach($dataParcelas as $key=>$val){
                    $objCobReceber = ContaReceber::create($val);
                    if(! $objCobReceber){
                        throw new CobrancaReceberException('Não foi possível gerar os contas a receber.Tente novamente ou entre em contato com o suporte.');
                    }
                    $datacobReceberObjArr['data_cob_receber'][] = $objCobReceber;
                }
            }
        }

        return $datacobReceberObjArr;
    }
}
