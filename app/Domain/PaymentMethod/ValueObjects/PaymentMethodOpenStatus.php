<?php

namespace App\Domain\PaymentMethod\ValueObjects;

class PaymentMethodOpenStatus
{
    private string $value;

    public function __construct(string $value)
    {
        if (!empty($value)) {
            if (!in_array($value, ['open', 'close'])) {
                throw new \InvalidArgumentException("The PaymentMethod type is invalid. It should be either (open, close)");
            }
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
