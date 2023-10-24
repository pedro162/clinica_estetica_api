<?php

namespace App\Helpers;

use \App\Formulario;
use \App\Exceptions\FormularioGrupoException;
use \App\FormularioGrupo;
use \App\FormularioItem;
use \App\Utilitarios;

class FormularioGrupoHelper
{
    public function listar($data)
    {
        //dd($data);

        $parse = [];

        $registro = \DB::table('formulario_grupos as formg');

        $campos =  null;
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $val) {

                switch (trim($key)) {
                    case 'id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }

                        $val = explode(',', $val);
                        $registro->whereIn('formg.id', $val);
                        break;
                    case 'formulario_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }

                        $val = explode(',', $val);
                        $registro->whereIn('formg.formulario_id', $val);

                        break;
                    case 'nome_grupo':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }
                        $registro->where('formg.name', 'like', '%' . $val . '%');
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
                            $campos = Utilitarios::montaCamposdata($registro, $val);
                        }
                        break;
                }
            }
        }
        if ($campos) {
            $registro->select($campos);
        } else {
            $registro->select('formg.*');
        }
        //$registro = \App\::where('active', '=', 'yes')->get();
        $registro = $registro->where('formg.active', '=', 'yes')->get();

        return $registro;
    }
}
