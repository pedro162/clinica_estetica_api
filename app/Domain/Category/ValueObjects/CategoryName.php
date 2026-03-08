<?php

namespace App\Domain\Category\ValueObjects;

final class CategoryName
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = trim($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
