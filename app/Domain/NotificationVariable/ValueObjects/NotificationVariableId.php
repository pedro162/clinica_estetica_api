<?php

namespace App\Domain\NotificationVariable\ValueObjects;

class NotificationVariableId
{
    private string $value;
    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException('Notification Variable ID cannot be empty');
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
