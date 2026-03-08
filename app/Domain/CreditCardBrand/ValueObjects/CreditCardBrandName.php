<?php

namespace App\Domain\CreditCardBrand\ValueObjects;

class CreditCardBrandName
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Credit card brand name cannot be empty');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
