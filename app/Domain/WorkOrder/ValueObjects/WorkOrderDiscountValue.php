<?php

namespace App\Domain\WorkOrder\ValueObjects;

class WorkOrderDiscountValue
{
    public function __construct(private float $value)
    {
    }

    public function toFloat(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
