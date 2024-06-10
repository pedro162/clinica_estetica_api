<?php

namespace App\Domain\Person\Entities;

use App\Domain\Person\ValueObjects\PersonDocument;
use App\Domain\Person\ValueObjects\PersonEmail;
use App\Domain\Person\ValueObjects\PersonExtraDocument;
use App\Domain\Person\ValueObjects\PersonId;
use App\Domain\Person\ValueObjects\PersonName;
use App\Domain\Person\ValueObjects\PersonOptionalName;
use App\Domain\Person\ValueObjects\PersonSex;

class Person
{
    protected PersonId $id;
    protected PersonName $name;
    protected PersonOptionalName $optionalName;
    protected PersonDocument $document;
    protected PersonExtraDocument $extraDocument;
    protected PersonEmail $email;
    protected PersonSex $sex;
    /* 
'name'
'name_opcional'
'documento'
'documento_complementar'
'nascimento_fundacao'
'sexo'
'email' */

    public function setId(PersonId $id): void
    {
        $this->id = $id;
    }

    public function getId(): PersonId
    {
        return $this->id;
    }

    public function setName(PersonName $name): void
    {
        $this->name = $name;
    }

    public function getName(): PersonName
    {
        return $this->name;
    }

    public function setOptionalName(PersonOptionalName $optionalName): void
    {
        $this->optionalName = $optionalName;
    }

    public function getOptionalName(): PersonOptionalName
    {
        return $this->optionalName;
    }

    public function setDocument(PersonDocument $document): void
    {
        $this->document = $document;
    }

    public function getDocument(): PersonDocument
    {
        return $this->document;
    }

    public function setExtraDocument(PersonExtraDocument $extraDocument): void
    {
        $this->extraDocument = $extraDocument;
    }

    public function getExtraDocument(): PersonExtraDocument
    {
        return $this->extraDocument;
    }

    public function setEmail(PersonEmail $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): PersonEmail
    {
        return $this->email;
    }

    public function setSex(PersonSex $sex): void
    {
        $this->sex = $sex;
    }
    public function getSex(): PersonSex
    {
        return $this->sex;
    }
}
