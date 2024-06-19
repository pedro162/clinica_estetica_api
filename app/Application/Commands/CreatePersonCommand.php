<?php

namespace App\Application\Commands;

use App\Application\Commands\BasePersonCommand;

class CreatePersonCommand extends BasePersonCommand
{

    public function personId(string $personId): CreatePersonCommand
    {
        $this->personId = $personId;
        return $this;
    }

    public function personName(string $personName): CreatePersonCommand
    {
        $this->personName = $personName;
        return $this;
    }

    public function personDocument(string $personDocument): CreatePersonCommand
    {
        $this->personDocument = $personDocument;
        return $this;
    }

    public function personOptionalName(string $personOptionalName): CreatePersonCommand
    {
        $this->personOptionalName = $personOptionalName;
        return $this;
    }

    public function personExtraDocument(string $personExtraDocument): CreatePersonCommand
    {
        $this->personExtraDocument = $personExtraDocument;
        return $this;
    }

    public function personSex(string $personSex): CreatePersonCommand
    {
        $this->personSex = $personSex;
        return $this;
    }

    public function personEmail(string $personEmail): CreatePersonCommand
    {
        $this->personEmail = $personEmail;
        return $this;
    }
}
