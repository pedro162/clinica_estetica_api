<?php

namespace App\Domain\Notification\Entities;

use App\Domain\Notification\ValueObjects\NotificationId;
use App\Domain\Notification\ValueObjects\NotificationName;

class Notification
{
    protected NotificationId $id;
    protected NotificationName $name;
    /* 
'name'
'name_opcional'
'documento'
'documento_complementar'
'nascimento_fundacao'
'sexo'
'email' */

    public function setId(NotificationId $id): void
    {
        $this->id = $id;
    }

    public function getId(): NotificationId
    {
        return $this->id;
    }

    public function setName(NotificationName $name): void
    {
        $this->name = $name;
    }

    public function getName(): NotificationName
    {
        return $this->name;
    }
}
