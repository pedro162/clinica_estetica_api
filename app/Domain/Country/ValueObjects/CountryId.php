<?php

namespace App\Domain\Country\ValueObjects;

class CountryId
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException('Country ID cannot be empty');
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
