<?php

namespace App\Domain\Person\ValueObjects;

class PersonDocument
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException("Person document cannot be empty");
        }

        if ((isset($value) && strlen(trim($value)) > 0)) {
            $hasNotOnlyNumber = preg_match('/\D/', $value);
            if ($hasNotOnlyNumber) {
                throw new \InvalidArgumentException("Person document should contain only numbers");
            }
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
