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
        CreateHttpCommand $command
    ): ?Http {

        return $this->createHttpHandler->handler($command);
    }
}
