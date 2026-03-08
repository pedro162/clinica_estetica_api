<?php

namespace App\Domain\PaymentMethod\ValueObjects;

class PaymentMethodBranchId
{
    private string $value;

    public function __construct(string $value)
    {
        if ((int) $value < 0) {
            throw new \InvalidArgumentException('The cashier branch ID cannot be empty');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
