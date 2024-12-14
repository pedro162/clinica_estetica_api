<?php

namespace App\Domain\AccountReceivableItem\ValueObjects;

class AccountReceivableItemPaymentDate
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("The account receivable's payment date cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
