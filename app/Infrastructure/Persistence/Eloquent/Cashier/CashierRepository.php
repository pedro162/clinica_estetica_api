<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Cashier;

use App\Caixa;
use App\Domain\Cashier\Entities\Cashier;
use App\Domain\Cashier\ValueObjects\CashierId;

class CashierRepository
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(CashierId $id)
    {
        return Caixa::where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
    }

    public function save(Cashier $parameter): ?Caixa
    {
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        unset($entity->id);
        unset($entity->tenant_id);

        if (!app()->environment('testing')) {
            $entity->tenant_id = $tenantId;
        }

        $entity->save();
        return $this->findById(new CashierId((string)$entity->id));
    }

    public function update(Cashier $parameter): void
    {
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $entity = $parameter->build();
        $entity->user_id = $userId;
        unset($entity->tenant_id);

        if (!app()->environment('testing')) {
            $entity->tenant_id = $tenantId;
        }

        Caixa::find($entity->id)->update($entity->toArray());
    }

    public function getAll(array $consulta)
    {
        if (!isset($consulta['ordem'])) {
            $consulta['ordem'] =  'id-desc';
        }

        $ordem      = $consulta['ordem'] ?? 'id-desc';
        $campos =  null;
        $parse = [
            'caixa_name' => 'caixas.name',
            'name_caixa' => 'caixas.name'

        ];

        $registro = \DB::table('caixas');
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

                            $registro->whereIn('caixas.id', $val);
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

                            $registro->where('caixas.name', 'like', '%' . $val . '%');
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

                            $registro->where('caixas.id', '=', '' . $val . '');
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
            $registro->select('caixas.*');
        }

        $ordemArr   = explode('-', $ordem);
        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $usePaginate = $consulta['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::ITENS_PER_PAGE;

        if ($usePaginate > 0) {
            $registro   = $registro->where('caixas.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->where('caixas.active', '=', 'yes')->get();
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
