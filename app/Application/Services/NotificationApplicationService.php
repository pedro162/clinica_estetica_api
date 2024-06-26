<?php

namespace App\Application\Services;

use App\Application\Commands\CreateNotificationCommand;
use App\Application\Commands\CreateTemplateCommand;
use App\Application\Handlers\CreateNotificationHandler;
use App\Domain\Factories\TemplateFactory;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\Interfaces\NotificationInterface;
use App\Domain\Template\Entities\Template;
use App\Domain\Template\Interfaces\TemplateInterface;
use App\Domain\Template\Repositories\TemplateRepositoryInterface;
use App\Domain\Template\ValueObjects\TemplateId;
use App\Infrastructure\Services\Notifications\NotificationServiceInterface;

class NotificationApplicationService
{
    private NotificationInterface $sender;
    private CreateNotificationHandler $createNotificationHandler;
    private TemplateRepositoryInterface $templateRepository;

    public function __construct(CreateNotificationHandler $createNotificationHandler)
    {
        $this->createNotificationHandler = $createNotificationHandler;
    }

    public function createNotificationHandler(CreateNotificationHandler $createNotificationHandler): NotificationApplicationService
    {
        $this->createNotificationHandler = $createNotificationHandler;
        return $this;
    }

    public function sender(NotificationInterface $sender): NotificationApplicationService
    {
        $this->sender = $sender;
        return $this;
    }

    public function sendNotification(Notification $notification): bool
    {
        //---template
        //--- Alimentar variaveis template
        return $this->sender->send($notification);
    }

    public function sendServiceNotification(Notification $notification, TemplateInterface $service)
    {
        //---Alimentar variaveis
        $idTemplateLoad = 1;
        $templateCommandObj = new CreateTemplateCommand();
        $templateCommandObj->templateId($idTemplateLoad);
        $idTemplate = new TemplateId($templateCommandObj->getTemplateId());

        $templateObj = $this->templateRepository->findById($idTemplate);
        $whatsappTemplate = TemplateFactory::create(TemplateFactory::WHATS_APP_TEMPLATE, $templateCommandObj);
        //--fill in whatsapp template
        //$whatsappTemplate->setVariable($ervice->name);
        //$whatsappTemplate->setVariable($ervice->company);

        $notification->setTemplate($whatsappTemplate);

        return $this->sender->send($notification);
    }

    public function createNotification(
        string $notificationId = ''
    ): ?Notification {

        $command = new CreateNotificationCommand();

        $command->notificationId($notificationId);

        return $this->createNotificationHandler->handler($command);
    }
}
