<?php

namespace App\Domain\PaymentMethod\ValueObjects;

class PaymentMethodHasInstallments
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("The field, has installments, cannot be empty");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
