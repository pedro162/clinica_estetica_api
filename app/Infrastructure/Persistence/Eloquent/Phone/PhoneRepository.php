<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Contact;

use App\Telefone;
use App\Domain\Contact\Entities\Contact;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\ValueObjects\ContactId;
use Illuminate\Support\Facades\Auth;

class PhoneRepository implements ContactRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(ContactId $id): ?Telefone
    {
        return Telefone::where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
    }

    public function save(Contact $parameter): ?Telefone
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        $entity->tenant_id = $this->getTenantId();
        $entity->active = $entity->active ? $entity->active : 'yes';

        unset($entity->id);
        $entity->save();
        return $this->findById(new ContactId((string)$entity->id));
    }

    public function crateSimple(array $data): ?Telefone
    {
        $data['user_id'] = $data['user_id'] ?? Auth::user()->id;;
        $data['tenant_id'] = $this->getTenantId();
        $data['active'] = $data['active'] ?? 'yes';

        return Telefone::create($data);
    }

    public function update(Contact $parameter): void
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_update_id = $userId;

        $data = $entity->toArray();

        if (isset($data['tenant_id']) && $data['tenant_id'] == 0) {
            unset($data['tenant_id']);
        }

        Telefone::findOrFail((string)$parameter->getId())->update($data);
    }

    public function destroy(Contact $parameter): void
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_update_id = $userId;

        $data = $entity->toArray();

        if (isset($data['tenant_id']) && $data['tenant_id'] == 0) {
            unset($data['tenant_id']);
        }

        $data['active'] = 'no';
        $paymentPlan = Telefone::find((string)$parameter->getId());

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

        $parse = [
            'plano_name' => 'plano_pagamentos.name',
        ];

        $query = Telefone::query();

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
                    case 'nome_plano':
                        if (is_string($val)) {
                            $val = trim($val, ',');
                            $query->where('name', 'like', '%' . $val . '%');
                        }
                        break;

                    case 'forma_pagamentos_id':
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
            $query->select('plano_pagamentos.*');
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
