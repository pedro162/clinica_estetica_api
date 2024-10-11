<?php

namespace App\Domain\Parameter\Repositories;

use App\Domain\Parameter\Entities\Parameter;
use App\Domain\Parameter\ValueObjects\ParameterId;

interface ParameterRepositoryInterface
{
    public function save(Parameter $parameter): ?Parameter;
    public function findById(ParameterId $id): ?Parameter;
    public function getAll(array $filter);
}
