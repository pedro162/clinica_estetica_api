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
use \App\Pessoa;
use \App\Caixa;
use \App\Exceptions\CobrancaReceberException;

class CaixaHelper{

    
    public function atualizar(array $dados, int $id){

        $id             = $id ?? $dados['id'];
        $callBack       = $dados['callBack'] ?? '';
        $caixa_id       = $dados['caixa_id'] ?? 0;

        if ($id <= 0) {
            throw new CobrancaReceberException('Parâmetro ínválido');
        }

        if (! ($caixa_id > 0)) {
            throw new CobrancaReceberException('Parâmetro ínválido para o caixa de baixa');
        }

        $registro = Caixa::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if(! $registro){
            throw new CobrancaReceberException('Registro não identificao. Tente novamente ou entre em contato com o suporte.');
        }

    }

    public function getSaldoCaixa(int $id){
    	
    	if(! (isset($id) && $id > 0)) {
            throw new CobrancaReceberException('Parâmetro ínválido');
        }

        $registro = Caixa::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if(! $registro){
            throw new CobrancaReceberException('Registro não identificao. Tente novamente ou entre em contato com o suporte.');
        }

        return $registro->vrSaldo;
    }

    public function getCaixa(int $id){
    	$registro = Caixa::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

         return $registro;
    }
}
