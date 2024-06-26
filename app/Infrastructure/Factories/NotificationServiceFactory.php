<?php

namespace App\Infrastructure\Factories;

use App\Domain\Notification\Interfaces\NotificationInterface;
use App\Infrastructure\Services\Notifications\Whatsapp\Factories\WhatsAppFactory;
use App\Infrastructure\Services\Notifications\Whatsapp\WhatsAppOfficialApi;

class NotificationServiceFactory
{
    public static function create($tipo): NotificationInterface
    {
        switch ($tipo) {
            case 'whatsapp':
                return WhatsAppFactory::create(WhatsAppFactory::OFFICAIAL_WHATSAPP_API);
            case 'sms':
                return null;
            default:
                throw new \Exception("Tipo de notificação não suportado.");
        }
    }
}
