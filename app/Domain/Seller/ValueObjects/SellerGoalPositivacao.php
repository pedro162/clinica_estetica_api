<?php

namespace App\Domain\Seller\ValueObjects;

class SellerGoalPositivacao
{
    private float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}
