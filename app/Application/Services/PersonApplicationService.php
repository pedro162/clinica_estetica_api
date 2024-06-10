<?php

namespace App\Application\Services;

use App\Application\Commands\CreatePersonCommand;
use App\Application\Handlers\CreatePersonHandler;
use App\Domain\Person\Entities\Person;
use App\Funcionario;

class PersonApplicationService
{
    private CreatePersonHandler $createPersonHandler;

    public function __construct(CreatePersonHandler $createPersonHandler)
    {
        $this->createPersonHandler = $createPersonHandler;
    }

    public function createPerson(
        string $personId = '',
        string $personName = '',
        string $personOptionalName = '',
        string $personDocument = '',
        string $personExtraDocument = '',
        string $personSex = '',
        string $personEmail = ''
    ): ?Person {
        $command = new CreatePersonCommand(
            $personId,
            $personName,
            $personOptionalName,
            $personDocument,
            $personExtraDocument,
            $personSex,
            $personEmail
        );
        return $this->createPersonHandler->handler($command);
    }
}
