<?php

namespace App\Application\Handlers;

use App\Application\Commands\CreateNotificationCommand;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\Repositories\NotificationRepositoryInterface;
use App\Domain\Notification\ValueObjects\NotificationDocument;
use App\Domain\Notification\ValueObjects\NotificationEmail;
use App\Domain\Notification\ValueObjects\NotificationExtraDocument;
use App\Domain\Notification\ValueObjects\NotificationId;
use App\Domain\Notification\ValueObjects\NotificationMessage;
use App\Domain\Notification\ValueObjects\NotificationName;
use App\Domain\Notification\ValueObjects\NotificationOptionalName;
use App\Domain\Notification\ValueObjects\NotificationOriginContactAddress;
use App\Domain\Notification\ValueObjects\NotificationSentDate;
use App\Domain\Notification\ValueObjects\NotificationSex;
use App\Domain\Notification\ValueObjects\NotificationShippingState;
use App\Domain\Notification\ValueObjects\NotificationTargetContactAddress;
use App\Domain\Notification\ValueObjects\NotificationTargetContactName;
use App\Domain\Notification\ValueObjects\NotificationTemplateId;
use App\Domain\Notification\ValueObjects\NotificationTenantId;
use App\Domain\Notification\ValueObjects\NotificationTitle;

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
        $notification->setId(new NotificationId($command->getNotificationId()))
            ->setTitle(new NotificationTitle($command->getNotificationTitle()))
            ->setMessage(new NotificationMessage($command->getNotificationMessage()))
            ->setTemplateId(new NotificationTemplateId($command->getNotificationTemplateId()))
            ->setTargetContactAddress(new NotificationTargetContactAddress($command->getNotificationTargetContactAddress()))
            ->setTargetContactName(new NotificationTargetContactName($command->getNotificationTargetContactName()))
            ->setOriginContactAddress(new NotificationOriginContactAddress($command->getNotificationOriginContactAddress()))
            ->setShippingState(new NotificationShippingState($command->getNotificationShippingState()))
            ->setSentDate(new NotificationSentDate($command->getNotificationSentDate()));
        return $this->repository->save($notification);
    }
}
