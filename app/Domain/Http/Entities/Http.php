<?php

namespace App\Domain\Http\Entities;

use App\Domain\Http\ValueObjects\HttpId;
use App\Domain\Http\ValueObjects\HttpName;
use App\Domain\Http\Interfaces\HttpInterface;

class Http extends HttpInterface
{
    protected HttpId $id;
    protected HttpName $name;
    /* 
'name'
'name_opcional'
'documento'
'documento_complementar'
'nascimento_fundacao'
'sexo'
'email' */

    public function setId(HttpId $id): void
    {
        $this->id = $id;
    }

    public function getId(): HttpId
    {
        return $this->id;
    }

    public function setName(HttpName $name): void
    {
        $this->name = $name;
    }

    public function getName(): HttpName
    {
        return $this->name;
    }
}
