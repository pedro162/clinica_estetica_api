<?php

namespace App\Domain\Seller\ValueObjects;

class SellerBranchId
{
    private bool $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}
