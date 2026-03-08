<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Cashier;

use App\Caixa;
use App\Domain\Cashier\Entities\Cashier;
use App\Domain\Cashier\Repositories\CashierRepositoryInterface;
use App\Domain\Cashier\ValueObjects\CashierId;
use Illuminate\Support\Facades\Auth;

;

class CashierRepository implements CashierRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(CashierId $id): ?Caixa
    {
        return Caixa::where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
    }

    public function save(Cashier $parameter): ?Caixa
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        $entity->tenant_id = $this->getTenantId();

        unset($entity->id);
        $entity->save();
        return $this->findById(new CashierId((string)$entity->id));
    }

    public function update(Cashier $parameter): void
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_update_id = $userId;

        $data = $entity->toArray();

        if (isset($data['tenant_id']) && $data['tenant_id'] == 0) {
            unset($data['tenant_id']);
        }

        Caixa::find($entity->id)->update($data);
    }

    public function getAll(array $filter = []): ?array
    {
        $ordem = $filter['ordem'] ?? 'id-desc';
        $parse = [
            'caixa_name' => 'name',
            'name_caixa' => 'name',
        ];

        $query = Caixa::query();

        // Filtros
        foreach ($filter as $key => $val) {
            $val = is_string($val) ? trim($val, ',') : $val;

            switch (trim($key)) {
                case 'id':
                    $ids = explode(',', $val);
                    $query->whereIn('id', $ids);
                    break;

                case 'name':
                case 'caixa_name':
                case 'name_caixa':
                    $query->where('name', 'like', '%' . $val . '%');
                    break;

                case 'caixa_id':
                    $query->where('id', $val);
                    break;

                case 'limite':
                    if ((int)$val > 0) {
                        $query->limit((int)$val);
                    }
                    break;

                case 'ordem':
                    $ordens = explode(',', $val);
                    foreach ($ordens as $ordemItem) {
                        [$campo, $dir] = explode('-', $ordemItem);
                        $campo = $parse[$campo] ?? $campo;
                        $query->orderBy($campo, $dir);
                    }
                    break;

                case 'campos':
                    if (is_array($val) && count($val) > 0) {
                        $query->select($val);
                    }
                    break;
            }
        }

        // Ordenação padrão
        if (!isset($filter['ordem'])) {
            [$campo, $dir] = explode('-', $ordem);
            $query->orderBy($campo, $dir);
        }

        // Ativo
        $query->where('active', 'yes');

        // Paginação
        $usePaginate = (int)($filter['usePaginate'] ?? 0);
        $nrItensPerPage = $filter['nr_itens_per_page'] ?? self::ITENS_PER_PAGE;

        $result = $usePaginate > 0
            ? $query->paginate($nrItensPerPage)
            : $query->get();

        // Retorno formatado para <select> ou autocomplete
        if (!empty($filter['to_require'])) {
            $result = $result->map(fn ($r) => [
                'label' => $r->name,
                'value' => $r->id,
            ]);
        }

        return ['registro' => $result];
    }

    protected function getTenantId(): int
    {
        return Auth::user()->tenant_id;
    }
}
