<?php

namespace App\Domain\City\ValueObjects;

class CityCode
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException("City code cannot be empty");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
