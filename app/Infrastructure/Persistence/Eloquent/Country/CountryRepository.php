<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Country;

use App\Domain\Country\Entities\Country;
use App\Domain\Country\Repositories\CountryRepositoryInterface;
use App\Domain\Country\ValueObjects\CountryCode;
use App\Domain\Country\ValueObjects\CountryId;
use App\Domain\Country\ValueObjects\CountryIsDefault;
use App\Domain\Country\ValueObjects\CountryName;
use App\Domain\Country\ValueObjects\CountryTenantId;
use App\Pais;
use Illuminate\Support\Facades\Auth;

class CountryRepository implements CountryRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(CountryId $id): ?Pais
    {
        return Pais::where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
    }

    public function save(Country $parameter): ?Pais
    {
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $country = $parameter->build();
        $country->user_id = $userId;
        $country->tenant_id = $tenantId;

        $country->save();
        return $this->findById(new CountryId((string)$country->id));
    }

    public function update(Country $parameter): void
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_update_id = $userId;

        $data = $entity->toArray();
        unset($data['tenant_id']);

        Pais::findOrFail((string)$parameter->getId())->update($data);
    }

    public function destroy(Country $parameter): void
    {
        $userId   = Auth::user()->id;
        $entity = $parameter->build();
        $entity->user_update_id = $userId;

        $data = $entity->toArray();
        unset($data['tenant_id']);

        $data['active'] = 'no';
        $paymentPlan = Pais::find((string)$parameter->getId());

        $paymentPlan->update($data);
        $paymentPlan->delete();
    }

    public function getAll(array $filter): ?array
    {
        if (!isset($filter['ordem'])) {
            $filter['ordem'] = 'id-desc';
        }

        $ordem = $filter['ordem'];
        $parse = [];

        $query = Pais::query();

        if (is_array($filter) && count($filter) > 0) {
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
                    case 'nmPais':
                    case 'name':
                        if (is_string($val)) {
                            $val = trim($val, ',');
                        }

                        $query->where('nmPais', 'like', '%' . $val . '%');

                        break;
                    case 'limite':
                        $val = (int) $val;
                        if (is_integer($val) && $val > 0) {
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
                            //$campos = $this->montaCamposConsulta($query, $val);

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
                    'label' => $reg->nmPais,
                    'value' => $reg->id,
                ];
            }

            $registro = $dataToRequest;
        }

        return ['registro' => $registro];
    }
}
