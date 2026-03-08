<?php

namespace App\Domain\AccountReceivableItem\ValueObjects;

class AccountReceivableItemCashboxId
{
    private string $value;

    public function __construct(string $value)
    {
        if ((int) $value < 0) {
            throw new \InvalidArgumentException('The account receivable cashier ID cannot be empty');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
