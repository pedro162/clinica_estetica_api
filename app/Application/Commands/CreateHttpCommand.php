<?php

namespace App\Application\Commands;

class CreateHttpCommand
{
    protected string $httpId;
    protected string $httpCode;
    protected string $httpDataRequest;
    protected string $httpUrl;
    protected string $httpHeader;
    protected string $httpBody;

    public function getHttpId(): ?string
    {
        return $this->httpId;
    }

    public function getHttpCode(): ?string
    {
        return $this->httpCode;
    }
    public function getHttpDataRequest(): ?string
    {
        return $this->httpDataRequest;
    }

    public function getHttpUrl(): ?string
    {
        return $this->httpUrl;
    }

    public function getHttpHeader(): ?string
    {
        return $this->httpHeader;
    }

    public function getHttpBody(): ?string
    {
        return $this->httpBody;
    }

    public function httpId(string $httpId): CreateHttpCommand
    {
        $this->httpId = $httpId;
        return $this;
    }

    public function httpCode(string $httpCode): CreateHttpCommand
    {
        $this->httpCode = $httpCode;
        return $this;
    }

    public function httpUrl(string $httpUrl): CreateHttpCommand
    {
        $this->httpUrl = $httpUrl;
        return $this;
    }

    public function httpDataRequest(string $httpDataRequest): CreateHttpCommand
    {
        $this->httpDataRequest = $httpDataRequest;
        return $this;
    }

    public function httpHeader(string $httpHeader): CreateHttpCommand
    {
        $this->httpHeader = $httpHeader;
        return $this;
    }

    public function httpBody(string $httpBody): CreateHttpCommand
    {
        $this->httpBody = $httpBody;
        return $this;
    }
}
