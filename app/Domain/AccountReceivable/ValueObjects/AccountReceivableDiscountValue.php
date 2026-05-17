<?php

namespace App\Domain\AccountReceivable\ValueObjects;

class AccountReceivableDiscountValue
{
    private string $value;

    public function __construct(string $value)
    {
        if ($value === '') {
            throw new \InvalidArgumentException("The account receivable's discount value cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
