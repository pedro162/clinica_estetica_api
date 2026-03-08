<?php

namespace App\Domain\Http\ValueObjects;

class HttpBody
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException('Http Body cannot be empty');
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
