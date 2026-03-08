<?php

namespace App\Domain\Template\ValueObjects;

class TemplateId
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
            throw new \InvalidArgumentException('Template ID cannot be empty');
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
