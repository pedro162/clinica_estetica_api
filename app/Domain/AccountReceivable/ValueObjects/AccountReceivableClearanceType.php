<?php

namespace App\Domain\AccountReceivable\ValueObjects;

class AccountReceivableClearanceType
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("The account receivable's clearance type cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
