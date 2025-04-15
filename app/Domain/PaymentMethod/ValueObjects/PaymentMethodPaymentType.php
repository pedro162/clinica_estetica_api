<?php

namespace App\Domain\PaymentMethod\ValueObjects;

class PaymentMethodPaymentType
{
    private string $value;
    public const TYPES_AVAILABLE = [
        'cartao_credito',
        'cartao_debito',
        'boleto',
        'dinheiro'
    ];

    public function __construct(string $value)
    {
        if (empty($value)) {
            if (!in_array($value, self::TYPES_AVAILABLE)) {
                throw new \InvalidArgumentException("The payment type is invalid. It should be either (".implode(', ', self::TYPES_AVAILABLE).")");
            }
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
