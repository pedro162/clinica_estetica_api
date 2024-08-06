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

class FindNotificationByIdHandler
{
    private NotificationRepositoryInterface $repository;

    public function __construct(NotificationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateNotificationCommand $command): ?Notification
    {
        return $this->repository->findById(new NotificationId($command->getNotificationId()));
    }
}
