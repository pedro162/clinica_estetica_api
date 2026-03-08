<?php

namespace App\Domain\FinancialOperator\ValueObjects;

class FinancialOperatorProtestDaysQuantity
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('The protest days quantity value cannot be negative');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
