<?php

namespace App\Application\Handlers;

use App\Application\Commands\CreateNotificationCommand;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\Repositories\NotificationRepositoryInterface;
use App\Domain\Notification\ValueObjects\NotificationId;

class DeleteNotificationHandler
{
    private NotificationRepositoryInterface $repository;

    public function __construct(NotificationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateNotificationCommand $command): ?Notification
    {
        $notification = new Notification();
        $notification->setId(new NotificationId($command->getNotificationId()));
        return $this->repository->delete($notification);
    }
}
