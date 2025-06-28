<?php

namespace App\Domain\FinancialOperator\ValueObjects;

class FinancialOperatorOurNumber
{
    private string $value;

    public function __construct(string $value)
    {
        if (trim($value) == '') {
            throw new \InvalidArgumentException("The our number value cannot be empty");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
