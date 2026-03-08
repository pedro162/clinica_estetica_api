<?php

namespace App\Domain\PersonAddress\ValueObjects;

class PersonAddressCity
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException('The city field is not valid');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
