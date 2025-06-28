<?php

namespace App\Domain\FinancialOperator\ValueObjects;

class FinancialOperatorBranchId
{
    private string $value;

    public function __construct(string $value)
    {
        if ((int) $value < 0) {
            throw new \InvalidArgumentException("The financial operator's branch ID cannot be empty");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
