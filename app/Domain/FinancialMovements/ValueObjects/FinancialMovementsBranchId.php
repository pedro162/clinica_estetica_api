<?php

namespace App\Domain\FinancialMovements\ValueObjects;

class FinancialMovementsBranchId
{
    private string $value;

    public function __construct(string $value)
    {
        if ((int) $value < 0) {
            throw new \InvalidArgumentException('The financial movement branch ID cannot be empty');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
