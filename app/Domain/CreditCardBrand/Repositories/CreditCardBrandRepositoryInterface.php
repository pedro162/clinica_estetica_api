<?php

namespace App\Domain\CreditCardBrand\Repositories;

use App\BandeiraCartao;
use App\Domain\CreditCardBrand\Entities\CreditCardBrand;
use App\Domain\CreditCardBrand\ValueObjects\CreditCardBrandId;

interface CreditCardBrandRepositoryInterface
{
    public function save(CreditCardBrand $task): ?BandeiraCartao;
    public function findById(CreditCardBrandId $id): ?BandeiraCartao;
    public function getAll(array $filter = []): ?array;
    public function update(CreditCardBrand $parameter): void;
    public function destroy(CreditCardBrand $parameter): void;
}
