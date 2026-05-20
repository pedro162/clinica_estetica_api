<?php

namespace App\Application\Services\WorkOrder\CancelingMotive;

use App\Application\Commands\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Application\Handlers\WorkOrder\CancelingMotive\CreateCancelingMotiveHandler;
use App\MotivoCancelamentoOrdemServico as CancelingMotiveModel;

class StoreCancelingMotiveApplicationService implements StoreCancelingMotiveApplicationServiceInterface
{
    private CreateCancelingMotiveHandler $createCancelingMotiveHandler;

    public function __construct(CreateCancelingMotiveHandler $createCancelingMotiveHandler)
    {
        $this->createCancelingMotiveHandler = $createCancelingMotiveHandler;
    }

    public function handler(CreateCancelingMotiveCommand $command): ?CancelingMotiveModel
    {
        return $this->createCancelingMotiveHandler->handler($command);
    }
}
