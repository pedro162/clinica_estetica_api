<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\PaymentMethod;

use App\FormaPagamento;
use App\Domain\PaymentMethod\Entities\PaymentMethod;
use App\Domain\PaymentMethod\Repositories\PaymentMethodRepositoryInterface;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodId;
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
        $tenantId   = Auth::user()->tenant_id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        $entity->tenant_id = $tenantId;

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

        FormaPagamento::find($entity->id)->update($data);
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
}
