<?php

namespace App\Domain\Notification\Interfaces;

use App\Domain\Notification\Entities\Notification;

interface NotificationInterface
{
    public function send(Notification $notification): bool;
}
