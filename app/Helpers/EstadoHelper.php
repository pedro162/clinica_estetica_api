<?php

namespace App\Helpers;

use \App\Utilitarios;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Estado;
use App\Pais;
use App\Exceptions\EstadoException;

class EstadoHelper
{

    public function info($dados, $id)
    {

        $id = $id ?? $dados['id'];
        $callBack = $dados['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ($id <= 0) {
            throw new EstadoException('Parâmetro ínválido');
        }



        $registro = Estado::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if ($registro == null) {
            throw new EstadoException('Registro não encontrado');
        }

        return $registro;
    }



    public function store($dados)
    {
        $pais = Pais::where('active', '=', 'yes')->where('id', '=', $dados['pais_id'])->first();
        if (! $pais) {
            throw new EstadoException('País não identificado. Tente novamente ou entre em contato com o suporte.');
        }

        $dadosRequest = [];

        $dadosRequest['user_id']            = \Auth::User()->id;
        $dadosRequest['user_update_id']     = \Auth::User()->id;
        $dadosRequest['tenant_id']          = \Auth::User()->tenant_id;
        $dadosRequest['nmEStado']           = $dados['nmEStado'];
        $dadosRequest['codEstado']          = $dados['codEstado'];
        $dadosRequest['sigla']              = $dados['sigla'];
        $dadosRequest['pais_id']            = $pais->id;
        $dadosRequest['padrao']             = $dados['padrao'];
        $dadosRequest['active']             = 'yes';

        $registro = Estado::create($dadosRequest);

        if (! $registro) {
            throw new EstadoException('Erro ao cadastrar');
        }

        return $registro;
    }


    public function json($consulta)
    {

        $campos =  null;
        $parse = [
            'name_estado' => 'estadoss.nmEStado',
            'name' => 'estadoss.nmEStado',
            'id' => 'estadoss.id',

        ];
        /*

            
                <!--
                    'nmEStado',
                    'codEstado',
                    'sigla',
                    'padrao',
                    'pais_id',
                    'user_id',
                    'user_update_id',
                    'active',

                 
        */


        $ordem = $consulta['ordem'] ?? 'id-desc';
        if (!(isset($consulta['ordem']) && strlen($consulta['ordem']) > 0)) {

            $ordem = $consulta['ordem'] = 'id-desc';
        }


        $registro = \DB::table('estadoss');
        $registro->join('pais', function ($join) {

            $join->on('pais.id', '=', 'estadoss.pais_id');
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

                            $registro->whereIn('estadoss.id', $val);
                        }
                        break;
                    case 'nmEStado':
                    case 'name':
                    case 'name_estado':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('estadoss.nmEStado', 'like', '%' . $val . '%');
                        }
                        break;
                    case 'codEstado':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('estadoss.codEstado', '=', '' . $val . '');
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

                            $registro->where('estadoss.sigla', '=', '' . $val . '');
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
            $registro->select('estadoss.*', 'pais.nmPais', 'pais.cdPais');
        }

        $registro = $registro->where('estadoss.active', '=', 'yes')
            ->where('pais.active', '=', 'yes')->get();

        if (!empty($consulta['to_require'])) {
            $dataToRequest = [];

            foreach ($registro as $reg) {
                $dataToRequest[] = [
                    'label' => $reg->nmEStado,
                    'value' => $reg->id,
                ];
            }

            $registro = $dataToRequest;
        }
        return $registro;
    }
}
