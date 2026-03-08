<?php

namespace App\Domain\AccountReceivableItem\ValueObjects;

class AccountReceivableItemStatus
{
    private string $value;

    public function __construct(string $value)
    {
        if (!empty($value)) {
            if (!in_array($value, ['aberto', 'pago', 'devolvido', 'estornado'])) {
                throw new \InvalidArgumentException('The account receivable type is invalid. It should be either (aberto, pago, devolvido, estornado)');
            }
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
