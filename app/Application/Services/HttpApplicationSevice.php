<?php

namespace App\Application\Services;

use App\Application\Commands\CreateHttpCommand;
use App\Application\Handlers\CreateHttpHandler;
use App\Domain\Http\Entities\Http;
use App\Funcionario;

class HttpApplicationService
{
    private CreateHttpHandler $createHttpHandler;

    public function __construct(CreateHttpHandler $createHttpHandler)
    {
        $this->createHttpHandler = $createHttpHandler;
    }

    public function createHttp(
        string $httpId = '',
        string $httpName = '',
        string $httpOptionalName = '',
        string $httpDocument = '',
        string $httpExtraDocument = '',
        string $httpSex = '',
        string $httpEmail = ''
    ): ?Http {

        $command = new CreateHttpCommand();

        $command->httpId($httpId);

        return $this->createHttpHandler->handler($command);
    }
}
