<?php

namespace App\Domain\PaymentMethod\ValueObjects;

class PaymentMethodType
{
    private string $value;
    public const TYPES_AVAILABLE = [
        'a vista',
        'a prazo',
        'cartao'
    ];

    public function __construct(string $value)
    {
        if (empty($value)) {
            if (!in_array($value, self::TYPES_AVAILABLE)) {
                throw new \InvalidArgumentException("The type is invalid. It should be either (" . implode(', ', self::TYPES_AVAILABLE) . ")");
            }
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
