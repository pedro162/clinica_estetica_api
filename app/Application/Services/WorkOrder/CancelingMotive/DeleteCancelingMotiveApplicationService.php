<?php

namespace App\Application\Services\WorkOrder\CancelingMotive;

use App\Application\Commands\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Application\Handlers\WorkOrder\CancelingMotive\DeleteCancelingMotiveHandler;

class DeleteCancelingMotiveApplicationService implements \App\Application\Services\WorkOrder\CancelingMotive\DeleteCancelingMotiveApplicationServiceInterface
{
    private DeleteCancelingMotiveHandler $deleteCancelingMotiveHandler;

    public function __construct(DeleteCancelingMotiveHandler $deleteCancelingMotiveHandler)
    {
        $this->deleteCancelingMotiveHandler = $deleteCancelingMotiveHandler;
    }

    public function handler(CreateCancelingMotiveCommand $command): void
    {
        $this->deleteCancelingMotiveHandler->handler($command);
    }
}
