<?php

namespace App\Domain\Service\ValueObjects;

class ServiceType
{
    private string $value;

    public function __construct(string $value)
    {
        if (!empty($value)) {
            if (!in_array($value, ['mensalidade', 'outros'])) {
                throw new \InvalidArgumentException('The service type is invalid. It should be either (mensalidade, outros)');
            }
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
