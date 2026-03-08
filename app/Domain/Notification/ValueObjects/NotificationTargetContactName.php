<?php

namespace App\Domain\Notification\ValueObjects;

class NotificationTargetContactName
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException('Notification Target Contact Name cannot be empty');
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
