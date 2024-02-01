<?php

namespace App\Helpers;

use \App\Utilitarios;
use \App\HoraProfExpediente;
use \App\Pessoa;
use \App\Filial;
use \App\Profissional;
use \App\Exceptions\ProfissionalHorarioExcepton;

class ProfissionalHorarioHelper{

    

    public function store(array $dados){
        

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

    

    public function info(array $dados, int $id=0){

        $id         = $id ?? $dados['id'];
        $callBack   = $dados['callBack'] ?? '';

        if ($id <= 0) {
            throw new ProfissionalHorarioExcepton('Parâmetro ínválido');
        }

        $registro = HoraProfExpediente::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();
        $registro->pessoa;
        $dataItens = [];
        if ($registro->item) {
            foreach ($registro->item as $key => $item) {
                $item->servico;
                //$dataItens[] = $item->servico;
            }
        }
        $dataCobrancas = [];
        if ($registro->cobranca) {
            foreach ($registro->cobranca as $key => $cobranca) {
                $cobranca->formaPgto;
                $cobranca->planoPgto;

                //$dataCobrancas[] = $cobranca->formaPgto;


            }
        }

        $registro->cobranca; // = $dataCobrancas;
        $registro->item; // = $dataItens;
        //$registro->item;
        $registro->rca;
        $registro->filial;

        return $registro;
    }


    public function update(array $dados, int $id=0){

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

    

    public function destroy(int $id){

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

                            $registro->whereIn('os.id', $val);
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
            $registro->select('hpex.*', 'pesprf.name as name_profissional', 'pesprf.id as profissional_id');
        }
        //$registro = \App\::where('active', '=', 'yes')->get();
        $ordemArr   = explode('-', $ordem);

        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $registro   = $registro->where('hpex.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->get();


            

        return $registro;
        
    }

}
