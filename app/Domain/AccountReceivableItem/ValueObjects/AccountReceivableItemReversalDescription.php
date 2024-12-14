<?php

namespace App\Domain\AccountReceivableItem\ValueObjects;

class AccountReceivableItemReversalDescription
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("The account receivable's reversal description value cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
