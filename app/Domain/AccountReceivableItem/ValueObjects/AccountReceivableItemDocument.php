<?php

namespace App\Domain\AccountReceivableItem\ValueObjects;

class AccountReceivableItemDocument
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('The account receivable document cannot be empty');
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
