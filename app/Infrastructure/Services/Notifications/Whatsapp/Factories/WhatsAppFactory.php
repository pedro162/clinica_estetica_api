<?php

namespace App\Infrastructure\Services\Notifications\Whatsapp\Factories;

use App\Domain\Notification\Interfaces\NotificationInterface;
use App\Infrastructure\Services\Notifications\Whatsapp\WhatsAppInterface;
use App\Infrastructure\Services\Notifications\Whatsapp\WhatsAppOfficialApi;

class WhatsAppFactory
{
    const OFFICAIAL_WHATSAPP_API = 'whatsapp';
    public static function create($tipo): NotificationInterface
    {
        switch ($tipo) {
            case self::OFFICAIAL_WHATSAPP_API:
                return new WhatsAppOfficialApi();
            default:
                throw new \Exception("WhatsApp API not available.");
        }
    }
}
