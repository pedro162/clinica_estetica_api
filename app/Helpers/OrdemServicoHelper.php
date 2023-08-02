<?php

namespace App\Helpers;

use \App\Utilitarios;
use \App\OrdemServico;
use \App\Helpers\ContaReceberHelper;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\Exceptions\OrdemServicoException;

class OrdemServicoHelper{

    public function gerarFinanceiro(int $id){
        
        $registro = OrdemServico::where('active', '=', 'yes')->where('id', '=', $id)->first();
        if(! $registro){
            throw new OrdemServicoException('Registro não encontrado');
        }

        $cobrancas = $registro->cobranca;

        if(! $cobrancas){
            throw new OrdemServicoException('Nenhuma cobrança foi encontrada pra a ordem de serviço informada');
        }

        //---- Primerio loop só para validações
        foreach($cobrancas as $obranca){
            $formaPagamento     = $obranca->formaPgto;
            $planoPagamento     = $obranca->planoPgto;
            $operadorFinanceiro = $obranca->operadorFinanceiro;

            $cobRecebHelper = new ContaReceberHelper();
            

            $cobRecebHelper->gerarCobranca($formaPagamento->id,$planoPagamento->id, $operadorFinanceiro && $operadorFinanceiro->id);
            

        }

        //--Second loop to data commit
        foreach($cobrancas as $obranca){
            $formaPagamento     = $obranca->formaPgto;
            $planoPagamento     = $obranca->planoPgto;
            $operadorFinanceiro = $obranca->operadorFinanceiro;
            if(! $formaPagamento){
                throw new OrdemServicoException('A forma de pagamento de código nº '.$obranca->forma_pagamento_id.' não foi identificada.');
            }

            if(! $planoPagamento){
                throw new OrdemServicoException('O plano de pagamento de código nº '.$obranca->plano_pagamento_id.' não foi identificado.');
            }
            
            //---Se não tiver operador financeiro, verifico se a forma de pagamento exige
            if(! ($obranca->operador_financeiro_id > 0)){

                if($formaPagamento->hasOperadorFinanceiro == 'yes'){
                    if(! $operadorFinanceiro){
                        throw new OrdemServicoException('O operador financeiro de código nº '.$obranca->operador_financeiro_id.' não foi identificado.');
                    }
                }
            }
            

        }

        $dadosRequest = [];
        $dadosRequest['user_update_id']         = \Auth::User()->id;
        $registro->update($dadosRequest);

    }
}
