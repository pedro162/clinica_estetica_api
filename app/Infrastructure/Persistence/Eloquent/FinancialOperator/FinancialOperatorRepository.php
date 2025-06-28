<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\FinancialOperator;

use App\OperadorFinanceiro;
use App\Domain\FinancialOperator\Entities\FinancialOperator;
use App\Domain\FinancialOperator\Repositories\FinancialOperatorRepositoryInterface;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorId;
use Illuminate\Support\Facades\Auth;

class FinancialOperatorRepository implements FinancialOperatorRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(FinancialOperatorId $id): ?OperadorFinanceiro
    {
        return OperadorFinanceiro::with(['pessoa', 'filial'])->where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
    }

    public function save(FinancialOperator $parameter): ?OperadorFinanceiro
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        $entity->tenant_id = $this->getTenantId();
        $entity->active = $entity->active ? $entity->active : 'yes';

        unset($entity->id);
        $entity->save();
        return $this->findById(new FinancialOperatorId((string)$entity->id));
    }

    public function update(FinancialOperator $parameter): void
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_update_id = $userId;

        $data = $entity->toArray();

        if (isset($data['tenant_id']) && $data['tenant_id'] == 0) {
            unset($data['tenant_id']);
        }

        OperadorFinanceiro::findOrFail((string)$parameter->getId())->update($data);
    }

    public function destroy(FinancialOperator $parameter): void
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_update_id = $userId;

        $data = $entity->toArray();

        if (isset($data['tenant_id']) && $data['tenant_id'] == 0) {
            unset($data['tenant_id']);
        }

        $data['active'] = 'no';
        $paymentPlan = OperadorFinanceiro::find((string)$parameter->getId());

        $paymentPlan->update($data);
        $paymentPlan->delete();
    }

    public function getAll(array $filter = []): ?array
    {
        if (!isset($filter['ordem'])) {
            $filter['ordem'] = 'id-desc';
        }

        $ordem = $filter['ordem'];
        $campos = null;
        $query = OperadorFinanceiro::query()
            ->with(['pessoa', 'formaPagamento', 'filial']);

        if (!empty($filter)) {
            foreach ($filter as $key => $val) {
                switch (trim($key)) {
                    case 'id':
                        if (is_string($val)) {
                            $val = trim($val, ',');
                        }

                        $ids = explode(',', $val);
                        $query->whereIn('id', $ids);
                        break;
                    case 'forma_pagamentos_id':
                        if (is_string($val)) {
                            $val = trim($val, ',');
                        }

                        $ids = explode(',', $val);
                        $query->whereHas('formaPagamento', function ($q) use ($ids) {
                            $q->whereIn('id', $ids);
                        });
                        break;

                    case 'name':
                    case 'nome_operador':
                        if (is_string($val)) {
                            $val = trim($val, ',');
                        }

                        $query->whereHas('pessoa', function ($q) use ($val) {
                            $q->where('name', 'like', '%' . $val . '%');
                        });

                        break;


                    case 'limite':
                        $val = (int) $val;

                        if ($val > 0) {
                            $query->limit($val);
                        }
                        break;

                    case 'ordem':
                        $ordens = explode(',', trim($val, ','));

                        foreach ($ordens as $ord) {
                            [$campo, $direcao] = explode('-', $ordem);
                            $query->orderBy($campo, $direcao);
                        }

                        break;

                    case 'campos':
                        if (is_array($val) && count($val) > 0) {
                            //
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
