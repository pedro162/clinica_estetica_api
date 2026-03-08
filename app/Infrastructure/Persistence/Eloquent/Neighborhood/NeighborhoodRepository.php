<?php

namespace App\Infrastructure\Persistence\Eloquent\Neighborhood;

use App\Bairro as NeighborhoodModel;
use App\Domain\Neighborhood\Entities\Neighborhood;
use App\Domain\Neighborhood\Repositories\NeighborhoodRepositoryInterface;
use App\Domain\Neighborhood\ValueObjects\NeighborhoodId;
use Illuminate\Support\Facades\Auth;

class NeighborhoodRepository implements NeighborhoodRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(NeighborhoodId $id): ?NeighborhoodModel
    {
        return NeighborhoodModel::with([])
            ->where('active', '=', 'yes')
            ->where('id', '=', (string)$id)
            ->first();
    }

    public function save(Neighborhood $parameter): ?NeighborhoodModel
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        $entity->tenant_id = $this->getTenantId();
        $entity->active = $entity->active ? $entity->active : 'yes';

        unset($entity->id);
        $entity->save();

        return $this->findById(new NeighborhoodId((string)$entity->id));
    }

    public function update(Neighborhood $parameter): void
    {
        $entity = $parameter->build();

        $data = $entity->toArray();
        unset($data['tenant_id']);

        NeighborhoodModel::findOrFail((string)$parameter->getId())->update($data);
    }

    public function destroy(Neighborhood $parameter): void
    {
        $entity = $parameter->build();

        $data = $entity->toArray();
        unset($data['tenant_id']);

        $data['active'] = 'no';
        $category = NeighborhoodModel::find((string)$parameter->getId());

        $category->update($data);
        $category->delete();
    }

    public function getAll(array $filter = []): ?array
    {
        if (!isset($filter['ordem'])) {
            $filter['ordem'] = 'id-desc';
        }

        $ordem = $filter['ordem'];
        $parse = [];

        $query = NeighborhoodModel::query();

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

                    case 'name':
                    case 'nome_item':
                        if (is_string($val)) {
                            $val = trim($val, ',');
                        }

                        $query->where('name', 'like', '%' . $val . '%');
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
                    'label' => $reg->name,
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
