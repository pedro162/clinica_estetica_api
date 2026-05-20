<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\WorkOrder\CancelingMotive;

use App\Domain\WorkOrderCancelingMotive\Entities\WorkOrderCancelingMotive;
use App\Domain\WorkOrderCancelingMotive\Repositories\WorkOrderCancelingMotiveRepositoryInterface;
use App\Domain\WorkOrderCancelingMotive\ValueObjects\WorkOrderCancelingMotiveId;
use App\MotivoCancelamentoOrdemServico as CancelingMotiveModel;
use Illuminate\Support\Facades\Auth;

class CancelingMotiveRepository implements WorkOrderCancelingMotiveRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(WorkOrderCancelingMotiveId $id): ?CancelingMotiveModel
    {
        return CancelingMotiveModel::with([])
            ->where('active', '=', 'yes')
            ->where('id', '=', (string)$id)
            ->first();
    }

    public function save(WorkOrderCancelingMotive $parameter): ?CancelingMotiveModel
    {
        $userId = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        $entity->tenant_id = $this->getTenantId();
        $entity->active = $entity->active ? $entity->active : 'yes';

        unset($entity->id);
        $entity->save();

        return $this->findById(new WorkOrderCancelingMotiveId((string)$entity->id));
    }

    public function update(WorkOrderCancelingMotive $parameter): void
    {
        $entity = $parameter->build();

        $data = $entity->toArray();
        $data['user_update_id'] = Auth::user()->id;
        unset($data['tenant_id']);

        CancelingMotiveModel::findOrFail((string)$parameter->getId())->update($data);
    }

    public function destroy(WorkOrderCancelingMotive $parameter): void
    {
        $entity = $parameter->build();

        $data = $entity->toArray();
        unset($data['tenant_id']);

        $data['active'] = 'no';
        $cancelingMotive = CancelingMotiveModel::findOrFail((string)$parameter->getId());

        $cancelingMotive->update($data);
        $cancelingMotive->delete();
    }

    public function getAll(array $filter = []): ?array
    {
        if (!isset($filter['ordem'])) {
            $filter['ordem'] = 'id-desc';
        }

        $ordem = $filter['ordem'];
        $parse = [
            'id' => 'id',
            'motivo' => 'motivo',
            'motive' => 'motivo',
        ];

        $query = CancelingMotiveModel::query()->with([]);

        if (!empty($filter)) {
            foreach ($filter as $key => $val) {
                switch (trim($key)) {
                    case 'id':
                    case 'codigo_to_search':
                        $val = (string) $val;

                        if (is_string($val)) {
                            $val = trim($val, ',');
                        }

                        $val = array_map(function ($item) {
                            return trim($item);
                        }, explode(',', $val));

                        $query->whereIn('id', $val);
                        break;

                    case 'motivo':
                    case 'motive':
                    case 'nome_movivo':
                        if (is_string($val)) {
                            $val = trim($val, ',');
                        }

                        $query->where('motivo', 'like', '%' . $val . '%');
                        break;

                    case 'limite':
                        $val = (int) $val;

                        if ($val > 0) {
                            $query->limit($val);
                        }

                        break;

                    case 'ordem':
                        $val = trim($val, ',');
                        $orders = explode(',', $val);

                        foreach ($orders as $ord) {
                            $current = explode('-', $ord);
                            $field = $parse[$current[0]] ?? null;

                            if ($field && isset($current[1])) {
                                $query->orderBy($field, $current[1]);
                            }
                        }

                        break;

                    case 'campos':
                        break;
                }
            }
        }

        $ordemArr = explode('-', $ordem);
        $oremCampo = $ordemArr[0] ?? 'id';
        $oremTipo = $ordemArr[1] ?? 'desc';

        $usePaginate = (int) ($filter['usePaginate'] ?? 0);
        $nrItensPerPage = isset($filter['nr_itens_per_page']) && $filter['nr_itens_per_page'] > 0
            ? $filter['nr_itens_per_page']
            : self::ITENS_PER_PAGE;

        $query->where('active', 'yes')->orderBy($oremCampo, $oremTipo);

        $registro = $usePaginate
            ? $query->paginate($nrItensPerPage)
            : $query->get();

        if (!empty($filter['to_require'])) {
            $dataToRequest = [];

            foreach ($registro as $reg) {
                $dataToRequest[] = [
                    'label' => $reg->motivo,
                    'value' => $reg->id,
                ];
            }

            $registro = $dataToRequest;
        }

        return ['registro' => $registro];
    }

    protected function getTenantId(): int
    {
        return Auth::user()->tenant_id;
    }
}
