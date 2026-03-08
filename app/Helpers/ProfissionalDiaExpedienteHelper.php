<?php

namespace App\Helpers;

use App\DiasProfExpediente;
use App\Exceptions\ProfissionalHorarioExcepton;
use App\Profissional;

class ProfissionalDiaExpedienteHelper
{
    public function store(array $dados)
    {


        $profissional = Profissional::where('id', '=', $dados['profissional_id'])->where('active', '=', 'yes')->first();
        if (!$profissional) {
            throw new ProfissionalHorarioExcepton('Profissional não identificado');
        }


        $dadosRequest = [];

        $dadosRequest['nr_dia']           = $dados['nr_dia'] ?? 0;
        $dadosRequest['profissional_id']  = $profissional->id;
        $dadosRequest['user_id']          = \Auth::User()->id; //trocar pelo id do usuario logado
        $dadosRequest['active']           = 'yes';

        $form = DiasProfExpediente::create($dadosRequest);

        if (!$form) {
            throw new ProfissionalHorarioExcepton('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte.');
        }

        return $form;

    }



    public function info(array $dados, int $id = 0)
    {

        $id         = $id ?? $dados['id'];
        $callBack   = $dados['callBack'] ?? '';

        if ($id <= 0) {
            throw new ProfissionalHorarioExcepton('Parâmetro ínválido');
        }

        $registro = DiasProfExpediente::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();
        $registro->pessoa;


        return $registro;
    }


    public function update(array $dados, int $id = 0)
    {

        $id             = $id ?? $dados['id'];
        $callBack       = $dados['callBack'] ?? '';
        $idAssistente   =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ((!isset($id)) || ($id <= 0)) {
            throw new ProfissionalHorarioExcepton('Parâmetro inválido');
        }

        $registro = DiasProfExpediente::where('active', '=', 'yes')->where('id', '=', $id)->first();

        if (!$registro) {
            throw new ProfissionalHorarioExcepton('Registro não encontrado');
        }

        $profissional = Profissional::where('id', '=', $dados['profissional_id'])->where('active', '=', 'yes')->first();
        if (!$profissional) {
            throw new ProfissionalHorarioExcepton('Profissional não identificado');
        }


        $dadosRequest = [];

        $dadosRequest['nr_dia']           = $dados['nr_dia'] ?? 0;
        $dadosRequest['profissional_id']  = $profissional->id;
        $dadosRequest['user_update_id']     = \Auth::User()->id;
        $registro->update($dadosRequest);


        if (!$registro) {
            throw new ProfissionalHorarioExcepton('Registro não encontrado');
        }

        return $registro;
    }



    public function destroy(int $id)
    {

        if ($id <= 0) {
            throw new ProfissionalHorarioExcepton('Parâmetro inválido');
        }

        $registro = DiasProfExpediente::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();
        if (!$registro) {
            throw new ProfissionalHorarioExcepton('Erro ao exclir registro');
        } else {

            $registro = $registro->update(['active' => 'no']);
        }

        if ($registro == null) {

            //\Session::flash('mensagem', ['msg'=>' não encontrado', 'class'=>'alert alert-danger']);
            //return redirect()->back();
            throw new ProfissionalHorarioExcepton('Erro ao exclir registro');
        }

        return $registro;
    }

    public function json(array $data)
    {


        $consulta = $data;
        //dd($consulta);
        $ordem = $consulta['ordem'] ?? 'id-desc';

        $parse = [];

        $registro = \DB::table('dias_prof_expedientes as dprx')->join('profissionals as pf', function ($join) {

            $join->on('dprx.profissional_id', '=', 'pf.id');
        })->join('pessoas as pesprf', function ($join) {

            $join->on('pf.pessoa_id', '=', 'pesprf.id');
        });

        if (isset($consulta['verificar_data_agenda'])) {
            $registro->whereRaw('dprx.nr_dia NOT IN (SELECT WEEKDAY(IFNULL(ag.data, "-1")) FROM agendas as ag WHERE ag.active="yes" AND WEEKDAY(IFNULL(ag.data, "-1")) = dprx.nr_dia AND ag.data >= CURRENT_DATE() AND ag.pessoa_id = pf.pessoa_id  )', []);
        }

        $campos =  null;
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

                            $registro->whereIn('dprx.id', $val);
                        }
                        break;
                    case 'nome_pessoa':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('pesprf.name', 'like', '%' . $val . '%');
                        }

                        // no break
                    case 'name_pessoa':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('pesprf.name', 'like', '%' . $val . '%');
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
                            $campos = $this->montaCamposConsulta($registro, $val);
                        }
                        break;
                }
            }
        }
        if ($campos) {
            $registro->select($campos);
        } else {
            $registro->select('dprx.*', 'pesprf.name as name_profissional', 'pesprf.id as profissional_id');
        }
        //$registro = \App\::where('active', '=', 'yes')->get();
        $ordemArr   = explode('-', $ordem);

        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $registro   = $registro->where('dprx.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->get();




        return $registro;

    }

}
