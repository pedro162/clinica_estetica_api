<?php

namespace App\Domain\PaymentPlan\ValueObjects;

class PaymentPlanIsOpen
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException('The is open field cannot be empty');
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
