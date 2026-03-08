<?php

namespace App\Domain\Cashier\ValueObjects;

class CashierMinValue
{
    private string $value;

    public function __construct(string $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('The cashier min value cannot be native');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
