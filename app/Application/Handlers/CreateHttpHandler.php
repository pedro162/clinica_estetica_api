<?php

namespace App\Application\Handlers;

use App\Application\Commands\CreatePersonCommand;
use App\Domain\Person\Entities\Person;
use App\Domain\Person\Repositories\PersonRepositoryInterface;
use App\Domain\Person\ValueObjects\PersonDocument;
use App\Domain\Person\ValueObjects\PersonEmail;
use App\Domain\Person\ValueObjects\PersonExtraDocument;
use App\Domain\Person\ValueObjects\PersonId;
use App\Domain\Person\ValueObjects\PersonName;
use App\Domain\Person\ValueObjects\PersonOptionalName;
use App\Domain\Person\ValueObjects\PersonSex;

class CreateHttpHandler
{
    private PersonRepositoryInterface $repository;

    public function __construct(PersonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePersonCommand $command): ?Person
    {
        $person = new Person();
        $person->setId(new PersonId($command->getPersonId()));
        $person->setName(new PersonName($command->getPersonName()));
        $person->setOptionalName(new PersonOptionalName($command->getPersonOptionalName()));
        $person->setDocument(new PersonDocument($command->getPersonDocument()));
        $person->setExtraDocument(new PersonExtraDocument($command->getPersonExtraDocument()));
        $person->setSex(new PersonSex($command->getPersonSex()));
        $person->setEmail(new PersonEmail($command->getPersonEmail()));

        return $this->repository->save($person);
    }
}
