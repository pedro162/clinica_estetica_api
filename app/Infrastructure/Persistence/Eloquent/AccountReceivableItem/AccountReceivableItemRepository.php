<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\AccountReceivableItem;

use App\ContaReceberItem;
use App\Domain\AccountReceivableItem\Entities\AccountReceivableItem;
use App\Domain\AccountReceivableItem\Repositories\AccountReceivableItemRepositoryInterface;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemId;
use Illuminate\Support\Facades\Auth;

class AccountReceivableItemRepository implements AccountReceivableItemRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;


    public function findById(AccountReceivableItemId $id): ?ContaReceberItem
    {
        return ContaReceberItem::with(['contaReceber.pessoa.logradouro', 'contaReceber.filial', 'movimentacao', 'formaPagamento'])->where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
    }

    public function save(AccountReceivableItem $parameter): ?ContaReceberItem
    {
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        $entity->tenant_id = $tenantId;
        unset($entity->id);

        $entity->save();
        return $this->findById(new AccountReceivableItemId((string)$entity->id));
    }

    public function update(AccountReceivableItem $parameter): void
    {
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $entity = $parameter->build();
        $entity->user_update_id = $userId;
        $entity->tenant_id = $tenantId;

        $data = $entity->toArray();
        ContaReceberItem::find($entity->id)->update($data);
    }

    public function getAll(array $filter = []): ?array
    {
        $filter['ordem'] = $filter['ordem'] ?? 'id-desc';
        $consulta = $filter;

        $ordem = explode('-', $consulta['ordem']);

        $query = ContaReceberItem::with([
            'formaPagamento',
            'contaReceber.pessoa',
            'contaReceber.filial.pessoa',
        ]);

        if (!empty($consulta['id'])) {
            $ids = explode(',', trim($consulta['id'], ','));
            $query->whereIn('id', $ids);
        }

        if (!empty($consulta['conta_receber_id'])) {
            $ids = explode(',', trim((string)$consulta['conta_receber_id'], ','));
            $query->whereIn('conta_receber_id', $ids);
        }

        if (!empty($consulta['filial_id'])) {
            $ids = explode(',', trim((string)$consulta['filial_id'], ','));
            $query->whereHas('contaReceber.filial', function ($subQuery) use ($ids) {
                $subQuery->whereIn('id', $ids);
            });
        }

        $personName = $consulta['nmPessoa']
            ?? $consulta['pessoa_name']
            ?? $consulta['name_pessoa'] ?? '';

        if (!empty($personName)) {
            $query->whereHas('contaReceber.pessoa', function ($subQuery) use ($personName) {
                $subQuery->where('name', 'like', '%' . $personName . '%');
            });
        }

        if (!empty($consulta['pessoa_id'])) {
            $query->whereHas('contaReceber.pessoa', function ($subQuery) use ($consulta) {
                $ids = explode(',', trim($consulta['pessoa_id'], ','));
                $subQuery->whereIn('id', $ids);
            });
        }

        if (!empty($consulta['dt_exercicio'])) {
            $tpExercicio = $consulta['tp_exercicio'] ?? 'dtBaixa';
            $datas = explode(',', $consulta['dt_exercicio']);

            if (count($datas) === 2) {
                $query->whereBetween($tpExercicio, [$datas[0], $datas[1]]);
            }
        }

        if (!empty($consulta['status'])) {
            $statuses = explode(',', trim($consulta['status'], ','));
            $query->whereIn('status', $statuses);
        }

        $descricao = $consulta['descricao']
            ?? $consulta['historico']
            ?? '';

        if (!empty($descricao)) {
            $statuses = explode(',', trim($descricao, ','));
            $query->where('descricao', 'like', '%' . $descricao . '%');
        }

        if (!empty($consulta['limite'])) {
            $query->limit((int)$consulta['limite']);
        }

        if (!empty($consulta['grop_by'])) {
            $query->groupBy($consulta['grop_by']);
        }

        if (!empty($consulta['raw_grop_by'])) {
            $query->groupByRaw($consulta['raw_grop_by']);
        }

        if (!empty($consulta['ordem'])) {
            $ordemArr = explode('-', $consulta['ordem']);
            $campo = $ordemArr[0];
            $tipo = $ordemArr[1] ?? 'asc';
            $query->orderBy($campo, $tipo);
        }

        $usePaginate = (int)($consulta['usePaginate'] ?? 0);
        $nrItensPerPage = $consulta['nr_itens_per_page'] ?? 15;

        if ($usePaginate > 0) {
            $registros = $query->where('active', 'yes')->paginate($nrItensPerPage);
        } else {
            $registros = $query->where('active', 'yes')->get();
        }

        if (!empty($consulta['to_require'])) {
            $registros->load(['contaReceber.pessoa']);

            $dataToRequest = $registros->map(fn ($registro) => [
                'label' => $registro->contaReceber->pessoa->name,
                'value' => $registro->id,
            ])->toArray();

            return ['registro' => $dataToRequest];
        }

        return ['registro' => $registros];
    }
}
