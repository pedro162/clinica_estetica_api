<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\PaymentMethod;

use App\Domain\FinancialOperator\Entities\FinancialOperator;
use App\Domain\PaymentMethod\Entities\PaymentMethod;
use App\Domain\PaymentMethod\Repositories\PaymentMethodRepositoryInterface;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodId;
use App\Domain\PaymentPlan\Entities\PaymentPlan;
use App\FormaPagamento;
use Illuminate\Support\Facades\Auth;

class PaymentMethodRepository implements PaymentMethodRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(PaymentMethodId $id): ?FormaPagamento
    {
        return FormaPagamento::where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
    }

    public function save(PaymentMethod $parameter): ?FormaPagamento
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        $entity->tenant_id = $this->getTenantId();
        $entity->active = $entity->active ? $entity->active : 'yes';

        unset($entity->id);
        $entity->save();
        return $this->findById(new PaymentMethodId((string)$entity->id));
    }

    public function update(PaymentMethod $parameter): void
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_update_id = $userId;

        $data = $entity->toArray();

        if (isset($data['tenant_id']) && $data['tenant_id'] == 0) {
            unset($data['tenant_id']);
        }

        FormaPagamento::find((string)$parameter->getId())->update($data);
    }

    public function addFinancialOperator(PaymentMethod $parameter, array $data = []): void
    {
        $financialOperators = $parameter->getFinancialOperators();
        $ids = array_map(fn (FinancialOperator $item) => (string)$item->getId(), $financialOperators);
        $paymentMethod = FormaPagamento::find((string)$parameter->getId());
        $paymentMethod->adicionarOperador($ids);
    }

    public function removeFinancialOperator(PaymentMethod $parameter, array $data = []): void
    {
        $financialOperators = $parameter->getFinancialOperators();
        $ids = array_map(fn (FinancialOperator $item) => (string)$item->getId(), $financialOperators);
        $paymentMethod = FormaPagamento::find((string)$parameter->getId());
        $paymentMethod->removeOperador($ids);
    }

    public function syncFinancialOperator(PaymentMethod $parameter, array $data = []): void
    {
        $financialOperators = $parameter->getFinancialOperators();
        $ids = array_map(fn (FinancialOperator $item) => (string)$item->getId(), $financialOperators);
        $paymentMethod = FormaPagamento::find((string)$parameter->getId());
        $updateData = [];
        $userId   = Auth::user()->id;

        foreach ($ids as $id) {
            $updateData[$id] = ['user_id' => $userId, 'tenant_id' => $this->getTenantId()];
        }

        $paymentMethod->operadorFinanceiro()->sync($updateData);
    }

    public function addPaymentPlan(PaymentMethod $parameter, array $data = []): void
    {
        $paymentPlans = $parameter->getPaymentPlans();
        $ids = array_map(fn (PaymentPlan $item) => (string)$item->getId(), $paymentPlans);
        $paymentMethod = FormaPagamento::find((string)$parameter->getId());
        $paymentMethod->adicionarPlanoPagamento($ids);
    }

    public function removePaymentPlan(PaymentMethod $parameter, array $data = []): void
    {
        $paymentPlans = $parameter->getPaymentPlans();
        $ids = array_map(fn (PaymentPlan $item) => (string)$item->getId(), $paymentPlans);
        $paymentMethod = FormaPagamento::find((string)$parameter->getId());
        $paymentMethod->removePlanoPagamento($ids);
    }

    public function syncPaymentPlan(PaymentMethod $parameter, array $data = []): void
    {
        $paymentPlans = $parameter->getPaymentPlans();
        $ids = array_map(fn (PaymentPlan $item) => (string)$item->getId(), $paymentPlans);
        $paymentMethod = FormaPagamento::find((string)$parameter->getId());

        $updateData = [];
        $userId   = Auth::user()->id;

        foreach ($ids as $id) {
            $updateData[$id] = ['user_id' => $userId, 'tenant_id' => $this->getTenantId()];
        }

        $paymentMethod->planoPagamento()->sync($updateData);
    }

    public function destroy(PaymentMethod $parameter): void
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_update_id = $userId;

        $data = $entity->toArray();

        if (isset($data['tenant_id']) && $data['tenant_id'] == 0) {
            unset($data['tenant_id']);
        }

        $data['active'] = 'no';
        $paymentMethod = FormaPagamento::find((string)$parameter->getId());

        $paymentMethod->update($data);
        $paymentMethod->delete();
    }

    public function getAll(array $filter = []): ?array
    {
        if (!isset($filter['ordem'])) {
            $filter['ordem'] = 'id-desc';
        }

        $ordem = $filter['ordem'];
        $campos = null;

        $parse = [
            'forma_name' => 'forma_pagamentos.name',
        ];

        $query = FormaPagamento::query();

        if (!empty($filter)) {
            foreach ($filter as $key => $val) {
                switch (trim($key)) {
                    case 'id':
                        if (is_string($val)) {
                            $val = trim($val, ',');
                            $ids = explode(',', $val);
                            $query->whereIn('id', $ids);
                        }
                        break;

                    case 'name':
                        if (is_string($val)) {
                            $val = trim($val, ',');
                            $query->where('name', 'like', '%' . $val . '%');
                        }
                        break;

                    case 'forma_pagamento_id':
                        if (is_string($val)) {
                            $val = trim($val, ',');
                            $query->where('id', $val);
                        }
                        break;

                    case 'limite':
                        $val = (int) $val;
                        if ($val > 0) {
                            $query->limit($val);
                        }
                        break;

                    case 'ordem':
                        $val = trim($val, ',');
                        $ordens = explode(',', $val);
                        foreach ($ordens as $ord) {
                            $atual = explode('-', $ord);
                            $campo = $parse[$atual[0]] ?? null;
                            if ($campo && isset($atual[1])) {
                                $query->orderBy($campo, $atual[1]);
                            }
                        }
                        break;

                    case 'campos':
                        if (is_array($val) && count($val) > 0) {
                            // Se quiser montar campos específicos, implementar aqui
                            // $campos = $this->montaCamposConsulta($query, $val);
                        }
                        break;
                }
            }
        }

        if ($campos) {
            $query->select($campos);
        } else {
            $query->select('forma_pagamentos.*');
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
