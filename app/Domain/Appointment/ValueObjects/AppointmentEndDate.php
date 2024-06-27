<?php

namespace App\Domain\Appointment\ValueObjects;

class AppointmentEndDate
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException("Appointment end date cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
