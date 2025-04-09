<?php

namespace App\Domain\PaymentMethod\ValueObjects;

class PaymentMethodBalance
{
    private string $value;

    public function __construct(string $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException("The cashier balance value cannot be empty");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
