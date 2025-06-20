<?php

namespace App\Domain\PersonAddress\ValueObjects;

class PersonAddressComplement
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException("The address complement field document should contain only numbers");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
