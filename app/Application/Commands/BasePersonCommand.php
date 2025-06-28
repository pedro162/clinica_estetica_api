<?php

namespace App\Application\Commands;

abstract class BasePersonCommand
{
    protected string $personId;
    protected string $personName;
    protected string $personOptionalName;
    protected string $personDocument;
    protected string $personExtraDocument;
    protected string $personSex;
    protected string $personEmail;
    protected string $personBirthOrFoundation;
    protected string $personType;
    protected string $personUserId;
    protected string $personUserUpdateId;
    protected string $personTenantId;
    protected string $personActive;

    public function getPersonId(): ?string
    {
        return $this->personId;
    }

    public function getId(): ?string
    {
        return $this->personId;
    }

    public function getPersonName(): ?string
    {
        return $this->personName;
    }
    public function getPersonOptionalName(): ?string
    {
        return $this->personOptionalName;
    }

    public function getPersonDocument(): ?string
    {
        return $this->personDocument;
    }

    public function getPersonExtraDocument(): ?string
    {
        return $this->personExtraDocument;
    }

    public function getPersonSex(): ?string
    {
        return $this->personSex;
    }
    public function getPersonEmail(): ?string
    {
        return $this->personEmail;
    }
}
