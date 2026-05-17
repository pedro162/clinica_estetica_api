<?php

namespace App\Helpers;

use App\Caixa;
use App\ContaReceber as CobrancaReceber;
use App\ContaReceberItem;
use App\Exceptions\FinanceiroMovimentacoeException;
use App\FinanceiroMovimentacoe;
use App\Utilitarios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinanceiroMovimentacoeHelper extends BaseHelper
{
    public function store(array $dados)
    {

        $caixa_id = $dados['caixa_id'];

        $objCaixaHelper = new CaixaHelper();
        $vrSaldo         = $objCaixaHelper->getSaldoCaixa($caixa_id);

        $vrMovimentacao = $dados['vr_movimentacao'];
        $vrMovimentacao = Utilitarios::removeMaskMoney($vrMovimentacao);

        $vrSaldoFinal     = $vrSaldo + $vrMovimentacao;

        $dadosRequest = $dados;

        $dadosRequest['referencia_id']      = $dados['referencia_id'];
        $dadosRequest['referencia']            = $dados['referencia'];
        $dadosRequest['historico']          = $dados['ds_observacao'] ?? $dados['historico'];
        $dadosRequest['caixa_id']            = $caixa_id;
        $dadosRequest['vr_saldo_anterior']  = $vrSaldo;
        $dadosRequest['vr_movimentacao']    = $vrMovimentacao;
        $dadosRequest['vr_saldo']            = $vrSaldoFinal;
        $dadosRequest['conciliado']         = 'no';
        $dadosRequest['estornado']            = 'no';
        $dadosRequest['hash_operacao']         = null;

        $dadosRequest['user_id']          = \Auth::User()->id; //trocar pelo id do usuario logado
        $dadosRequest['active']           = 'yes';

        $registro = FinanceiroMovimentacoe::create($dadosRequest);

        if (!$registro) {
            throw new OrdemServicoException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte.');
        }

        return $registro;
    }
    public function update(array $data, int $id)
    {
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


        if ($registro->referencia_id > 0 && $registro->referencia == 'conta_recebers') {
            $registro->data_referencia = CobrancaReceber::find($registro->referencia_id);
            if ($registro->data_referencia) {
                $registro->data_referencia->pessoa;
                $registro->data_referencia->contaReceberItem;
            }
        }

        $registro->caixa;
        if ($registro->user) {
            $registro->user->pessoa;
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

        if (! isset($consulta['ordem'])) {

            $consulta['ordem'] =  'id-desc';
        }

        $ordem      = $consulta['ordem'] ?? 'id-desc';
        $campos =  null;
        $parse = [
            'id' => 'fm.id',
            'historico' => 'fm.historico',
            'name' => 'cx.name',
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
                    case 'historico':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }

                        $registro->where('fm.historico', 'like', '%' . $val . '%');

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
                    case 'referencia':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }

                        $val = explode(',', $val);

                        $registro->whereIn('fm.referencia', $val);

                        break;
                    case 'sub_referencia_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }

                        $val = explode(',', $val);

                        $registro->whereIn('fm.sub_referencia_id', $val);

                        break;
                    case 'sub_referencia':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }

                        $val = explode(',', $val);

                        $registro->whereIn('fm.sub_referencia', $val);
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
                    case 'tp_movimentacao':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);
                        }

                        $registro->whereIn('fm.tp_movimentacao', $val);
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
                    case 'dt_exercicio':
                    case 'dt_periodo':
                        $tpExercicio = $consulta['tp_exercicio'] ?? 'created_at';
                        $datas = explode(',', $val);

                        if (count($datas) === 2) {
                            $registro->whereBetween('fm.' . $tpExercicio, [$datas[0] . ' 00:00:00', $datas[1] . ' 23:59:59']);
                        }

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
            $registro->select('fm.*', DB::raw($sqlDsReferencia), 'cx.name as caixa_name', 'cx.filial_id');
        }


        //----
        $ordemArr   = explode('-', $ordem);
        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $usePaginate = $consulta['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::PAGINACAO_ITENS_POR_PAGINA_PADRAO;
        if ($usePaginate > 0) {
            $registro   = $registro->where('fm.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->where('fm.active', '=', 'yes')->get();
        }


        if (isset($consulta['to_require']) && $consulta['to_require'] == true) {
            $dataToRequest = [];
            foreach ($registro as $reg) {
                $dataToRequest[] = ['label' => $reg->historico, 'value' => $reg->id];
            }

            $registro = $dataToRequest;
        }

        return  $registro;
    }

    public function estornarMovimentacaoContaReceber(
        ContaReceberItem $contaReceberItem,
        Caixa $caixa
    ): bool {
        $hashOperacao = $contaReceberItem->hashBaixa ?? $contaReceberItem->rashBaixa ?? null;

        if (empty($hashOperacao)) {
            return false;
        }

        $movimentacoesEstornar = FinanceiroMovimentacoe::where(
            'hash_operacao',
            $hashOperacao
        )
            ->where('estornado', 'no')
            ->where('active', 'yes')
            ->orderBy('id', 'asc')
            ->get();

        if ($movimentacoesEstornar->isEmpty()) {
            return false;
        }

        $idsMovimentacoes = $movimentacoesEstornar->pluck('id')->all();

        FinanceiroMovimentacoe::whereIn('id', $idsMovimentacoes)
            ->update(['estornado' => 'yes']);

        $objCaixaHelper = app(CaixaHelper::class);
        $saldoAtual = $objCaixaHelper->getSaldoCaixa($caixa->id);
        $userId = Auth::user()->id;

        $novasMovimentacoes = [];

        foreach ($movimentacoesEstornar as $movimentacao) {
            $valorSaida = -1 * abs((float) $movimentacao->vr_movimentacao);
            $saldoAnterior = $saldoAtual;
            $saldoAtual += $valorSaida;

            $novasMovimentacoes[] = [
                'referencia_id' => $movimentacao->referencia_id,
                'referencia' => $movimentacao->referencia,
                'sub_referencia_id' => $movimentacao->sub_referencia_id,
                'sub_referencia' => $movimentacao->sub_referencia,
                'historico' => $movimentacao->historico,
                'caixa_id' => $caixa->id,
                'vr_saldo_anterior' => $saldoAnterior,
                'vr_movimentacao' => $valorSaida,
                'vr_saldo' => $saldoAtual,
                'tp_movimentacao' => 'negativa',
                'conciliado' => 'no',
                'estornado' => 'yes',
                'hash_operacao' => $hashOperacao,
                'user_id' => $userId,
                'active' => 'yes',
                'tenant_id' => $movimentacao->tenant_id,
            ];
        }

        return FinanceiroMovimentacoe::insert($novasMovimentacoes);
    }
}
