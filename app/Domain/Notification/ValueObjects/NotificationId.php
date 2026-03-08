<?php

namespace App\Domain\Notification\ValueObjects;

class NotificationId
{
    private string $value;
    /*
notificationTemplateId
notificationTitle
notificationMessage
notificationSentDate
notificationTargetContactAddress
notificationTargetContactName
notificationOriginContactAddress */
    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException('Notification ID cannot be empty');
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
