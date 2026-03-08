<?php

namespace App\Domain\PaymentMethod\ValueObjects;

class PaymentMethodBillingCode
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('The billing code value cannot be empty');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
