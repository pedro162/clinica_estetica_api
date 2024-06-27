<?php

namespace App\Domain\Appointment\ValueObjects;

class AppointmentStartDate
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException("Appointment date cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
