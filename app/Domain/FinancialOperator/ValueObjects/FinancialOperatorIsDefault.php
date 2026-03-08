<?php

namespace App\Domain\FinancialOperator\ValueObjects;

class FinancialOperatorIsDefault
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('The is default value cannot be empty');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
