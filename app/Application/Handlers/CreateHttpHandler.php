<?php

namespace App\Application\Handlers;

use App\Application\Commands\CreateHttpCommand;
use App\Domain\Http\Entities\Http;
use App\Domain\Http\Repositories\HttpRepositoryInterface;
use App\Domain\Http\ValueObjects\HttpBody;
use App\Domain\Http\ValueObjects\HttpCode;
use App\Domain\Http\ValueObjects\HttpDocument;
use App\Domain\Http\ValueObjects\HttpEmail;
use App\Domain\Http\ValueObjects\HttpExtraDocument;
use App\Domain\Http\ValueObjects\HttpHeader;
use App\Domain\Http\ValueObjects\HttpId;
use App\Domain\Http\ValueObjects\HttpName;
use App\Domain\Http\ValueObjects\HttpOptionalName;
use App\Domain\Http\ValueObjects\HttpSex;
use App\Domain\Http\ValueObjects\HttpUrl;

class CreateHttpHandler
{
    private HttpRepositoryInterface $repository;

    public function __construct(HttpRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateHttpCommand $command): ?Http
    {
        $httpObject = new Http();
        $httpObject->setId(new HttpId($command->getHttpId()));
        $httpObject->setBody(new HttpBody($command->getHttpBody()));
        $httpObject->setUrl(new HttpUrl($command->getHttpUrl()));
        $httpObject->setHeader(new HttpHeader($command->getHttpHeader()));
        $httpObject->setCode(new HttpCode($command->getHttpCode()));

        return $this->repository->save($httpObject);
    }
}
