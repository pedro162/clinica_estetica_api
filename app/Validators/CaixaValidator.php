<?php

namespace App\Validators;

use \App\Caixa;
use \App\Exceptions\CobrancaReceberException;

class CaixaValidator
{


    public function validarCaixaBaixar(int $id, array $dados = [])
    {

        $erros = [];

        $id             = $id ?? $dados['id'];
        $callBack       = $dados['callBack'] ?? '';
        $caixa_id       = $dados['caixa_id'] ?? 0;

        if (! ($id > 0)) {
            throw new CobrancaReceberException('Parâmetro ínválido para o caixa de baixa');
        }

        $registro = Caixa::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if (! $registro) {
            throw new CobrancaReceberException('Registro não identificao. Tente novamente ou entre em contato com o suporte.');
        }

        return $erros;
    }
}
