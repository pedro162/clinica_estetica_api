<?php

namespace App\Domain\Seller\ValueObjects;

class SellerStatus
{
    private string $value;

    public function __construct(string $value)
    {
        if (!in_array($value, ['ativo', 'inativo'], true)) {
            throw new \InvalidArgumentException('Seller status must be either ativo or inativo');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
