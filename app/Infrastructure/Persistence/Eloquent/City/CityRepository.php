<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\City;

use App\Domain\City\Entities\City;
use App\Domain\City\Repositories\CityRepositoryInterface;
use App\Domain\City\ValueObjects\CityCode;
use App\Domain\City\ValueObjects\CityId;
use App\Domain\City\ValueObjects\CityIsDefault;
use App\Domain\City\ValueObjects\CityName;
use App\Domain\City\ValueObjects\CityTenantId;
use App\Cidade;
use Illuminate\Support\Facades\Auth;

class CityRepository implements CityRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(CityId $id): ?City
    {
        $data = Cidade::where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
        return (new City())
            ->id(new CityId($data['id']))
            ->name(new CityName($data['name']))
            ->code(new CityCode($data['Cidade']))
            ->tenantId(new CityTenantId($data['tenant_id']));
    }

    public function save(City $parameter): ?City
    {
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $country = $parameter->build();
        $country->user_id = $userId;
        $country->tenant_id = $tenantId;
        $country->save();
        return $this->findById(new CityId($country->id));
    }

    public function update(City $parameter): void
    {
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $country = $parameter->build();
        $country->user_id = $userId;
        $country->tenant_id = $tenantId;
        $country->update();
    }

    public function getAll(array $consulta = []): ?array
    {
        $ordem = $consulta['ordem'] ?? 'id-desc';

        if (!(isset($consulta['ordem']) && strlen($consulta['ordem']) > 0)) {
            $ordem = $consulta['ordem'] = 'id-desc';
        }

        if (! isset($consulta['limite'])) {

            $consulta['limite'] =  500;
        }

        $campos =  null;
        $parse = [
            'name_cidade' => 'cidades.dsIpi',
            'id' => 'cidades.id'

        ];

        $registro = \DB::table('cidades');
        $registro->join('estadoss', function ($join) {

            $join->on('estadoss.id', '=', 'cidades.estado_id');
        });

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

                            $registro->whereIn('cidades.id', $val);
                        }
                        break;
                    case 'nmCidade':
                    case 'name_nome_cidade':
                    case 'name':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('cidades.nmCidade', 'like', '%' . $val . '%');
                        }
                        break;
                    case 'cdCidade':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('cidades.cdCidade', '=', '' . $val . '');
                        }
                        break;
                    case 'sigla':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('cidades.sigla', '=', '' . $val . '');
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
            $registro->select('cidades.*', 'estadoss.nmEStado');
        }

        $ordemArr   = explode('-', $ordem);
        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $usePaginate = $consulta['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::ITENS_PER_PAGE;

        if ($usePaginate > 0) {
            $registro   = $registro->where('cidades.active', '=', 'yes')
                ->where('estadoss.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->where('cidades.active', '=', 'yes')
                ->where('estadoss.active', '=', 'yes')->get();
        }

        if (isset($consulta['to_require']) && $consulta['to_require'] == true) {
            $dataToRequest = [];

            foreach ($registro as $reg) {
                $dataToRequest[] = ['label' => $reg->name, 'value' => $reg->id];
            }

            $registro = $dataToRequest;
        }

        return  ['registro' => $registro];
    }
}
