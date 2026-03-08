<?php

namespace App\Application\Services\Seller;

use App\Application\Commands\Seller\CreateSellerCommand;
use App\Rca;
use Illuminate\Support\Collection;

interface SellerApplicationServiceInterface
{
    public function store(
        CreateSellerCommand $command
    ): ?Rca;

    public function findById(
        CreateSellerCommand $command
    ): ?Rca;

    public function update(
        CreateSellerCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;

    public function destroy(
        CreateSellerCommand $command
    ): void;
}
