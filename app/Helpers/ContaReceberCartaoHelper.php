<?php

namespace App\Helpers;

use \App\Utilitarios;
use \App\ContaReceber;
use \App\ContaReceberItem;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\ContaReceberCartao;
use \App\Pessoa;
use \App\BandeiraCartao;
use \App\Exceptions\CobrancaReceberException;

class ContaReceberCartaoHelper{

    public function gerarCarteiraCartao(int $idCobrancaReceberItem, int $idBandeira, array $dados):array{
        if(! ($idCobrancaReceberItem > 0)){
            throw new CobrancaReceberException('O parâmetro para contas a receber é inváido. Tente novamente ou entre em contato com o suporte.');
        }

        if(! ($idBandeira > 0)){
            throw new CobrancaReceberException('O parâmetro para contas a receber é inváido. Tente novamente ou entre em contato com o suporte.');
        }

        if(! (is_array($dados) && count($dados) > 0)){
            throw new CobrancaReceberException('O parâmetro para dados adicionais é inváido. Tente novamente ou entre em contato com o suporte.');
        }
        
        $cobrancaReceberItem = ContaReceberItem::where('active', '=', 'yes')->where('id', '=', $idCobrancaReceberItem)->first();
        //tipo_pagamento
        if(! $cobrancaReceberItem){
            throw new CobrancaReceberException('O cóntas a receber de código nº '.$idCobrancaReceberItem.' não foi identificado.');
        }

        $cobrancaReceber = $cobrancaReceberItem->contaReceber;
        if(! $cobrancaReceber){
            throw new CobrancaReceberException('O cóntas a receber de código nº '.$cobrancaReceberItem->conta_receber_id.' não foi identificado.');
        }
        
        $objBandeira = BandeiraCartao::where('active', '=', 'yes')
        ->where('id', '=', $idBandeira)->first();
        
        if(! $objBandeira){
            throw new CobrancaReceberException('A bandeira de cartão de código nº '.$idBandeira.' não foi identificada.');
        }
        

        $objPessoa              = $cobrancaReceber->pessoa;   
        $objFormaPagamento      = $cobrancaReceber->formaPagamento;
        $objPlanoPagamento      = $cobrancaReceber->planoPagamento;
        $objOperadorFinanceiro  = $cobrancaReceber->operadorFinanceiro;
        $vrCobranca             = $cobrancaReceber->vrLiquido;
        
        
        
        if(! $objPessoa){
            throw new CobrancaReceberException('A pessoa do contas a receber de código nº '.$cobrancaReceber->id.' não foi identificada.');
        }

        if(! $objFormaPagamento){
            throw new CobrancaReceberException('A forma de pagamento do contas a receber de código nº '.$cobrancaReceber->id.' não foi identificada.');
        }
        
        /* if(! $objPrazo){
            throw new CobrancaReceberException('O prazo de pagamento de código nº '.$idPlanoPagamento.' não foi identificado.');
        } */

        if(! $objPlanoPagamento){
            throw new CobrancaReceberException('O plano de pagamento do contas a receber de código nº '.$cobrancaReceber->id.' não foi identificado.');
        }
        
        if( !$objOperadorFinanceiro){
            if($objFormaPagamento->hasOperadorFinanceiro == 'yes'){
                throw new CobrancaReceberException('O operador financeiro do contas a receber de código nº '.$cobrancaReceber->id.' não foi identificado.');
            }
        }
        
        if( !$vrCobranca){
            throw new CobrancaReceberException('O valor da cobrança do contas a receber de código nº '.$cobrancaReceber->id.' é inválido.');
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

        //
        
        $vrTotalParelasGeradas = 0;
        //throw new CobrancaReceberException('teste: '.$objBandeira->id.' = '.$cobrancaReceberItem->id);
        for($i=0; !($i == $qtdParcela); $i++){
            $dtVencimento = $objDtVencimento->format("Y-m-d H:i:s");
            $dataParcelas[] = [
                'nr_doc'=>$dados['nr_doc'] ?? $dados['documento'] ?? null,
                'dt_emissao'=>date('Y-m-d H:i:s'),
                'dt_vencimento'=>$dtVencimento,
                'dt_baixa'=>null,
                'bandeira_cartao_id'=>$objBandeira->id,
                'bandeira_name'=>$objBandeira->name,
                'vr_bruto'=>$vrParcelaBase,
                'vr_liquido'=>0,
                'vr_taxa'=>0,
                'pct_taxa'=>0,
                'vr_outrasTaxas'=>0,
                'status'=>$dados['status'] ?? 'aberto',
                'conta_receber_id'=>$cobrancaReceber->id,
                'cont_receb_item_id'=>$cobrancaReceberItem->id,
                'user_id'=>\Auth::User()->id,
            
            ];//responsavel_id
            
            if($qtdDiasIntervalo > 0){

                $objDtVencimento->add(new \DateInterval('P'.$qtdDiasIntervalo.'D'));
            }

            $vrTotalParelasGeradas += $vrParcelaBase;           

        }



        if(! (is_array($dataParcelas) && count($dataParcelas) > 0) ){
            throw new CobrancaReceberException('Dados inválidos para gerar a carteira de cartões.Tente novamente ou entre em contato com o suporte.');
        }

        $difParcelas    = $vrParcelaBase - $vrTotalParelasGeradas;
        $difParcelasAbs = abs($difParcelas);

        //-- Tento jogar a diferença das parcela na primeira parcela
        if($difParcelasAbs > 0.02 && is_array($dataParcelas) && count($dataParcelas) > 0){
            $dataParcelas[0]['vr_bruto']    += $difParcelas;
        }

        $cartoesGerados = [];
        foreach($dataParcelas as $key=>$val){
            $objCobReceberCartao = ContaReceberCartao::create($val);
            if(! $objCobReceberCartao){
                throw new CobrancaReceberException('Não foi possível gerar a carteira de cartões.Tente novamente ou entre em contato com o suporte.');
            }
            $cartoesGerados[] = $objCobReceberCartao; 
        }
        
        return $cartoesGerados;

    }
}
