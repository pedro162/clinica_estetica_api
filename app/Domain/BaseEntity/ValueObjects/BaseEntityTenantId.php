<?php

namespace App\Domain\BaseEntity\ValueObjects;

class BaseEntityTenantId
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException("BaseEntity tenant id cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
