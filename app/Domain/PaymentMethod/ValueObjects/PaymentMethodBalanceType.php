<?php

namespace App\Domain\PaymentMethod\ValueObjects;

class PaymentMethodBalanceType
{
    private string $value;

    public function __construct(string $value)
    {
        if (!empty($value)) {
            if (!in_array($value, ['positivo', 'negativo'])) {
                throw new \InvalidArgumentException("The cashier balance type is invalid. It should be either(positivo, negativo)");
            }
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
