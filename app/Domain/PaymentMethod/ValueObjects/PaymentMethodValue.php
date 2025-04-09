<?php

namespace App\Domain\PaymentMethod\ValueObjects;

class PaymentMethodMinValue
{
    private string $value;

    public function __construct(string $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException("The cashier min value cannot be native");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
