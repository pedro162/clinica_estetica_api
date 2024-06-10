<?php

namespace App\Application\Commands;

use App\Application\Commands\BasePersonCommand;

class CreatePersonCommand extends BasePersonCommand
{
    public function __construct(
        string $personId = '',
        string $personName = '',
        string $personOptionalName = '',
        string $personDocument = '',
        string $personExtraDocument = '',
        string $personSex = '',
        string $personEmail = ''
    ) {
        $this->personId = $personId;
        $this->personName = $personName;
        $this->personDocument = $personDocument;
        $this->personOptionalName = $personOptionalName;
        $this->personExtraDocument = $personExtraDocument;
        $this->personSex = $personSex;
        $this->personEmail = $personEmail;
    }
}
