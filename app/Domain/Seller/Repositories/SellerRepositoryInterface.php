<?php

namespace App\Domain\Seller\Repositories;

use App\Domain\Seller\Entities\Seller;
use App\Domain\Seller\ValueObjects\SellerId;
use App\Rca;

interface SellerRepositoryInterface
{
    public function save(Seller $parameter): ?Rca;
    public function findById(SellerId $id): ?Rca;
    public function getAll(array $filter): ?array;
    public function update(Seller $parameter): void;
    public function destroy(Seller $parameter): void;
}
