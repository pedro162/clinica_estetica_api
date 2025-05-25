<?php

namespace App\Domain\FinancialOperator\ValueObjects;

class FinancialOperatorOurNumber
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("The current remittance number cannot be empty");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
