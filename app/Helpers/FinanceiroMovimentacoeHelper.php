<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Utilitarios;
use \App\ContaReceber;
use \App\ContaReceber as CobrancaReceber;
use \App\ContaReceberItem;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\ContaReceberCartao;
use \App\Helpers\ContaReceberCartaoHelper;
use \App\Helpers\ContaReceberItemHelper;
use \App\Helpers\CaixaHelper;
use \App\Pessoa;
use \App\Caixa;
use \App\FinanceiroMovimentacoe;
use \App\Exceptions\CobrancaReceberException;

class FinanceiroMovimentacoeHelper
{

	public function store(array $dados){
        
        $caixa_id = $dados['caixa_id'];

        $objCaixaHelper = new CaixaHelper();
        $vrSaldo 		= $objCaixaHelper->getSaldoCaixa($caixa_id);

        $vrMovimentacao = $dados['vr_movimentacao'];
        $vrMovimentacao = Utilitarios::removeMaskMoney($vrMovimentacao);  

        $vrSaldoFinal 	= $vrSaldo + $vrMovimentacao;

        $dadosRequest = [];

        $dadosRequest['referencia_id']      = $dados['referencia_id'];
        $dadosRequest['referencia']    		= $dados['referencia'];
        $dadosRequest['historico']  		= $dados['ds_observacao'] ?? $dados['historico'];
        $dadosRequest['caixa_id']        	= $caixa_id;
        $dadosRequest['vr_saldo_anterior']  = $vrSaldo;
        $dadosRequest['vr_movimentacao']    = $vrMovimentacao;
        $dadosRequest['vr_saldo']    		= $vrSaldoFinal;
        $dadosRequest['conciliado']     	= 'no';
        $dadosRequest['estornado']    		= 'no';
        $dadosRequest['hash_operacao']     	= null;

        $dadosRequest['user_id']          = \Auth::User()->id; //trocar pelo id do usuario logado
        $dadosRequest['active']           = 'yes';

        $registro = FinanceiroMovimentacoe::create($dadosRequest);

        if (!$registro) {
            throw new OrdemServicoException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte.');
        }

        return $registro;
    }
}