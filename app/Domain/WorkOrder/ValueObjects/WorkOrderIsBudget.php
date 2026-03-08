<?php

namespace App\Domain\WorkOrder\ValueObjects;

class WorkOrderIsBudget
{
    public function __construct(private string $value) {}

    public function __toString(): string
    {
        return $this->value;
    }
}
