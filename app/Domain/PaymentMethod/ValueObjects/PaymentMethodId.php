<?php

namespace App\Domain\PaymentMethod\ValueObjects;

class PaymentMethodId
{
    private string $value;

    public function __construct(string $value)
    {
        if ((int) $value < 0) {
            throw new \InvalidArgumentException("The cashier ID cannot be empty");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
