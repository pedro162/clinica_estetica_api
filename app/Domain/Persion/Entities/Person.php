<?php

namespace App\Domain\Person\Entities;

use App\Domain\Person\ValueObjects\PersonId;
use App\Domain\Person\ValueObjects\PersonName;

class Person
{
    protected PersonId $id;
    protected PersonName $name;

    public function __construct(PersonId $id, PersonName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): PersonId
    {
        return $this->id;
    }

    public function getName(): PersonName
    {
        return $this->name;
    }
}
