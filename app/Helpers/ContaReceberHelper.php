<?php

namespace App\Helpers;

use \App\Utilitarios;
use \App\ContaReceber;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\Pessoa;
use \App\Exceptions\CobrancaReceberException;

class ContaReceberHelper{

    public function gerarCobranca(int $idPessoa, float $vrCobranca, int $idFormaPagamento, int $idPlanoPagamento, $idOperadorFinanceiro=null, array $dados=[]){
        $objFormaPagamento      = FormaPagamento::where('active','=', 'yes')->where('id', '=' $idFormaPagamento)->first();
        $objPlanoPagamento      = $objFormaPagamento->planoPagamento()->where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objOperadorFinanceiro  = $objFormaPagamento->operadorFinanceiro()->where('active','=', 'yes')->where('id', '=' $idOperadorFinanceiro)->first();
        //$objPrazo               = $objFormaPagamento->prazoPagamento()->where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objPessoa              = Pessoa::where('active','=', 'yes')->where('id', '=' $idPessoa)->first();
        

        //tipo_pagamento



        $vrCobranca   = Utilitarios::removeMaskMoney($vrCobranca);        
        
        if(! $objPessoa){
            throw new CobrancaReceberException('A pessoa de código nº '.$idPessoa.' não foi identificada.');
        }

        if(! $objFormaPagamento){
            throw new CobrancaReceberException('A forma de pagamento de código nº '.$idFormaPagamento.' não foi identificada.');
        }

        /* if(! $objPrazo){
            throw new CobrancaReceberException('O prazo de pagamento de código nº '.$idPlanoPagamento.' não foi identificado.');
        } */

        if(! $objPlanoPagamento){
            throw new CobrancaReceberException('O plano de pagamento de código nº '.$idPlanoPagamento.' não foi identificado.');
        }
        
        if( !$objOperadorFinanceiro){
            if($objFormaPagamento->hasOperadorFinanceiro == 'yes'){
                throw new CobrancaReceberException('O operador financeiro de código nº '.$idOperadorFinanceiro.' não foi identificado.');
            }
        }

        if( !$vrCobranca){
            throw new CobrancaReceberException('O valor da cobrança informado é inválido.');
        }

        $qtdParcela         = $objPlanoPagamento->qtdParcelas ?? 1;;
        $dataParcelas       = [];
        $qtdDiasIntervalo   = $objPlanoPagamento->qtdDiasIntervaloParcelas ?? 0;
        $qtdDiasPriParcela  = $objPlanoPagamento->qtd_dias_pri_parcela ?? 0;
        $vrParcelaBase      = $vrCobranca / $qtdParcelas;
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
                'user_id'=>\Auth::User()->id;,
                'active'=>'yes',
                'importacao_dados'=>'no',
                'referencia_id'=>$dados['referencia_id'] ?? null,
                'referencia'=>$dados['referencia'] ?? null,
                'filial_id'=>$dados['filial_id'] ?? null,
                'responsavel_id'=>$dados['responsavel_id'] ?? 0,
            
            ];responsavel_id

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

        if(is_array($dataParcelas) && count($dataParcelas) > 0){
            foreach($dataParcelas as $key=>$val){
                $objCobReceber = ContaReceber::create($val);
                if(! $objCobReceber){
                    throw new CobrancaReceberException('Não foi possível gerar os contas a receber.Tente novamente ou entre em contato com o suporte.');
                }
            }
        }

        //---Se não tiver operador financeiro, verifico se a forma de pagamento exige
        /* if(! ($idOperadorFinanceiro > 0)){

            if($objFormaPagamento->hasOperadorFinanceiro == 'yes'){
                throw new CobrancaReceberException('O operador financeiro de código nº '.$idOperadorFinanceiro.' não foi identificado.');
            }
            
        }else{

            $objOperadorFinanceiro  = OperadorFinanceiro::where('active','=', 'yes')->where('id', '=' $idOperadorFinanceiro)->first();

            if($objOperadorFinanceiro){
                throw new CobrancaReceberException('O operador financeiro de código nº '.$idOperadorFinanceiro.' não foi identificado.');
            }
        } */

        

    }
}
