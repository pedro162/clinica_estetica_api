<?php

namespace App\Domain\Country\ValueObjects;

class CountryIsDefault
{
    private bool $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}
