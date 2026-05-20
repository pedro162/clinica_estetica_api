<?php

namespace App\Domain\WorkOrderCancelingMotive\ValueObjects;

class WorkOrderCancelingMotivePersonId
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
