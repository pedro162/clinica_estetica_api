<?php

declare(strict_types=1);

namespace App\Application\Handlers;

use App\Application\Commands\CreateHttpCommand;
use App\Domain\Http\Entities\Http;
use App\Domain\Http\Interfaces\HttpInterface;
use App\Domain\Http\Repositories\HttpRepositoryInterface;
use App\Domain\Http\ValueObjects\HttpDocument;
use App\Domain\Http\ValueObjects\HttpEmail;
use App\Domain\Http\ValueObjects\HttpExtraDocument;
use App\Domain\Http\ValueObjects\HttpId;
use App\Domain\Http\ValueObjects\HttpName;
use App\Domain\Http\ValueObjects\HttpOptionalName;
use App\Domain\Http\ValueObjects\HttpSex;

class HttpRequestResponseHandler
{
    private HttpRepositoryInterface $requestRepository;
    private HttpRepositoryInterface $responseRepository;
    private HttpInterface $request;
    private HttpInterface $response;

    public function requestHandler(CreateHttpCommand $command): Http
    {
        $http = new Http();
        $http->setId(new HttpId($command->getHttpId()));
        return $this->response = $this->requestRepository->save($http);
    }

    public function responseHandler(CreateHttpCommand $command): Http
    {
        $http = new Http();
        $http->setId(new HttpId($command->getHttpId()));
        return $this->response = $this->responseRepository->save($http);
    }

    public function requestRepository(HttpRepositoryInterface $repository): HttpRequestResponseHandler
    {
        $this->requestRepository = $repository;
        return $this;
    }

    public function responseRepository(HttpRepositoryInterface $repository): HttpRequestResponseHandler
    {
        $this->responseRepository = $repository;
        return $this;
    }
}
