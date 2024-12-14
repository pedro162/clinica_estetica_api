<?php

namespace App\Validators\AccountReceivable;

use \App\Utilitarios;
use \App\ContaReceber;
use \App\ContaReceberItem;
use \App\FormaPagamento;
use \App\Pessoa;
use \App\Caixa;
use \App\Exceptions\CobrancaReceberException;

class AccountReceivableValidator
{

    public function validaGerCobranca(int $idPessoa, float $vrCobranca, int $idFormaPagamento, int $idPlanoPagamento, $idOperadorFinanceiro = null, array $dados = []): array
    {
        $erros = [];

        $objFormaPagamento      = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $idFormaPagamento)->first();
        $objPlanoPagamento      = $objFormaPagamento->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')->where('plano_pagamentos.id', '=', $idPlanoPagamento)->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objOperadorFinanceiro  = $objFormaPagamento->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')->where('operador_financeiros.id', '=', $idOperadorFinanceiro)->first();
        $objPessoa              = Pessoa::where('active', '=', 'yes')->where('id', '=', $idPessoa)->first();

        $vrCobranca   = Utilitarios::removeMaskMoney($vrCobranca);

        if (!$objPessoa) {
            $erros[] = 'A pessoa de código nº ' . $idPessoa . ' não foi identificada.';
        }

        if (!$objFormaPagamento) {
            $erros[] = 'A forma de pagamento de código nº ' . $idFormaPagamento . ' não foi identificada.';
        }

        if (!$objPlanoPagamento) {
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
}
