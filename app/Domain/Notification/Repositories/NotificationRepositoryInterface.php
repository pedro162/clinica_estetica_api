<?php

namespace App\Domain\Notification\Repositories;

use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\ValueObjects\NotificationId;

interface NotificationRepositoryInterface
{
    public function save(Notification $task): ?Notification;
    public function findById(NotificationId $id): ?Notification;
    public function delete(Notification $task);
}
