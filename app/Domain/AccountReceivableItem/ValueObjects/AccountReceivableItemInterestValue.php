<?php

namespace App\Domain\AccountReceivableItem\ValueObjects;

class AccountReceivableItemInterestValue
{
    private string $value;

    public function __construct(string $value)
    {
        if ($value === '') {
            throw new \InvalidArgumentException("The account receivable's interested value cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
