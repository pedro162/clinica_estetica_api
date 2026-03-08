<?php

namespace App\Domain\FinancialOperator\ValueObjects;

class FinancialOperatorDiscountPercentage
{
    private float $value;

    public function __construct(float $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('The discount value cannot be negative');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
