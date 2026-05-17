<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\WorkOrder;

use App\Domain\WorkOrder\Entities\WorkOrder;
use App\Domain\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Domain\WorkOrder\ValueObjects\WorkOrderId;
use App\OrdemServico;
use Illuminate\Support\Facades\Auth;

class WorkOrderRepository implements WorkOrderRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(WorkOrderId $id): ?OrdemServico
    {
        return OrdemServico::with([
            'pessoa',
            'cobranca',
            'cobranca.formaPgto',
            'cobranca.planoPgto',
            'cobranca.operadorFinanceiro',
            'item',
            'item.servico',
            'rca.pessoa',
            'profissional.pessoa',
            'filial',
            'filial.pessoa'
        ])
            ->where('ordem_servicos.active', '=', 'yes')
            ->where('ordem_servicos.id', '=', (string)$id)
            ->first();
    }

    public function save(WorkOrder $parameter): ?OrdemServico
    {
        $userId = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        $entity->tenant_id = $this->getTenantId();
        $entity->active = $entity->active ? $entity->active : 'yes';

        unset($entity->id);
        $entity->save();

        return $this->findById(new WorkOrderId((string)$entity->id));
    }

    public function update(WorkOrder $parameter): void
    {
        $entity = $parameter->build();

        $data = $entity->toArray();
        $data['user_update_id'] = Auth::user()->id;
        unset($data['tenant_id']);

        OrdemServico::findOrFail((string)$parameter->getId())->update($data);
    }

    public function destroy(WorkOrder $parameter): void
    {
        $entity = $parameter->build();

        $data = $entity->toArray();
        unset($data['tenant_id']);

        $data['active'] = 'no';
        $workOrder = OrdemServico::find((string)$parameter->getId());

        $workOrder->update($data);
        $workOrder->delete();
    }

    public function getAll(array $filter = []): ?array
    {
        if (!isset($filter['ordem'])) {
            $filter['ordem'] = 'id-desc';
        }

        $ordem = $filter['ordem'];
        $parse = [];

        $query = OrdemServico::query()->with([
            'pessoa',
            'cobranca',
            'cobranca.formaPgto',
            'cobranca.planoPgto',
            'cobranca.operadorFinanceiro',
            'item',
            'item.servico',
            'rca.pessoa',
            'profissional.pessoa',
            'filial',
            'filial.pessoa'
        ]);

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

                    case 'status':
                        if (is_string($val)) {
                            $val = trim($val, ',');
                        }

                        $query->where('status', 'like', '%' . $val . '%');
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
                        if (is_array($val) && count($val) > 0) {
                            // ...existing code...
                        }
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
                    'label' => $reg->id,
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
