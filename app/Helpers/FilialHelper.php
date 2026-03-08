<?php

namespace App\Helpers;

use App\Exceptions\FilialException;
use App\Filial;
use App\Pessoa;

class FilialHelper extends BaseHelper
{
    public function info($dados, $id)
    {

        $id = $id ?? $dados['id'];
        $callBack = $dados['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ($id <= 0) {

            throw new FilialException('Parâmetro inválido. Entre em contato com o supote.');
        }

        $registro = null;

        $registro = Filial::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if ($registro == null) {

            throw new FilialException('Registro não encontrado.');
        }

        $registro->logradouro = $registro->logradouro ? $registro->logradouro->where('importancia', '=', 'principal')->first()->estado_logradouro->pais : null;
        $registro->grupo;
        $registro->telefone;
        $registro->pessoa;

        if ($registro == null) {
            throw new PaisException('Registro não encontrado');
        }

        return $registro;
    }



    public function store($dados)
    {
        $dadosRequest = [];

        $user_id = \Auth::User()->id;
        $pessoa = Pessoa::where('active', '=', 'yes')->where('id', '=', $dados['pessoa_id'])->first();

        if (!$pessoa) {
            throw new FilialException('Pessoa não identificada');
        }

        if (Filial::where('pessoa_id', '=', $pessoa->id)->first()) {
            throw new FilialException('Já existe uma filial para a pessoa informada.');
        }

        $dadosFilial                        = [];
        $dadosFilial['user_id']             = \Auth::User()->id;
        $dadosFilial['pessoa_id']           = $pessoa->id;
        $dadosFilial['dsAtividade']         = $dados['dsAtividade'] ?? 'comercio';
        $dadosFilial['dsTextoContrato']     = $dados['dsTextoContrato'] ?? null;
        $dadosFilial['active']              = 'yes';

        $registro             = Filial::create($dadosFilial);

        if (!$registro) {
            throw new PaisException('Erro ao cadastrar');
        }

        return $registro;
    }


    public function json($consulta)
    {

        $campos =  null;
        $parse = [
            'name' => 'p.name',
            'id' => 'fl.id',

        ];

        $ordem = $consulta['ordem'] ?? 'id-desc';
        if (!(isset($consulta['ordem']) && strlen($consulta['ordem']) > 0)) {

            $ordem = $consulta['ordem'] = 'id-desc';
        }

        $registro = \DB::table('filials as fl')
            ->join('pessoas as p', function ($join) {
                $join->on('p.id', '=', 'fl.pessoa_id');
            });

        if (is_array($consulta) && count($consulta) > 0) {
            foreach ($consulta as $key => $val) {

                switch (trim($key)) {
                    case 'id':
                    case 'filial_id':
                    case 'codigo_to_search':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }
                        $val = explode(',', $val);
                        $registro->whereIn('fl.id', $val);

                        break;
                    case 'pessoa_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }
                        $val = explode(',', $val);
                        $registro->whereIn('fl.pessoa_id', $val);

                        break;

                    case 'pessoa_name':

                        if ($val[0] == ',') {
                            $val = substr($val, 1);
                        }
                        if ($val[strlen($val) - 1] == ',') {
                            $val = substr($val, 0, -1);
                        }

                        $registro->where('p.name', 'like', '%' . $val . '%');
                        break;
                    case 'name':
                    case 'name_filial':
                        if ($val[0] == ',') {
                            $val = substr($val, 1);
                        }
                        if ($val[strlen($val) - 1] == ',') {
                            $val = substr($val, 0, -1);
                        }

                        $registro->where('name', 'like', '%' . $val . '%');
                        break;

                    case 'description_to_search':
                        if ($val[0] == ',') {
                            $val = substr($val, 1);
                        }
                        if ($val[strlen($val) - 1] == ',') {
                            $val = substr($val, 0, -1);
                        }

                        $registro->where('name', 'like', '%' . $val . '%');
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
        } //


        if ($campos) {
            $registro->select($campos);
        } else {
            $registro->select('fl.*', 'p.name as name_filial', 'p.documento');
        }



        $ordemArr   = explode('-', $ordem);
        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $usePaginate = $consulta['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::PAGINACAO_ITENS_POR_PAGINA_PADRAO;
        if ($usePaginate > 0) {
            $registro   = $registro->where('fl.active', '=', 'yes')
                ->where('p.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->where('fl.active', '=', 'yes')
                ->where('p.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->get();
        }

        if (isset($consulta['to_require']) && $consulta['to_require'] == true) {
            $dataToRequest = [];
            foreach ($registro as $reg) {
                $dataToRequest[] = ['label' => $reg->name_filial, 'value' => $reg->id];
            }

            $registro = $dataToRequest;
        }

        return $registro;
    }
}
