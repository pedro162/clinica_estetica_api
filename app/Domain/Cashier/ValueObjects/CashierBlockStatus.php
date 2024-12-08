<?php

namespace App\Domain\Cashier\ValueObjects;

class CashierBlockStatus
{
    private string $value;

    public function __construct(string $value)
    {
        if (!empty($value)) {
            if (!in_array($value, ['bloqueado', 'liberado'])) {
                throw new \InvalidArgumentException("The cashier type is invalid. It should be either (bloqueado, liberado)");
            }
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
