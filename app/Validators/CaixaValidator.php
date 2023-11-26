<?php

namespace App\Validators;

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

class CaixaValidator{

    
    public function validarCaixaBaixar(int $id, array $dados = []){

        $erros = [];

        $id             = $id ?? $dados['id'];
        $callBack       = $dados['callBack'] ?? '';
        $caixa_id       = $dados['caixa_id'] ?? 0;

        if (! ($id > 0)) {
            throw new CobrancaReceberException('Parâmetro ínválido para o caixa de baixa');
        }

        $registro = Caixa::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if(! $registro){
            throw new CobrancaReceberException('Registro não identificao. Tente novamente ou entre em contato com o suporte.');
        }

        return $erros;
    }
}
