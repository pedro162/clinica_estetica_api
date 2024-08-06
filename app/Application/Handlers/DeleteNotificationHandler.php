<?php

namespace App\Application\Handlers;

use App\Application\Commands\CreateNotificationCommand;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\Repositories\NotificationRepositoryInterface;
use App\Domain\Notification\ValueObjects\NotificationId;
use App\Domain\Notification\ValueObjects\NotificationMessage;
use App\Domain\Notification\ValueObjects\NotificationOriginContactAddress;
use App\Domain\Notification\ValueObjects\NotificationSentDate;
use App\Domain\Notification\ValueObjects\NotificationShippingState;
use App\Domain\Notification\ValueObjects\NotificationTargetContactAddress;
use App\Domain\Notification\ValueObjects\NotificationTargetContactName;
use App\Domain\Notification\ValueObjects\NotificationTemplateId;
use App\Domain\Notification\ValueObjects\NotificationTenantId;
use App\Domain\Notification\ValueObjects\NotificationTitle;

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
