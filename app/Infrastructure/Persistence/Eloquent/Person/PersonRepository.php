<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Person;

use App\Pessoa;
use App\Domain\Person\Entities\Person;
use App\Domain\Person\Repositories\PersonRepositoryInterface;
use App\Domain\Person\ValueObjects\PersonDocument;
use App\Domain\Person\ValueObjects\PersonId;
use App\Grupo;
use App\Logradouro;
use Illuminate\Support\Facades\Auth;

class PersonRepository implements PersonRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(PersonId $id): ?Pessoa
    {
        return Pessoa::with([
            'logradouro' => function ($query) {
                $query->where('logradouros.active', 'yes')
                    ->with(['estado_logradouro' => function ($query) {
                        $query->where('estadoss.active', 'yes')
                            ->with(['pais' => function ($query) {
                                $query->where('pais.active', 'yes');
                            }]);
                    }]);
            },
            'telefone' => function ($query) {
                $query->where('telefones.active', 'yes');
            },
            'grupo' => function ($query) {
                $query->where('grupos.active', 'yes');
            },
        ])->where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
    }

    public function findByDocument(PersonDocument $document): ?Pessoa
    {
        return Pessoa::where('active', '=', 'yes')
            ->where('documento', '=', (string)$document)->first();
    }

    public function save(Person $parameter): ?Pessoa
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        $entity->tenant_id = $this->getTenantId();
        $entity->active = $entity->active ? $entity->active : 'yes';

        unset($entity->id);
        $entity->save();
        return $this->findById(new PersonId((string)$entity->id));
    }

    public function update(Person $parameter): void
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_update_id = $userId;

        $data = $entity->toArray();
        unset($data['tenant_id']);

        Pessoa::findOrFail((string)$parameter->getId())->update($data);
    }

    public function destroy(Person $parameter): void
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_update_id = $userId;

        $data = $entity->toArray();
        unset($data['tenant_id']);

        $data['active'] = 'no';
        $paymentPlan = Pessoa::find((string)$parameter->getId());

        $paymentPlan->update($data);
        $paymentPlan->delete();
    }

    public function getAll(array $filter = []): ?array
    {
        if (!isset($filter['ordem'])) {
            $filter['ordem'] = 'id-desc';
        }

        $ordem = $filter['ordem'];
        $parse = [];

        $query = Pessoa::query();

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
                    case 'documento':
                        $val = (string) $val;

                        if (is_string($val)) {
                            $val = trim($val, ',');
                        }

                        $val = array_map(function ($item) {
                            return trim($item);
                        }, explode(',', $val));

                        $query->whereIn('documento', $val);
                        break;

                    case 'name':
                    case 'description_to_search':
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

    public function syncGroupe(int $pessoaId, int $grupoId, array $data = []): void
    {
        $person = Pessoa::find($pessoaId);
        $grupo = Grupo::find($grupoId);

        $person->removerGrupo($person->grupo);
        $person->adicionarGrupo($grupo, [
            'active' => 'yes',
            'user_id' => Auth::user()->id
        ]);
    }

    public function syncAddress(int $personId, int $addressId, array $data = []): void
    {
        $person = Pessoa::find($personId);
        $logradouro = Logradouro::find($addressId);

        $person->removerLogradouro($logradouro);
        $person->adicionarLogradouro($logradouro, [
            'active' => 'yes',
            'user_id' => Auth::user()->id
        ]);
    }

    public function deletePhones(int $personId, array $data = []): void
    {
        $person = Pessoa::find($personId)
            ->telefone()->delete();
    }
}
