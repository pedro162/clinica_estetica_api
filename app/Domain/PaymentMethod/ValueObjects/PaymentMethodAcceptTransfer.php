<?php

namespace App\Domain\PaymentMethod\ValueObjects;

class PaymentMethodAcceptTransfer
{
    private string $value;

    public function __construct(string $value)
    {
        if (!empty($value)) {
            if (!in_array($value, ['yes', 'no'])) {
                throw new \InvalidArgumentException("The cashier accept type is invalid. It should be either (yes, no)");
            }
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
