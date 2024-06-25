<?php

namespace App\Application\Handlers;

use App\Application\Commands\CreateNotificationCommand;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\Repositories\NotificationRepositoryInterface;
use App\Domain\Notification\ValueObjects\NotificationDocument;
use App\Domain\Notification\ValueObjects\NotificationEmail;
use App\Domain\Notification\ValueObjects\NotificationExtraDocument;
use App\Domain\Notification\ValueObjects\NotificationId;
use App\Domain\Notification\ValueObjects\NotificationName;
use App\Domain\Notification\ValueObjects\NotificationOptionalName;
use App\Domain\Notification\ValueObjects\NotificationSex;

class CreateNotificationHandler
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
        return $this->repository->save($notification);
    }
}
