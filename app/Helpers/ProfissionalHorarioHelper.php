<?php

namespace App\Helpers;

use App\Exceptions\ProfissionalHorarioExcepton;
use App\HoraProfExpediente;
use App\Profissional;

class ProfissionalHorarioHelper
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

        $form = HoraProfExpediente::create($dadosRequest);

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

        $registro = HoraProfExpediente::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();
        $registro->diasProfExpediente->pessoa;

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

        $registro = HoraProfExpediente::where('active', '=', 'yes')->where('id', '=', $id)->first();

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

        $registro = HoraProfExpediente::where('active', '=', 'yes')
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

        $registro = \DB::table('hora_prof_expedientes as hpex')->join('dias_prof_expedientes as dprx', function ($join) {

            $join->on('hpex.dias_prof_expediente_id', '=', 'dprx.id');
        })->join('profissionals as pf', function ($join) {

            $join->on('dprx.profissional_id', '=', 'pf.id');
        })->join('pessoas as pesprf', function ($join) {

            $join->on('pf.pessoa_id', '=', 'pesprf.id');
        });

        $colunasComplementares = '';
        $campos =  null;
        $camposDefault = ['hpex.*', 'pesprf.name as name_profissional', 'pf.id as profissional_id', 'pf.filial_id as filial_id'];
        $groupByDefault = ['hpex.id', 'hpex.name', 'pesprf.name', 'hpex.dias_prof_expediente_id', 'hpex.hora', 'hpex.user_id', 'hpex.deleted_at', 'hpex.created_at', 'hpex.updated_at', 'hpex.active' ,'hpex.user_update_id', 'pf.id', 'pf.filial_id'];


        if (isset($consulta['verificar_data_agenda'])) {
            $dt = str_replace(['/'], ['-'], $consulta['verificar_data_agenda']);
            $dtArr = explode('-', $dt);
            $nrAno = $dtArr[0];
            $nrMes = $dtArr[1];

            if ($nrMes  < 9) {
                $nrMes = '0'.$nrMes ;
            }
            $nrDia = $dtArr[2];
            if ($nrDia  < 9) {
                $nrDia = '0'.$nrDia ;
            }
            $nrAno = trim($nrAno);
            $nrMes = trim($nrMes);
            $nrDia = trim($nrDia);

            $consulta['verificar_data_agenda'] = $nrAno.'-'.$nrMes.'-'.$nrDia;

            $registro->whereRaw(
                'SUBSTRING(hpex.hora, 1, 5) NOT IN (SELECT SUBSTRING(IFNULL(ag.hora, "00:00"), 1, 5) FROM agendas as ag WHERE ag.active="yes" AND SUBSTRING(ag.hora, 1, 5) = SUBSTRING(hpex.hora, 1, 5) AND DATE_FORMAT(ag.data, "%Y-%m-%d") = DATE_FORMAT(?, "%Y-%m-%d") AND ag.pessoa_id = pf.pessoa_id  )',
                [$consulta['verificar_data_agenda']]
            );
        }

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

                        }

                        $val = explode(',', $val);

                        $registro->whereIn('hpex.id', $val);

                        break;
                    case 'nr_dia':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                        }

                        $val = explode(',', $val);

                        $registro->whereIn('dprx.nr_dia', $val);

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
            $registro->select($camposDefault);
        }
        //$registro = \App\::where('active', '=', 'yes')->get();
        $ordemArr   = explode('-', $ordem);

        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $registro->where('hpex.active', '=', 'yes')->groupBy($groupByDefault);
        //$sql = $registro->orderBy($oremCampo, $oremTipo)->toSql();
        //throw new ProfissionalHorarioExcepton($sql);
        $registro   =  $registro->orderBy($oremCampo, $oremTipo)->get();




        return $registro;

    }

}
