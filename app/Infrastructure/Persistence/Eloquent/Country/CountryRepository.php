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

    public function findById(CountryId $id): ?Country
    {
        $data = Pais::where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
        return (new Country())
            ->id(new CountryId($data['id']))
            ->name(new CountryName($data['name']))
            ->code(new CountryCode($data['cdPais']))
            ->isDefault(new CountryIsDefault($data['padrao'] == 'yes' ? true : false))
            ->tenantId(new CountryTenantId($data['tenant_id']));
    }

    public function save(Country $parameter): ?Country
    {
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $country = $parameter->build();
        $country->user_id = $userId;
        $country->tenant_id = $tenantId;
        $country->save();
        return $this->findById(new CountryId($country->id));
    }

    public function getAll(array $consulta)
    {
        if (!isset($consulta['ordem'])) {
            $consulta['ordem'] =  'id-desc';
        }

        $campos =  null;
        $parse = [
            'name_Pais' => 'pais.dsIpi',
            'nmPais' => 'pais.nmPais',
            'name' => 'pais.nmPais',
            'id' => 'pais.id',
        ];

        $ordem = $consulta['ordem'] ?? 'id-desc';

        if (!(isset($consulta['ordem']) && strlen($consulta['ordem']) > 0)) {

            $ordem = $consulta['ordem'] = 'id-desc';
        }

        $registro = \DB::table('pais');

        if (is_array($consulta) && count($consulta) > 0) {
            foreach ($consulta as $key => $val) {

                switch (trim($key)) {
                    case 'id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('pais.id', $val);
                        }
                        break;
                    case 'tipo':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('pais.tpCalculo', $val);
                        }
                        break;
                    case 'nmPais':
                    case 'name':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('pais.nmPais', 'like', '%' . $val . '%');
                        }
                        break;
                    case 'limite':
                        $val = (int) $val;
                        if (is_integer($val) && $val > 0) {

                            $registro->limit($val);
                        }
                        break;
                    case 'ordem':


                        if ($val[0] == ',') {
                            $val = substr($val, 1);
                        }
                        if ($val[strlen($val) - 1] == ',') {
                            $val = substr($val, 0, -1);
                        }

                        $val = explode(',', $val);
                        for ($i = 0; !($i == count($val)); $i++) {
                            $atual = explode('-', $val[$i]);
                            if (array_key_exists(trim($atual[0]), $parse)) {

                                $parsed = $parse[trim($atual[0])];

                                if ($parsed) {

                                    $registro->orderBy($parsed, $atual[1]);
                                }
                            }
                        }

                        break;

                    case 'campos':
                        if (is_array($val) && count($val) > 0) {
                            //$campos = $this->montaCamposConsulta($registro, $val);

                        }
                        break;
                }
            }
        }

        if ($campos) {
            $registro->select($campos);
        } else {
            $registro->select('pais.*');
        }

        $ordemArr   = explode('-', $ordem);
        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $usePaginate = $consulta['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::ITENS_PER_PAGE;

        if ($usePaginate > 0) {
            $registro   = $registro->where('pais.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->where('pais.active', '=', 'yes')->get();
        }

        if (isset($consulta['to_require']) && $consulta['to_require'] == true) {
            $dataToRequest = [];

            foreach ($registro as $reg) {
                $dataToRequest[] = ['label' => $reg->name, 'value' => $reg->id];
            }

            $registro = $dataToRequest;
        }

        return  $registro;
    }
}
