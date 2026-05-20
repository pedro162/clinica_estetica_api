<?php

namespace App\Application\Services\WorkOrder\CancelingMotive;

use App\Application\Commands\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Application\Handlers\WorkOrder\CancelingMotive\GetByIdCancelingMotiveHandler;
use App\MotivoCancelamentoOrdemServico as CancelingMotiveModel;

class GetByIdCancelingMotiveApplicationService implements GetByIdCancelingMotiveApplicationServiceInterface
{
    private GetByIdCancelingMotiveHandler $getByIdCancelingMotiveHandler;

    public function __construct(GetByIdCancelingMotiveHandler $getByIdCancelingMotiveHandler)
    {
        $this->getByIdCancelingMotiveHandler = $getByIdCancelingMotiveHandler;
    }

    public function handler(CreateCancelingMotiveCommand $command): ?CancelingMotiveModel
    {
        $cancelingMotive = $this->getByIdCancelingMotiveHandler->handler($command);

        if (!$cancelingMotive) {
            abort(404, 'CancelingMotive not found');
        }

        return $cancelingMotive;
    }
}
