<?php

namespace App\Application\Services;

use App\Domain\Notification\Entities\Notification;
use App\Domain\Interfaces\NotificationSenderInterface;

class NotificationService
{
    private array $senders;

    public function __construct(array $senders)
    {
        $this->senders = $senders;
    }

    public function sendNotification(Notification $notification, string $platform): bool
    {
        if (!isset($this->senders[$platform])) {
            throw new \Exception("Notification sender for platform {$platform} not found.");
        }

        //getRequest
        //getResponse

        return $this->senders[$platform]->send(notification: $notification);
    }
}
