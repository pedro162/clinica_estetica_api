<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\AccountReceivableItem;

use App\ContaReceberItem;
use App\Domain\AccountReceivableItem\Entities\AccountReceivableItem;
use App\Domain\AccountReceivableItem\Repositories\AccountReceivableItemRepositoryInterface;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemId;
use Illuminate\Support\Facades\Auth;;

class AccountReceivableItemRepository implements AccountReceivableItemRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(AccountReceivableItemId $id): ?ContaReceberItem
    {
        return ContaReceberItem::where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
    }

    public function save(AccountReceivableItem $parameter): ?ContaReceberItem
    {
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        unset($entity->id);
        unset($entity->tenant_id);

        if (!app()->environment('testing')) {
            $entity->tenant_id = $tenantId;
        } else {
            unset($entity->filial_id);
        }

        $entity->save();
        return $this->findById(new AccountReceivableItemId((string)$entity->id));
    }

    public function update(AccountReceivableItem $parameter): void
    {
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        unset($entity->tenant_id);

        if (!app()->environment('testing')) {
            $entity->tenant_id = $tenantId;
        }

        $data = $entity->toArray();

        if (app()->environment('testing')) {
            unset($entity->filial_id);
            unset($data['filial_id']);
        }

        ContaReceberItem::find($entity->id)->update($data);
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
        ];

        $registro = \DB::table('conta_receber_items as cr');
        $registro->join('pessoas', function ($join) {
            $join->on('pessoas.id', '=', 'cr.pessoa_id');
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
                        break;
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
            $registro->select('cr.*', \DB::raw('(IFNULL(cr.vrLiquido, 0) - (IFNULL(cr.vrPago, 0) + IFNULL(cr.vrDevolvido, 0)))  vrAberto'), \DB::raw($sqlDsReferencia), 'fp.cdCobrancaTipo', 'fp.name as name_cob_tp', 'pessoas.name');
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
}
