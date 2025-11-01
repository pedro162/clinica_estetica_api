<?php

namespace App\Application\Services\CreditCardBrand;

use App\Application\Commands\CreditCardBrand\CreateCreditCardBrandCommand;
use App\BandeiraCartao;
use App\Domain\CreditCardBrand\Entities\CreditCardBrand;
use Illuminate\Support\Collection;

interface CreditCardBrandApplicationServiceInterface
{
    public function store(
        CreateCreditCardBrandCommand $command
    ): ?BandeiraCartao;

    public function findById(
        CreateCreditCardBrandCommand $command
    ): ?BandeiraCartao;

    public function update(
        CreateCreditCardBrandCommand $command
    ): void;

    public function destroy(
        CreateCreditCardBrandCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;
}
