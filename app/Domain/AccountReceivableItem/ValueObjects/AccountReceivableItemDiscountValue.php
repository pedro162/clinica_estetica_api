<?php

namespace App\Domain\AccountReceivableItem\ValueObjects;

class AccountReceivableItemDiscountValue
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("The account receivable's discount value cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
