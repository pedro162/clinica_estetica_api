<?php

namespace App\Domain\AccountReceivableItem\ValueObjects;

class AccountReceivableItemReversalPersonId
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('The account receivable reversal person ID cannot be empty');
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
