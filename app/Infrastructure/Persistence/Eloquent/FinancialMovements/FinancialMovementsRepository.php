<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\FinancialMovements;

use App\FinanceiroMovimentacoe;
use App\Domain\FinancialMovements\Entities\FinancialMovements;
use App\Domain\FinancialMovements\Repositories\FinancialMovementsRepositoryInterface;
use App\Domain\FinancialMovements\ValueObjects\FinancialMovementsId;
use Illuminate\Support\Facades\Auth;;

class FinancialMovementsRepository implements FinancialMovementsRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(FinancialMovementsId $id): ?FinanceiroMovimentacoe
    {
        return FinanceiroMovimentacoe::where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
    }

    public function save(FinancialMovements $parameter): ?FinanceiroMovimentacoe
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
        return $this->findById(new FinancialMovementsId((string)$entity->id));
    }

    public function update(FinancialMovements $parameter): void
    {
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        $data = $entity->toArray();

        FinanceiroMovimentacoe::find($entity->id)->update($data);
    }

    public function getAll(array $filter = []): ?array
    {
        $query = FinanceiroMovimentacoe::with(['caixa', 'contaReceber']);

        $ordem = $filter['ordem'] ?? 'id-desc';
        $ordemArr = explode('-', $ordem);
        $orderField = $ordemArr[0] ?? 'id';
        $orderType = $ordemArr[1] ?? 'desc';

        foreach ($filter as $key => $value) {
            if (is_string($value)) {
                $value = trim($value, ',');
                $value = explode(',', $value);
            }

            switch ($key) {
                case 'id':
                case 'caixa_id':
                case 'referencia_id':
                case 'sub_referencia_id':
                case 'conciliado':
                case 'tp_movimentacao':
                case 'estornado':
                    $query->whereIn($key, $value);
                    break;

                case 'historico':
                case 'referencia':
                case 'sub_referencia':
                    $query->where($key, 'like', "%$value%");
                    break;


                case 'dt_exercicio':
                case 'dt_periodo':
                    $tpExercicio = $filter['tp_exercicio'] ?? 'created_at';

                    if (count($value) === 2) {
                        $query->whereBetween('fm.' . $tpExercicio, [$value[0] . ' 00:00:00', $value[1] . ' 23:59:59']);
                    }

                case 'limite':
                    $query->limit((int) $value);
                    break;
            }
        }

        $query->orderBy($orderField, $orderType);

        if (!empty($filter['usePaginate'])) {
            $perPage = $filter['nr_itens_per_page'] ?? self::ITENS_PER_PAGE;
            $registro = $query->paginate($perPage);
        } else {
            $registro = $query->get();
        }

        if (!empty($filter['to_require'])) {
            $registro = $registro->map(fn($item) => [
                'label' => $item->historico,
                'value' => $item->id
            ])->toArray();
        }

        return  ['registro' => $registro];
    }
}
