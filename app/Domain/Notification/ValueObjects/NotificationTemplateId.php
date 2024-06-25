<?php

namespace App\Domain\Notification\ValueObjects;

class NotificationTemplateId
{
    private string $value;
    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException("Notification Template ID cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
