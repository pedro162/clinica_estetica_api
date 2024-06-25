<?php

namespace App\Application\Services;

use App\Application\Commands\CreateNotificationCommand;
use App\Application\Handlers\CreateNotificationHandler;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\Interfaces\NotificationInterface;
use App\Infrastructure\Services\Notifications\NotificationServiceInterface;

class NotificationApplicationService
{
    private NotificationInterface $sender;
    private CreateNotificationHandler $createNotificationHandler;

    public function __construct(CreateNotificationHandler $createNotificationHandler)
    {
        $this->createNotificationHandler = $createNotificationHandler;
    }

    public function createNotificationHandler(CreateNotificationHandler $createNotificationHandler): NotificationApplicationService
    {
        $this->createNotificationHandler = $createNotificationHandler;
        return $this;
    }

    public function sender(NotificationInterface $sender): NotificationApplicationService
    {
        $this->sender = $sender;
        return $this;
    }

    public function sendNotification(Notification $notification): bool
    {
        return $this->sender->send($notification);
    }

    public function createNotification(
        string $notificationId = ''
    ): ?Notification {

        $command = new CreateNotificationCommand();

        $command->notificationId($notificationId);

        return $this->createNotificationHandler->handler($command);
    }
}
