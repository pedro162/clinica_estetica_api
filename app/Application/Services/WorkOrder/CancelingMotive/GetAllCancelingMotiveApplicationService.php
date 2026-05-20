<?php

namespace App\Application\Services\WorkOrder\CancelingMotive;

use App\Application\Handlers\WorkOrder\CancelingMotive\GetAllCancelingMotiveHandler;
use Illuminate\Support\Collection;

class GetAllCancelingMotiveApplicationService implements \App\Application\Services\WorkOrder\CancelingMotive\GetAllCancelingMotiveApplicationServiceInterface
{
    private GetAllCancelingMotiveHandler $getAllCancelingMotiveHandler;

    public function __construct(GetAllCancelingMotiveHandler $getAllCancelingMotiveHandler)
    {
        $this->getAllCancelingMotiveHandler = $getAllCancelingMotiveHandler;
    }

    public function handler(array $filters = []): ?Collection
    {
        return $this->getAllCancelingMotiveHandler->handler($filters);
    }
}
