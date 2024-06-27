<?php

namespace App\Application\Services;

use App\Application\Commands\CreateNotificationCommand;
use App\Application\Commands\CreateTemplateCommand;
use App\Application\Handlers\CreateNotificationHandler;
use App\Domain\Appointment\Entities\Appointment;
use App\Domain\Factories\TemplateFactory;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\Interfaces\NotificationInterface;
use App\Domain\Notification\ValueObjects\NotificationTargetContactAddress;
use App\Domain\Notification\ValueObjects\NotificationTargetContactName;
use App\Domain\Template\Entities\Template;
use App\Domain\Template\Entities\WhatsAppTemplate;
use App\Domain\Template\Interfaces\TemplateInterface;
use App\Domain\Template\Repositories\TemplateRepositoryInterface;
use App\Domain\Template\ValueObjects\TemplateId;
use App\Domain\Template\ValueObjects\TemplateLanguage;
use App\Domain\TemplateVariable\Entities\TemplateVariable;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableId;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableSyntax;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableValue;
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

    public function sendNotificationOfId(string $notification_id): bool
    {
        //---template
        //--- Alimentar variaveis template

        //return $this->sender->send($notification);
        return true;
    }

    public function createAppointmentNotification(Appointment $appointment)
    {
        //---Alimentar variaveis
        $idTemplateLoad = 1;
        $templateCommandObj = new CreateTemplateCommand();
        $templateCommandObj->templateId($idTemplateLoad);
        $idTemplate = new TemplateId($templateCommandObj->getTemplateId());

        $notification = new Notification();
        $notification->setTargetContactAddress(new NotificationTargetContactAddress('5598984257623'));
        $notification->setTargetContactName(new NotificationTargetContactName((string) $appointment->getName()));

        //$templateObj = $this->templateRepository->findById($idTemplate);
        $templateObj = new WhatsAppTemplate();
        $templateObj->setLanguage(new TemplateLanguage('en_US'));

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string)$appointment->getName()));
        $varOj->setVariable(new TemplateVariableSyntax('{{1}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);


        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string)'Studio Beleza'));
        $varOj->setVariable(new TemplateVariableSyntax('{{2}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string) $appointment->getStartDate()));
        $varOj->setVariable(new TemplateVariableSyntax('{{3}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string) $appointment->getStartHour()));
        $varOj->setVariable(new TemplateVariableSyntax('{{4}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string) "Skin care"));
        $varOj->setVariable(new TemplateVariableSyntax('{{5}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string) "Rua das Amoras, Brazil"));
        $varOj->setVariable(new TemplateVariableSyntax('{{6}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string) "+55(98)984257623"));
        $varOj->setVariable(new TemplateVariableSyntax('{{7}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string) "http://localhost:3000"));
        $varOj->setVariable(new TemplateVariableSyntax('{{7}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $notification->setTemplate($templateObj);

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
