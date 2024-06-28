<?php

namespace App\Domain\NotificationVariable\Entities;

use App\Domain\NotificationVariable\Interfaces\NotificationVariableInterface;
use App\Domain\NotificationVariable\ValueObjects\NotificationId;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableId;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableSyntax;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableNotificationId;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableTemplateVariableId;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableValue;

class NotificationVariable
{
    protected NotificationVariableId $id;
    protected NotificationVariableSyntax $variable;
    protected NotificationVariableValue $value;
    protected NotificationVariableTemplateVariableId $template_id;
    protected NotificationId $notification_id;

    public function setId(NotificationVariableId $id): NotificationVariable
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): NotificationVariableId
    {
        return $this->id;
    }

    public function setValue(NotificationVariableValue $value): NotificationVariable
    {
        $this->value = $value;
        return $this;
    }

    public function getValue(): NotificationVariableValue
    {
        return $this->value;
    }

    public function setVariable(NotificationVariableSyntax $variable): NotificationVariable
    {
        $this->variable = $variable;
        return $this;
    }

    public function getVariable(): NotificationVariableSyntax
    {
        return $this->variable;
    }

    public function setTemplateId(NotificationVariableTemplateVariableId $template_id): NotificationVariable
    {
        $this->template_id = $template_id;
        return $this;
    }

    public function getTemplateId(): NotificationVariableTemplateVariableId
    {
        return $this->template_id;
    }

    public function setNotificationId(NotificationId $notification_id): NotificationVariable
    {
        $this->notification_id = $notification_id;
        return $this;
    }

    public function getNotificationId(): NotificationId
    {
        return $this->notification_id;
    }
}
