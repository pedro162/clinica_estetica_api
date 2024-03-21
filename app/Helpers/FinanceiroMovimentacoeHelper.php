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
use \App\Exceptions\FinanceiroMovimentacoeException;

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
    }public function update(array $data, int $id){
        $dadosRequest = [];

        $dadosRequest['descricao']                  = $data['descricao'];
        $dadosRequest['user_update_id']             = \Auth::User()->id;
        $dadosRequest['active']                     =  'yes';

        $registro = FinanceiroMovimentacoe::where('active', '=', 'yes')->where('id', '=', $id)->first();
        if (!$registro) {
            throw new FinanceiroMovimentacoeException('Registro não identificado');
        }
        
        $registro->update($dadosRequest);

        return $registro;
    }

    public function info(array $data, $id, $idAssistente = 0)
    {

        $dados = $data;
        $id = $id ?? $dados['id'];
        $callBack = $dados['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ($id <= 0) {
            throw new FinanceiroMovimentacoeException('Parâmetro ínválido');
        }


        $registro = FinanceiroMovimentacoe::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if ($registro == null) {
            throw new FinanceiroMovimentacoeException('Registro não encontrado');
        }

        return $registro;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json(array $data)
    {
        $consulta = $data;

        if(! isset($consulta['ordem'])){

             $consulta['ordem'] =  'id-desc';
        }

        $campos =  null;
        $parse = [
            'id'=>'fm.id',
            'historico'=>'fm.historico',
            'name'=>'cx.name',
        ];

        $registro = \DB::table('financeiro_movimentacoes as fm');
        $registro->join('caixas as cx', function ($join) {
            $join->on('cx.id', '=', 'fm.caixa_id');
        });

        if (is_array($consulta) && count($consulta) > 0) {
            foreach ($consulta as $key => $val) {

                switch (trim($key)) {
                    case 'id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                           
                        }
                        $registro->whereIn('fm.id', $val);
                        
                        break;
                    case 'caixa_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                           
                        }
                        $registro->whereIn('fm.caixa_id', $val);
                        
                        break;
                    case 'referencia_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }

                        $val = explode(',', $val);

                        $registro->whereIn('fm.referencia_id', $val);

                        break;
                    case 'historico':
                        if(is_string($val)){
                            
                            if($val[0] == ','){
                                $val = substr($val, 1);
                            } 
                            if($val[strlen($val) - 1] == ','){
                                $val = substr($val, 0, -1);
                            }
                            
                        }
                        
                        $registro->where('fm.historico', 'like' , '%'.$val.'%');

                        break;
                    case 'referencia':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('fm.referencia', $val);
                        }
                        break;
                    case 'conciliado':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);
                        }

                        $registro->whereIn('fm.conciliado', $val);
                        break;
                    case 'estornado':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);
                        }

                        $registro->whereIn('fm.estornado', $val);
                        break;
                    case 'limite':
                        $val = (int) $val;
                        if (is_integer($val) && $val > 0) {

                            $registro->limit($val);
                        }
                        break;
                    case 'ordem':


                        if ($val[0] == ',') {
                            $val = substr($val, 1);
                        }
                        if ($val[strlen($val) - 1] == ',') {
                            $val = substr($val, 0, -1);
                        }

                        $val = explode(',', $val);
                        for ($i = 0; !($i == count($val)); $i++) {
                            $atual = explode('-', $val[$i]);
                            if (array_key_exists(trim($atual[0]), $parse)) {

                                $parsed = $parse[trim($atual[0])];

                                if ($parsed) {

                                    $registro->orderBy($parsed, $atual[1]);
                                }
                            }
                        }

                        break;

                    case 'campos':
                        if (is_array($val) && count($val) > 0) {
                            //$campos = $this->montaCamposConsulta($registro, $val);

                        }
                        break;
                }
            }
        }
        $sqlDsReferencia = '(
                    CASE 
                        WHEN fm.referencia = "conta_recebers" OR fm.referencia = "conta_receber_items"  THEN "Contas a receber"
                        WHEN fm.referencia = "conta_pargars" OR fm.referencia = "conta_pagar_items"  THEN "Contas a pagar"
                        ELSE "Referência não mapeada"
                    END
                )
                as dsReferencia
            ';
        if ($campos) {
            $registro->select($campos);
        } else {
            $registro->select('fm.*',  \DB::raw($sqlDsReferencia), 'cx.name as caixa_name', 'cx.filial_id');
        }

        $registro = $registro->where('fm.active', '=', 'yes')->get();


        if (isset($consulta['to_require']) && $consulta['to_require'] == true) {
            $dataToRequest = [];
            foreach ($registro as $reg) {
                $dataToRequest[] = ['label' => $reg->historico, 'value' => $reg->id];
            }

            $registro = $dataToRequest;
        }

        return  $registro;
    }
}