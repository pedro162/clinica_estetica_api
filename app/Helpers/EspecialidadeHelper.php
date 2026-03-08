<?php

namespace App\Helpers;

use App\Especialidade;
use App\Exceptions\EspecialidadeException;

class EspecialidadeHelper extends BaseHelper
{
    public function info($dados, $id)
    {
        $id = $id ?? $dados['id'];
        if ($id <= 0) {
            throw new EspecialidadeException('Parâmetro inválido. Entre em contato com o supote.');
        }
        $registro = Especialidade::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if ($registro == null) {
            throw new EspecialidadeException('Registro não encontrado.');
        }
        return $registro;
    }



    public function store($dados)
    {

        $user_id = \Auth::User()->id;
        $dadosEvento                = [];
        $dadosEvento['name']        = $dados['name'];
        $dadosEvento['user_id']     = $user_id;
        $dadosEvento['active']      = 'yes';
        $registro = Especialidade::create($dadosEvento);

        if (!$registro) {
            throw new EspecialidadeException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o supote.');
        }
        return $registro;
    }


    public function edit($dados, $id)
    {

        $dadosRequest = $dados;
        if ($id <= 0) {
            throw new EspecialidadeException('Parâmetro ínválido');
        }
        $registro = Especialidade::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if (!$registro) {
            throw new EspecialidadeException('Registro não encontrado');
        }

        return $registro;
    }

    public function update($dados, $id)
    {
        if ($id <= 0) {
            throw new EspecialidadeException('Parâmetro ínválido');
        }

        $user_id    = \Auth::User()->id;
        $erros      = [];

        $dadosEvento                = [];
        $dadosEvento['name']        = $dados['name'];
        $eventoAgenda = Especialidade::where('id', '=', $id)->where('active', '=', 'yes')->first();
        if (!$eventoAgenda) {
            throw new EspecialidadeException('Evento não identificado');
        }
        $eventoAgenda->update($dadosEvento);

        return $eventoAgenda;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id <= 0) {
            throw new EspecialidadeException('Erro ao deletar registro');
        }

        $eventoAgenda = Especialidade::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();
        if (!$eventoAgenda) {
            throw new EspecialidadeException('Registro não encontrado');
        }

        $eventoAgenda->update(['active' => 'no']);
        $eventoAgenda->delete();
    }


    public function json($consulta)
    {
        $ordem = $consulta['ordem'] ?? 'id-desc';
        if (!(isset($consulta['ordem']) && strlen($consulta['ordem']) > 0)) {

            $ordem = $consulta['ordem'] = 'id-desc';
        }

        $parse = [

            'id' => 'especialidades.id',
            'name' => 'especialidades.name',

        ];

        $campos =  null;

        $registro = Especialidade::where('active', '=', 'yes');

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
                        $registro->whereIn('id', $val);
                        break;
                    case 'name':
                        if ($val[0] == ',') {
                            $val = substr($val, 1);
                        }
                        if ($val[strlen($val) - 1] == ',') {
                            $val = substr($val, 0, -1);
                        }

                        $registro->where('name', 'like', '%' . $val . '%');
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
                }
            }
        }

        $ordemArr   = explode('-', $ordem);
        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $usePaginate = $consulta['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::PAGINACAO_ITENS_POR_PAGINA_PADRAO;
        if ($usePaginate > 0) {
            $registro   = $registro->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->orderBy($oremCampo, $oremTipo)->get();
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
