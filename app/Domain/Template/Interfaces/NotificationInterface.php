<?php

namespace App\Domain\Notification\Interfaces;

use App\Application\Handlers\HttpRequestResponseHandler;
use App\Domain\Notification\Entities\Notification;

interface NotificationInterface
{
    public function send(Notification $notification): bool;
}
