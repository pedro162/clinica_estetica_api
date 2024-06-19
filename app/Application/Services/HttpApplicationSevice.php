<?php

namespace App\Application\Services;

use App\Application\Commands\CreateHttpCommand;
use App\Application\Handlers\CreateHttpHandler;
use App\Domain\Person\Entities\Person;
use App\Funcionario;

class HttpApplicationSevice
{
    private CreateHttpHandler $createPersonHandler;

    public function __construct(CreateHttpHandler $createPersonHandler)
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

        $command = new CreateHttpCommand();
        
        $command->personId($personId)->personName($personName)
            ->personOptionalName($personOptionalName)
            ->personDocument($personDocument)
            ->personExtraDocument($personExtraDocument)
            ->personSex($personSex)
            ->personEmail($personEmail);

        return $this->createPersonHandler->handler($command);
    }
}
