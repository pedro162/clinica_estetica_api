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

    public function gerarFinanceiro(OrdemServico $ordemServico){
        
        if(! $ordemServico){
            throw new OrdemServicoException('Registro não encontrado');
        }

        $cobrancas  = $ordemServico->cobranca;
        $pessoa     = $ordemServico->pessoa;

        if(! $cobrancas){
            throw new OrdemServicoException('Nenhuma cobrança foi encontrada pra a ordem de serviço informada');
        }

        //---- Primerio loop só para validações
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
            
            
            $cobRecebHelper = new ContaReceberHelper();
            $erros = $cobRecebHelper->validaGerCobranca($pessoa->id, $obranca->vr_final, $formaPagamento->id, $planoPagamento->id, $operadorFinanceiro->id ?? 0, []);
        
            if( (is_array($erros) && count($erros) > 0) ){
                throw new OrdemServicoException(implode('<br/>', $erros));
            }

        }
        
        //--Second loop to data commit
        foreach($cobrancas as $obranca){
            $formaPagamento     = $obranca->formaPgto;
            $planoPagamento     = $obranca->planoPgto;
            $operadorFinanceiro = $obranca->operadorFinanceiro;

            $cobRecebHelper = new ContaReceberHelper();
            
            $dados=[
                'filial_id'=>$ordemServico->filial_id,
                'referencia'=>$ordemServico->getTable(),
                'referencia_id'=>$ordemServico->id,
                'documento'=>$obranca->nr_doc,
                'descricao'=>'Conta a receber ordem de serviço nº '.$ordemServico->id,
                'responsavel_id'=>\Auth::User()->pessoa->id,
        
            ];
            $cobRecebHelper->gerarCobranca($pessoa->id, $obranca->vr_final, $formaPagamento->id, $planoPagamento->id, $operadorFinanceiro->id ?? 0, $dados);
            

        }

        return $ordemServico;
    }

    public function marcarComoFaturada(OrdemServico $ordemServico){
        
        $dadosRequest = [];
        $dadosRequest['is_faturado']        = 'yes';
        $dadosRequest['td_faturamento']     = date('Y-m-d H:i:s');
        $dadosRequest['pess_fat_id']        = \Auth::User()->pessoa->id;
        $dadosRequest['user_update_id']     = \Auth::User()->id;
        $ordemServico->update($dadosRequest);

        return $ordemServico;
        //
    }
}
