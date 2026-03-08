<?php

namespace App\Application\Commands;

class CreateNotificationVariableCommand
{
    protected string $notificationVariableId;
    protected string $notificationVariableSyntax;
    protected string $notificationVariableValue;
    protected string $notificationId;
    protected string $notificationVariableTemplateId;

    public function notificationVariableId(string $notificationVariableId): CreateNotificationVariableCommand
    {
        $this->notificationVariableId = $notificationVariableId;
        return $this;
    }

    public function notificationVariableSyntax(string $notificationVariableSyntax): CreateNotificationVariableCommand
    {
        $this->notificationVariableSyntax = $notificationVariableSyntax;
        return $this;
    }

    public function notificationVariableValue(string $notificationVariableValue): CreateNotificationVariableCommand
    {
        $this->notificationVariableValue = $notificationVariableValue;
        return $this;
    }

    public function notificationId(string $notificationId): CreateNotificationVariableCommand
    {
        $this->notificationId = $notificationId;
        return $this;
    }

    public function notificationVariableTemplateId(string $notificationVariableTemplateId): CreateNotificationVariableCommand
    {
        $this->notificationVariableTemplateId = $notificationVariableTemplateId;
        return $this;
    }

    public function getNotificationVariableId(): ?string
    {
        return $this->notificationVariableId;
    }

    public function getNotificationVariableSyntax(): ?string
    {
        return $this->notificationVariableSyntax;
    }

    public function getNotificationVariableValue(): ?string
    {
        return $this->notificationVariableValue;
    }

    public function getNotificationId(): ?string
    {
        return $this->notificationId;
    }

    public function getNotificationVariableTemplateId(): ?string
    {
        return $this->notificationVariableTemplateId;
    }
}
