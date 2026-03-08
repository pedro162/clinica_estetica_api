<?php

namespace App\Domain\PersonAddress\ValueObjects;

class PersonAddressImportance
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException('The importance field cannot be empty');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
