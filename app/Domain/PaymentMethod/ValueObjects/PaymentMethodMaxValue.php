<?php

namespace App\Domain\PaymentMethod\ValueObjects;

class PaymentMethodMaxValue
{
    private string $value;

    public function __construct(string $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException("The cashier max value cannot be empty");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
