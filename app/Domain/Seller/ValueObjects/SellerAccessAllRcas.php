<?php

namespace App\Domain\Seller\ValueObjects;

class SellerAccessAllRcas
{
    private int $value;

    public function __construct(int $value)
    {
        if (in_array($value, [0, 1]) === false) {
            throw new \InvalidArgumentException('Seller access all RCAs must be either 0 or 1');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}
