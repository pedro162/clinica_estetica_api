<?php

namespace App\Application\Services\WorkOrder\CancelingMotive;

use Illuminate\Support\Collection;

interface GetAllCancelingMotiveApplicationServiceInterface
{
    public function handler(array $filters = []): ?Collection;
}
