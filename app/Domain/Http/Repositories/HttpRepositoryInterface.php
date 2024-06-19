<?php

namespace App\Domain\Http\Repositories;

use App\Domain\Http\Entities\Http;
use App\Domain\Http\ValueObjects\HttpId;

interface HttpRepositoryInterface
{
    public function save(Http $task): ?Http;
    public function findById(HttpId $id): ?Http;
}
