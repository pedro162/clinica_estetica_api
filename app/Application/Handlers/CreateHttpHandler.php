<?php

namespace App\Application\Handlers;

use App\Application\Commands\CreateHttpCommand;
use App\Domain\Http\Entities\Http;
use App\Domain\Http\Repositories\HttpRepositoryInterface;
use App\Domain\Http\ValueObjects\HttpDocument;
use App\Domain\Http\ValueObjects\HttpEmail;
use App\Domain\Http\ValueObjects\HttpExtraDocument;
use App\Domain\Http\ValueObjects\HttpId;
use App\Domain\Http\ValueObjects\HttpName;
use App\Domain\Http\ValueObjects\HttpOptionalName;
use App\Domain\Http\ValueObjects\HttpSex;

class CreateHttpHandler
{
    private HttpRepositoryInterface $repository;

    public function __construct(HttpRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateHttpCommand $command): ?Http
    {
        $person = new Http();
        $person->setId(new HttpId($command->getHttpId()));

        return $this->repository->save($person);
    }
}
