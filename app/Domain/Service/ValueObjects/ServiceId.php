<?php

namespace App\Domain\Service\ValueObjects;

class ServiceId
{
    private string $value;

    public function __construct(string $value)
    {
        if ((int) $value < 0) {
            throw new \InvalidArgumentException("The service ID cannot be empty");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
