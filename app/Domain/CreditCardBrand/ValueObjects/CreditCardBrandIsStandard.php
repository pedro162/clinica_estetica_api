<?php

namespace App\Domain\CreditCardBrand\ValueObjects;

class CreditCardBrandIsStandard
{
    private string $value;
    public const YES = 'yes';
    public const NO = 'no';
    public const ACCEPTED_VALUES = [
        self::YES,
        self::NO
    ];

    public function __construct(string $value)
    {
        if (empty($value) || !in_array($value, self::ACCEPTED_VALUES)) {
            throw new \InvalidArgumentException("The standard attribute cannot be empty");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
