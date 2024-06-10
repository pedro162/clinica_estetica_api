<?php

namespace App\Domain\Person\ValueObjects;

class PersonEmail
{
    private string $value;

    public function __construct(string $value)
    {
        if ((isset($value) && strlen(trim($value)) > 0)) {
            $isValidEmail = filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
            if (!$isValidEmail) {
                throw new \InvalidArgumentException("Person email \"{$value}\" is not valid");
            }
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
