<?php

namespace App\Application\Services\CreditCardBrand;

use App\Application\Commands\CreditCardBrand\CreateCreditCardBrandCommand;
use App\Application\Handlers\CreditCardBrand\CreateCreditCardBrandHandler;
use App\Application\Handlers\CreditCardBrand\DestroyCreditCardBrandHandler;
use App\Application\Handlers\CreditCardBrand\GetAllCreditCardBrandHandler;
use App\Application\Handlers\CreditCardBrand\GetCreditCardBrandByIdHandler;
use App\Application\Handlers\CreditCardBrand\UpdateCreditCardBrandHandler;
use App\BandeiraCartao;
use Illuminate\Support\Collection;

class CreditCardBrandApplicationService implements CreditCardBrandApplicationServiceInterface
{
    private CreateCreditCardBrandHandler $createCreditCardBrandHandler;
    protected GetAllCreditCardBrandHandler $getAllCreditCardBrandHandler;
    protected UpdateCreditCardBrandHandler $updateCreditCardBrandHandler;
    protected DestroyCreditCardBrandHandler $destroyCreditCardBrandHandler;
    protected GetCreditCardBrandByIdHandler $getCreditCardBrandByIdHandler;

    public function __construct(
        CreateCreditCardBrandHandler $createCreditCardBrandHandler,
        GetAllCreditCardBrandHandler $getAllCreditCardBrandHandler,
        UpdateCreditCardBrandHandler $updateCreditCardBrandHandler,
        GetCreditCardBrandByIdHandler $getCreditCardBrandByIdHandler,
        DestroyCreditCardBrandHandler $destroyCreditCardBrandHandler
    ) {
        $this->createCreditCardBrandHandler = $createCreditCardBrandHandler;
        $this->getAllCreditCardBrandHandler = $getAllCreditCardBrandHandler;
        $this->updateCreditCardBrandHandler = $updateCreditCardBrandHandler;
        $this->destroyCreditCardBrandHandler = $destroyCreditCardBrandHandler;
        $this->getCreditCardBrandByIdHandler = $getCreditCardBrandByIdHandler;
    }

    public function store(
        CreateCreditCardBrandCommand $command
    ): ?BandeiraCartao {
        return $this->createCreditCardBrandHandler->handler($command);
    }

    public function update(
        CreateCreditCardBrandCommand $command
    ): void {

        $this->updateCreditCardBrandHandler->handler($command);
    }

    public function destroy(
        CreateCreditCardBrandCommand $command
    ): void {

        $this->destroyCreditCardBrandHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllCreditCardBrandHandler->handler($data);
    }

    public function findById(
        CreateCreditCardBrandCommand $command
    ): ?BandeiraCartao {

        return $this->getCreditCardBrandByIdHandler->handler($command);
    }
}
