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
use App\Domain\Notification\ValueObjects\NotificationShippingState;
use App\Domain\Notification\ValueObjects\NotificationTenantId;
use App\Domain\NotificationVariable\Entities\NotificationVariable;
use App\Domain\Template\Entities\Template;

class Notification
{
    protected NotificationId $id;
    protected NotificationMessage $message;
    protected NotificationTitle $title;
    protected NotificationSentDate $sent_date;
    protected NotificationTargetContactAddress $target_contact_address;
    protected notificationTargetContactName $target_contact_name;
    protected notificationOriginContactAddress $origin_contact_address;
    protected NotificationTemplateId $template_id;
    protected NotificationTenantId $tenant_id;
    protected NotificationShippingState $shipping_state;
    protected Template $template;
    protected array $variables;


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

    public function getOriginContactAddress(): NotificationOriginContactAddress
    {
        return $this->origin_contact_address;
    }

    public function setTemplateId(NotificationTemplateId $template_id): Notification
    {
        $this->template_id = $template_id;
        return $this;
    }

    public function getTemplateId(): NotificationTemplateId
    {
        return $this->template_id;
    }

    public function setShippingState(NotificationShippingState $shipping_state): Notification
    {
        $this->shipping_state = $shipping_state;
        return $this;
    }

    public function getShippingState(): NotificationShippingState
    {
        return $this->shipping_state;
    }

    public function setSentDate(NotificationSentDate $sent_date): Notification
    {
        $this->sent_date = $sent_date;
        return $this;
    }

    public function getSentDate(): NotificationSentDate
    {
        return $this->sent_date;
    }


    public function setTenantId(NotificationTenantId $tenant_id): Notification
    {
        $this->tenant_id = $tenant_id;
        return $this;
    }

    public function getTenantId(): NotificationTenantId
    {
        return $this->tenant_id;
    }

    public function getTemplate(): Template
    {
        return $this->template;
    }

    public function getVariables(): array
    {
        return $this->variables;
    }

    public function addVariable(NotificationVariable $variable)
    {
        $this->variables[] = $variable;
        return $this;
    }
}
