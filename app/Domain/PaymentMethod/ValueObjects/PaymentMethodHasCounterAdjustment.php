<?php

namespace App\Domain\PaymentMethod\ValueObjects;

class PaymentMethodHasCounterAdjustment
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("The field, has accounter adjustment, cannot be empty");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
