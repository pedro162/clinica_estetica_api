<?php

namespace App\Domain\PaymentPlan\ValueObjects;

class PaymentPlanShowAtCounter
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException('The show at accounter field cannot be empty');
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
