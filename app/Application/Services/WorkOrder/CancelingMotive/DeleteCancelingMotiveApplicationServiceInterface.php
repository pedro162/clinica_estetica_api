<?php

namespace App\Application\Services\WorkOrder\CancelingMotive;

use App\Application\Commands\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;

interface DeleteCancelingMotiveApplicationServiceInterface
{
    public function handler(CreateCancelingMotiveCommand $command): void;
}
