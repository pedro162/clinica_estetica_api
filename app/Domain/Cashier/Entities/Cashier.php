<?php

namespace App\Domain\Cashier\Entities;

use App\Domain\Cashier\ValueObjects\CashierId;
use App\Domain\Cashier\ValueObjects\CashierName;

class Cashier
{
    protected CashierId $id;
    protected CashierName $name;

    public function id(CashierId $id): Cashier
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?CashierId
    {
        return $this->id ?? null;
    }

    public function name(CashierName $name): Cashier
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?CashierName
    {
        return $this->name ?? null;
    }
}
