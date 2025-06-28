<?php

namespace App\Domain\PaymentMethod\ValueObjects;

class PaymentMethodHasCreditLimit
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("The field, has credit limit, cannot be empty");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
