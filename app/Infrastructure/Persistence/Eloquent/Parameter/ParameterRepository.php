<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Parameter;

use App\Domain\Parameter\Entities\Parameter;
use App\Domain\Parameter\Repositories\ParameterRepositoryInterface;
use App\Domain\Parameter\ValueObjects\ParameterId;
use App\Domain\Parameter\ValueObjects\ParameterName;
use App\Domain\Parameter\ValueObjects\ParameterTenantId;
use App\Domain\Parameter\ValueObjects\ParameterType;
use App\Parametro;

class ParameterRepository implements ParameterRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(ParameterId $id): ?Parameter
    {
        $data = Parametro::where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
        return (new Parameter())
            ->id(new ParameterId($data['id']))
            ->name(new ParameterName($data['name']))
            ->type(new ParameterType($data['type']))
            ->tenantId(new ParameterTenantId($data['tenant_id']));
    }

    public function save(Parameter $parameter): ?Parameter
    {
        $result = Parametro::create($parameter->build());
        return $this->findById(new ParameterId($result->id));
    }

    public function getAll(array $consulta)
    {
        if (!isset($consulta['ordem'])) {
            $consulta['ordem'] =  'id-desc';
        }

        $ordem      = $consulta['ordem'] ?? 'id-desc';
        $campos =  null;
        $parse = [
            'caixa_name' => 'parametros.name',
            'name_caixa' => 'parametros.name'

        ];

        $registro = \DB::table('parametros');
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

                            $registro->whereIn('parametros.id', $val);
                        }
                        break;
                    case 'name':
                    case 'caixa_name':
                    case 'name_caixa':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('parametros.name', 'like', '%' . $val . '%');
                        }
                        break;
                    case 'caixa_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('parametros.id', '=', '' . $val . '');
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
            $registro->select('parametros.*');
        }

        $ordemArr   = explode('-', $ordem);
        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $usePaginate = $consulta['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::ITENS_PER_PAGE;

        if ($usePaginate > 0) {
            $registro   = $registro->where('parametros.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->where('parametros.active', '=', 'yes')->get();
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
