<?php

namespace App\Application\Commands;

class CreateNotificationCommand
{

    protected string $notificationId;
    protected string $notificationTemplateId;
    protected string $notificationTitle;
    protected string $notificationMessage;
    protected string $notificationSentDate;
    protected string $notificationTargetContactAddress;
    protected string $notificationTargetContactName;
    protected string $notificationShippingState;
    protected string $notificationOriginContactAddress;
    /**'title',
    'message',
    'origin_contact_address',
    'target_contact_address',
    'target_contact_name',
    'template_id',
    'shipping_state',
    'sent_date',
    'user_id',
    'user_update_id',
    'active', */

    public function notificationId(string $notificationId): CreateNotificationCommand
    {
        $this->notificationId = $notificationId;
        return $this;
    }

    public function notificationTitle(string $notificationTitle): CreateNotificationCommand
    {
        $this->notificationTitle = $notificationTitle;
        return $this;
    }

    public function notificationSentDate(string $notificationSentDate): CreateNotificationCommand
    {
        $this->notificationSentDate = $notificationSentDate;
        return $this;
    }

    public function notificationMessage(string $notificationMessage): CreateNotificationCommand
    {
        $this->notificationMessage = $notificationMessage;
        return $this;
    }

    public function notificationTargetContactAddress(string $notificationTargetContactAddress): CreateNotificationCommand
    {
        $this->notificationTargetContactAddress = $notificationTargetContactAddress;
        return $this;
    }

    public function notificationOriginContactAddress(string $notificationOriginContactAddress): CreateNotificationCommand
    {
        $this->notificationOriginContactAddress = $notificationOriginContactAddress;
        return $this;
    }

    public function notificationTemplateId(string $notificationTemplateId): CreateNotificationCommand
    {
        $this->notificationTemplateId = $notificationTemplateId;
        return $this;
    }

    public function notificationShippingState(string $notificationShippingState): CreateNotificationCommand
    {
        $this->notificationShippingState = $notificationShippingState;
        return $this;
    }

    public function notificationTargetContactName(string $notificationTargetContactName): CreateNotificationCommand
    {
        $this->notificationTargetContactName = $notificationTargetContactName;
        return $this;
    }

    public function getNotificationId(): ?string
    {
        return $this->notificationId;
    }

    public function getNotificationTitle(): ?string
    {
        return $this->notificationTitle;
    }
    public function getNotificationMessage(): ?string
    {
        return $this->notificationMessage;
    }

    public function getNotificationSentDate(): ?string
    {
        return $this->notificationSentDate;
    }

    public function getNotificationTargetContactAddress(): ?string
    {
        return $this->notificationTargetContactAddress;
    }

    public function getNotificationTargetContactName(): ?string
    {
        return $this->notificationTargetContactName;
    }

    public function getNotificationOriginContactAddress(): ?string
    {
        return $this->notificationOriginContactAddress;
    }

    public function getNotificationTemplateId(): ?string
    {
        return $this->notificationTemplateId;
    }

    public function getNotificationShippingState(): ?string
    {
        return $this->notificationShippingState;
    }
}
