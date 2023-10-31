<?php

namespace App\Helpers;

use \App\Pessoa;
use \App\Grupo;
use \App\Telefone;
use \App\Logradouro;
use \App\Utilitarios;
use App\Exceptions\PessoaException;

class PessoaHelper
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
        /*
        if($logr = $registro->logradouro->where('importancia', '=', 'principal')->first()){
            $registro->logradouro = $logr->estado_logradouro->pais;
        }
        
        $registro->grupo;
        $registro->telefone;*/
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
}
