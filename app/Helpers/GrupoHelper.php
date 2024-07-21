<?php

namespace App\Helpers;

use \App\Pessoa;
use \App\Grupo;
use \App\Telefone;
use \App\Logradouro;
use \App\Utilitarios;
use App\Exceptions\PessoaException;
use App\Exceptions\GrupoException;
use Illuminate\Support\Facades\Validator;
use App\Helpers\BaseHelper;

class GrupoHelper extends BaseHelper
{
    public function json(array $dados)
    {
        $consulta = $dados;
        $campos =  null;
        $parse = [
            'grupo_name' => 'grupos.name'

        ];

        $ordem = $consulta['ordem'] ?? 'id-desc';
        if (!(isset($consulta['ordem']) && strlen($consulta['ordem']) > 0)) {

            $ordem = $consulta['ordem'] = 'id-desc';
        }
        $registro = \DB::table('grupos');
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

                            $registro->whereIn('grupos.id', $val);
                        }
                        break;
                    case 'name':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('grupos.name', 'like', '%' . $val . '%');
                        }
                        break;
                    case 'grupo_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('grupos.id', '=', '' . $val . '');
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
            $registro->select('grupos.*');
        }

        $ordemArr   = explode('-', $ordem);

        $oremCampo      = $ordemArr[0];
        $oremTipo       = $ordemArr[1];
        $usePaginate    = $consulta['usePaginate'] ?? 0;
        $usePaginate    = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::PAGINACAO_ITENS_POR_PAGINA_PADRAO;
        $usePaginate    = (int) $usePaginate;
        if ($usePaginate > 0) {
            $registro   = $registro->where('grupos.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro   = $registro->where('grupos.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->get();
        }

        if (isset($consulta['to_require']) && $consulta['to_require'] == true) {
            $dataToRequest = [];
            foreach ($registro as $reg) {
                $dataToRequest[] = ['label' => $reg->name, 'value' => $reg->id];
            }

            $registro = $dataToRequest;
        }

        return $registro;
    }
}
