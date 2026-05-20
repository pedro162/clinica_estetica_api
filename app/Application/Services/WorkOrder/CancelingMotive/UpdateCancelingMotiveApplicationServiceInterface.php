<?php

namespace App\Application\Services\WorkOrder\CancelingMotive;

use App\Application\Commands\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;

interface UpdateCancelingMotiveApplicationServiceInterface
{
    public function handler(CreateCancelingMotiveCommand $command): void;
}
