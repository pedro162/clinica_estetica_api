<?php

namespace App\Domain\FinancialOperator\ValueObjects;

class FinancialOperatorPersonId
{
    private string $value;

    public function __construct(string $value)
    {
        if ((int) $value < 0) {
            throw new \InvalidArgumentException("The person ID cannot be negative");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
