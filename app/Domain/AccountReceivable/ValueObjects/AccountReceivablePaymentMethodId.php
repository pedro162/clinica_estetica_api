<?php

namespace App\Domain\AccountReceivable\ValueObjects;

class AccountReceivablePaymentMethodId
{
    private string $value;

    public function __construct(string $value)
    {
        if ((int) $value < 0) {
            throw new \InvalidArgumentException("The account receivable payment method ID cannot be empty");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
