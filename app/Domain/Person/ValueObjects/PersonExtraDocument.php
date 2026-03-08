<?php

namespace App\Domain\Person\ValueObjects;

class PersonExtraDocument
{
    private string $value;

    public function __construct(string $value)
    {
        if ((isset($value) && strlen(trim($value)) > 0)) {
            $hasNotOnlyNumber = preg_match('/\D/', $value);
            if ($hasNotOnlyNumber) {
                throw new \InvalidArgumentException('Person extra document should contain only numbers');
            }
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
