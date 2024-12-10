<?php

namespace App\Domain\AccountReceivable\ValueObjects;

class AccountReceivableDescription
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("The cashier description cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
