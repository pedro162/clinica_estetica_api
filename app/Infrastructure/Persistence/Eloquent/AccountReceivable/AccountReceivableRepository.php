<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\AccountReceivable;

use App\ContaReceber;
use App\ContaReceberItem;
use App\Domain\AccountReceivable\Entities\AccountReceivable;
use App\Domain\AccountReceivable\Repositories\AccountReceivableRepositoryInterface;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableId;
use Illuminate\Support\Facades\Auth;;

class AccountReceivableRepository implements AccountReceivableRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(AccountReceivableId $id): ?ContaReceber
    {
        return ContaReceber::with(['pessoa.logradouro', 'filial', 'formaPagamento', 'planoPagamento', 'operadorFinanceiro'])->where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
    }

    public function save(AccountReceivable $parameter): ?ContaReceber
    {
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        $entity->responsavel_id = $entity->responsavel_id > 0 ? $entity->responsavel_id : Auth::user()->pessoa->id;
        $entity->tenant_id = $tenantId;
        unset($entity->id);

        $entity->save();

        return $this->findById(new AccountReceivableId((string)$entity->id));
    }

    public function update(AccountReceivable $parameter): void
    {
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        $entity->tenant_id = $tenantId;

        $data = $entity->toArray();

        ContaReceber::find($entity->id)->update($data);
    }

    public function getLiquidityBillingByMonthYear(array $data = []): ?array
    {
        $rawSqlYear = \DB::raw('YEAR(cr.created_at)');
        $rawSqlMes = \DB::raw('MONTH(cr.created_at)');
        $rawSqlDia = \DB::raw('DAY(cr.created_at)');
        $rawSqlFilial = \DB::raw('cr.filial_id');

        $data['campos'] = [
            \DB::raw('SUM(IFNULL(cr.vrLiquido, 0)) as vrFaturamentoLiquidez'),
            \DB::raw('YEAR(cr.created_at) as anoFaturamentoLiquidez'),
            \DB::raw('MONTH(cr.created_at) as mesFaturamentoLiquidez'),
            //\DB::raw('DAY(cr.created_at) as diaFaturamentoLiquidez'),
            \DB::raw('cr.filial_id as filial_id'),
        ];

        $data['raw_grop_by'] = "{$rawSqlFilial},{$rawSqlYear},{$rawSqlMes}";

        return $this->getAll($data);
    }

    public function getLiquidityBillingByBranch(array $data = []): ?array
    {
        $rawSqlYear = \DB::raw('YEAR(cr.created_at)');
        $rawSqlMes = \DB::raw('MONTH(cr.created_at)');
        $rawSqlDia = \DB::raw('DAY(cr.created_at)');
        $rawSqlFilial = \DB::raw('cr.filial_id');

        $data['campos'] = [
            \DB::raw('SUM(IFNULL(cr.vrLiquido, 0)) as vrFaturamentoLiquidez'),
            \DB::raw('cr.filial_id as filial_id'),
        ];

        $data['raw_grop_by'] = "{$rawSqlFilial}";

        return $this->getAll($data);
    }

    public function getLiquidityBillingByProfessional(array $data = []): ?array
    {
        $rawSqlYear         = \DB::raw('YEAR(cr.created_at)');
        $rawSqlProfi        = \DB::raw('IFNULL(os.profissional_id, "000000")');
        $rawSqlProfiNome   = \DB::raw('IFNULL(pprof.name, "Sem profissíonal")');

        $data['campos'] = [
            \DB::raw('SUM(IFNULL(cr.vrLiquido, 0)) as vrFaturamentoLiquidez'),
            \DB::raw('IFNULL(os.profissional_id, "000000") as profissional_id'),
            \DB::raw('IFNULL(pprof.name, "Sem profissíonal") as name_profissional'),
        ];

        $data['raw_grop_by']        = "{$rawSqlProfi},{$rawSqlProfiNome}";
        $data['com_ordem_servico']  = true;

        return $this->getAll($data);
    }

    public function getAll(array $filter = []): ?array
    {
        if (!isset($filter['ordem'])) {
            $filter['ordem'] =  'id-desc';
        }

        $data = $filter;
        $consulta = $filter;

        if (!isset($consulta['ordem'])) {
            $consulta['ordem'] =  'id-desc';
        }

        $ordem      = $consulta['ordem'] ?? 'id-desc';
        $campos =  $data['campos'] ?? [];
        $parse = [
            'id' => 'cr.id',
            'name' => 'pessoas.name',
            'filial_id' => 'cr.filial_id',
        ];

        $registro = \DB::table('conta_recebers as cr');
        $registro->join('pessoas', function ($join) {
            $join->on('pessoas.id', '=', 'cr.pessoa_id');
        })->join('filials as fl', function ($join) {

            $join->on('cr.filial_id', '=', 'fl.id');
        })->join('pessoas as pesfl', function ($join) {

            $join->on('fl.pessoa_id', '=', 'pesfl.id');
        })->join('forma_pagamentos as fp', function ($join) {
            $join->on('fp.id', '=', 'cr.forma_pagamento_id');
        });

        if (isset($data['com_ordem_servico'])) {
            $registro->leftJoin('ordem_servicos as os', function ($join) {
                $join->on('os.id', '=', 'cr.referencia_id')->on('cr.referencia', '=',  \DB::raw('"ordem_servicos"'));
            })->join('profissionals as prof', function ($join) {
                $join->on('prof.id', '=', 'os.profissional_id');
            })->join('pessoas as pprof', function ($join) {
                $join->on('pprof.id', '=', 'prof.pessoa_id');
            });
        }

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
                        }

                        $val = explode(',', $val);
                        $registro->whereIn('cr.id', $val);
                        break;
                    case 'nmPessoa':
                    case 'pessoa_name':
                    case 'name_pessoa':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('pessoas.name', 'like', '%' . $val . '%');
                        }
                        break; //
                    case 'vencido':

                        if (is_string($val)) {
                            $registro->whereIn('cr.status', ['aberto']);

                            if (trim($val) == 'yes') {
                                $registro->where('cr.dtVencimento', '<', date('Y-m-d'));
                            } elseif (trim($val) == 'no') {
                                $registro->where('cr.dtVencimento', '>=', date('Y-m-d'));
                            }
                        }

                        break;
                    case 'dt_exercicio':
                        $tpExercicio = 'dtVencimento';

                        if (isset($consulta['tp_exercicio'])) {
                            switch ($consulta['tp_exercicio']) {
                                case 'created_at':
                                case 'criacao':
                                    $tpExercicio = 'created_at';
                                    break;
                                case 'vencimento':
                                    $tpExercicio = 'dtVencimento';
                                    break;

                                default:
                                    $tpExercicio = 'dtVencimento';
                                    break;
                            }
                            $tpExercicio = 'dtVencimento';
                        }
                        if (is_string($val) && strpos($val, ',') > -1) {
                            $val = explode(',', $val);
                            $registro->where('cr.' . $tpExercicio, '>=', date($val[0]));
                            $registro->where('cr.' . $tpExercicio, '<=', date($val[1]));
                        }

                        break;

                    case 'pessoa_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('pessoas.id', $val);
                        }
                        break;
                    case 'filial_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }

                        $val = explode(',', $val);

                        $registro->whereIn('cr.filial_id', $val);
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

                        $registro->whereIn('cr.referencia_id', $val);
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

                            $registro->whereIn('cr.referencia', $val);
                        }
                        break;
                    case 'status':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('cr.status', $val);
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
                    case 'grop_by':
                        $registro->groupBy($val);
                        break;
                    case 'raw_grop_by':
                        $registro->groupByRaw($val);
                        break;
                }
            }
        }

        $sqlDsReferencia = '(
                    CASE 
                        WHEN cr.referencia = "ordem_servicos" THEN "Ordem de serviço"
                        ELSE "Referência não mapeada"
                    END
                )
                as dsReferencia
            ';
        if ($campos) {
            $registro->select($campos);
        } else {
            $registro->select('cr.*', \DB::raw('(IFNULL(cr.vrLiquido, 0) - (IFNULL(cr.vrPago, 0) + IFNULL(cr.vrDevolvido, 0) - IFNULL(cr.vrTaxa, 0)  - IFNULL(cr.vrJuros, 0)))  vrAberto'), \DB::raw($sqlDsReferencia), 'fp.cdCobrancaTipo', 'fp.name as name_cob_tp', 'pessoas.name', 'pesfl.name as name_filial');
        }

        $ordemArr   = explode('-', $ordem);
        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $usePaginate = $consulta['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::ITENS_PER_PAGE;

        if ($usePaginate > 0) {
            $registro   = $registro->where('cr.active', '=', 'yes')
                ->where('pessoas.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->where('cr.active', '=', 'yes')
                ->where('pessoas.active', '=', 'yes')->get();
        }

        if (isset($consulta['to_require']) && $consulta['to_require'] == true) {
            $dataToRequest = [];
            foreach ($registro as $reg) {
                $dataToRequest[] = ['label' => $reg->name, 'value' => $reg->id];
            }

            $registro = $dataToRequest;
        }

        return  ['registro' => $registro];
    }

    public function sumOpenNetAmounts(AccountReceivableId $id): ?float
    {
        return ContaReceberItem::where('conta_receber_id', (string)$id)
            ->where('status', 'aberto')
            ->where('active', 'yes')
            ->sum('vrLiquido');
    }
}
