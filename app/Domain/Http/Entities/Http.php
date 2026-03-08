<?php

namespace App\Domain\Http\Entities;

use App\Domain\Http\ValueObjects\HttpBody;
use App\Domain\Http\ValueObjects\HttpCode;
use App\Domain\Http\ValueObjects\HttpDataRequest;
use App\Domain\Http\ValueObjects\HttpHeader;
use App\Domain\Http\ValueObjects\HttpId;
use App\Domain\Http\ValueObjects\HttpUrl;

class Http
{
    protected HttpId $id;
    protected HttpCode $httpCode;
    protected HttpDataRequest $httpDataRequest;
    protected HttpUrl $httpUrl;
    protected HttpHeader $httpHeader;
    protected HttpBody $httpBody;

    public function setId(HttpId $id): Http
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): HttpId
    {
        return $this->id;
    }

    public function setCode(HttpCode $httpCode): Http
    {
        $this->httpCode = $httpCode;
        return $this;
    }

    public function getCode(): HttpCode
    {
        return $this->httpCode;
    }

    public function setDataRequest(HttpDataRequest $httpDataRequest): Http
    {
        $this->httpDataRequest = $httpDataRequest;
        return $this;
    }

    public function getDataRequest(): HttpDataRequest
    {
        return $this->httpDataRequest;
    }

    public function setUrl(HttpUrl $httpUrl): Http
    {
        $this->httpUrl = $httpUrl;
        return $this;
    }

    public function getUrl(): HttpUrl
    {
        return $this->httpUrl;
    }

    public function setHeader(HttpHeader $httpHeader): Http
    {
        $this->httpHeader = $httpHeader;
        return $this;
    }

    public function getHeader(): HttpHeader
    {
        return $this->httpHeader;
    }


    public function setBody(HttpBody $httpBody): Http
    {
        $this->httpBody = $httpBody;
        return $this;
    }

    public function getBody(): HttpBody
    {
        return $this->httpBody;
    }
}
