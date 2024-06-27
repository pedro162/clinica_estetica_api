<?php

namespace App\Domain\Notification\Entities;

use App\Domain\Notification\ValueObjects\NotificationId;
use App\Domain\Notification\ValueObjects\NotificationMessage;
use App\Domain\Notification\ValueObjects\NotificationTitle;
use App\Domain\Notification\ValueObjects\NotificationOriginContactAddress;
use App\Domain\Notification\ValueObjects\NotificationTargetContactAddress;
use App\Domain\Notification\ValueObjects\NotificationTargetContactName;
use App\Domain\Notification\ValueObjects\NotificationTemplateId;
use App\Domain\Notification\ValueObjects\NotificationSentDate;
use App\Domain\Template\Entities\Template;

class Notification
{

    /* 
notificationTemplateId
notificationTitle
notificationMessage
notificationSentDate
notificationTargetContactAddress
notificationTargetContactName
notificationOriginContactAddress */

    protected NotificationId $id;
    protected NotificationMessage $message;
    protected NotificationTitle $title;
    protected NotificationTitle $set_date;
    protected NotificationTargetContactAddress $target_contact_address;
    protected notificationTargetContactName $target_contact_name;
    protected notificationOriginContactAddress $origin_contact_address;
    protected Template $template;

    public function setId(NotificationId $id): Notification
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): NotificationId
    {
        return $this->id;
    }

    public function setTitle(NotificationTitle $title): Notification
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): NotificationTitle
    {
        return $this->title;
    }

    public function setMessage(NotificationMessage $message): Notification
    {
        $this->message = $message;
        return $this;
    }

    public function setTemplate(Template $template): Notification
    {
        $this->template = $template;
        return $this;
    }

    public function getMessage(): NotificationMessage
    {
        return $this->message;
    }

    public function setTargetContactAddress(NotificationTargetContactAddress $target_contact_address): Notification
    {
        $this->target_contact_address = $target_contact_address;
        return $this;
    }

    public function getTargetContactAddress(): NotificationTargetContactAddress
    {
        return $this->target_contact_address;
    }

    public function setTargetContactName(NotificationTargetContactName $target_contact_name): Notification
    {
        $this->target_contact_name = $target_contact_name;
        return $this;
    }

    public function getTargetContactName(): NotificationTargetContactName
    {
        return $this->target_contact_name;
    }
    public function setOriginContactAddress(notificationOriginContactAddress $origin_contact_address): Notification
    {
        $this->origin_contact_address = $origin_contact_address;
        return $this;
    }

    public function getOriginContactAddress(): notificationOriginContactAddress
    {
        return $this->origin_contact_address;
    }

    public function getTemplate(): Template
    {
        return $this->template;
    }
}
