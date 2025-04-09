<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\PaymentMethod;

use App\Caixa;
use App\Domain\PaymentMethod\Entities\PaymentMethod;
use App\Domain\PaymentMethod\Repositories\PaymentMethodRepositoryInterface;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodId;
use Illuminate\Support\Facades\Auth;

class PaymentMethodRepository implements PaymentMethodRepositoryInterface
{
    protected const ITENS_PER_PAGE = 10;

    public function findById(PaymentMethodId $id): ?Caixa
    {
        return Caixa::where('active', '=', 'yes')
            ->where('id', '=', (string)$id)->first();
    }

    public function save(PaymentMethod $parameter): ?Caixa
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

        Caixa::find($entity->id)->update($data);
    }

    public function getAll(array $filter = []): ?array
    {
        if (!isset($filter['ordem'])) {
            $filter['ordem'] =  'id-desc';
        }

        $ordem      = $filter['ordem'] ?? 'id-desc';
        $campos =  null;
        $parse = [
            'caixa_name' => 'caixas.name',
            'name_caixa' => 'caixas.name'

        ];

        $registro = \DB::table('caixas');

        if (is_array($filter) && count($filter) > 0) {
            foreach ($filter as $key => $val) {

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

        $usePaginate = $filter['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($filter['nr_itens_per_page']) && $filter['nr_itens_per_page'] > 0 ? $filter['nr_itens_per_page'] : self::ITENS_PER_PAGE;

        if ($usePaginate > 0) {
            $registro   = $registro->where('caixas.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->where('caixas.active', '=', 'yes')->get();
        }

        if (isset($filter['to_require']) && $filter['to_require'] == true) {
            $dataToRequest = [];

            foreach ($registro as $reg) {
                $dataToRequest[] = ['label' => $reg->name, 'value' => $reg->id];
            }

            $registro = $dataToRequest;
        }

        return  ['registro' => $registro];
    }
}
