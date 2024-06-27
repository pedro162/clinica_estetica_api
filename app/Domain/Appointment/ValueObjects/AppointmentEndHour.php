<?php

namespace App\Domain\Appointment\ValueObjects;

class AppointmentEndHour
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException("Appointment end hour cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
