<?php

namespace App\Helpers;

use App\Domain\Person\ValueObjects\PersonId;
use App\Exceptions\PessoaException;
use App\Infrastructure\Persistence\Eloquent\Person\PersonRepository;

class PessoaHelper extends BaseHelper
{
    public function __construct(protected readonly PersonRepository $personRepository)
    {
    }
    public function info($dados, $id)
    {
        $id = $id ?? $dados['id'];

        if ($id <= 0) {
            throw new PessoaException('Parâmetro inválido. Entre em contato com o supote.');
        }

        $registro = $this->personRepository->findById(new PersonId((string) $id));

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
        return $this->personRepository->getAll($dados);
    }
}
