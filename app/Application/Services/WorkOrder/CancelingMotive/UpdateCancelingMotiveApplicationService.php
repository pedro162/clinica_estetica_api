<?php

namespace App\Application\Services\WorkOrder\CancelingMotive;

use App\Application\Commands\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Application\Handlers\WorkOrder\CancelingMotive\UpdateCancelingMotiveHandler;

class UpdateCancelingMotiveApplicationService implements UpdateCancelingMotiveApplicationServiceInterface
{
    private UpdateCancelingMotiveHandler $updateCancelingMotiveHandler;

    public function __construct(UpdateCancelingMotiveHandler $updateCancelingMotiveHandler)
    {
        $this->updateCancelingMotiveHandler = $updateCancelingMotiveHandler;
    }

    public function handler(CreateCancelingMotiveCommand $command): void
    {
        $this->updateCancelingMotiveHandler->handler($command);
    }
}
