<?php

namespace App\Helpers;

use \App\Pessoa;
use \App\Grupo;
use \App\Telefone;
use \App\Logradouro;
use \App\Utilitarios;
use App\Exceptions\PessoaException;
use App\Helpers\BaseHelper;

class PessoaHelper extends BaseHelper
{
    public function info($dados, $id)
    {
        $id = $id ?? $dados['id'];

        if ($id <= 0) {

            throw new PessoaException('Parâmetro inválido. Entre em contato com o supote.');
        }

        $registro = null;

        $registro = Pessoa::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if ($registro == null) {

            throw new PessoaException('Registro não encontrado.');
        }

        $logr = $registro->logradouro()->where('importancia', '=', 'principal')->first();
        $registro->logradouro = $logr;
        if ($registro->logradouro) {

            if ($registro->logradouro->estado_logradouro) {
                $registro->logradouro->estado_logradouro->pais;
            }
        }

        $registro->grupo;
        $registro->telefone;

        return $registro;
    }


    public function json(array $dados)
    {

        $consulta = $dados;

        $campos =  null;

        $ordem = $consulta['ordem'] ?? 'id-desc';
        if (!(isset($consulta['ordem']) && strlen($consulta['ordem']) > 0)) {

            $ordem = $consulta['ordem'] = 'id-desc';
        }
        $registro = Pessoa::where('active', '=', 'yes');

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

                            $registro->whereIn('id', $val);
                        }
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

                    case 'description_to_search':
                        if ($val[0] == ',') {
                            $val = substr($val, 1);
                        }
                        if ($val[strlen($val) - 1] == ',') {
                            $val = substr($val, 0, -1);
                        }

                        $registro->where('name', 'like', '%' . $val . '%');
                        break;
                    case 'codigo_to_search':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('id', $val);
                        }
                        break;
                }
            }
        } //


        //$registro = \App\::where('active', '=', 'yes')->get();
        $ordemArr   = explode('-', $ordem);

        $oremCampo      = $ordemArr[0];
        $oremTipo       = $ordemArr[1];
        $usePaginate    = $consulta['usePaginate'] ?? 0;
        $usePaginate    = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::PAGINACAO_ITENS_POR_PAGINA_PADRAO;
        $usePaginate    = (int) $usePaginate;
        if ($usePaginate > 0) {
            $registro   = $registro->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro   = $registro->orderBy($oremCampo, $oremTipo)->get();
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
