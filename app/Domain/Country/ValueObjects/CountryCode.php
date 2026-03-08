<?php

namespace App\Domain\Country\ValueObjects;

class CountryCode
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException('Country code cannot be empty');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
