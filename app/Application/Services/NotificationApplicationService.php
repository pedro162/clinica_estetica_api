<?php

namespace App\Application\Services;

use App\Application\Commands\CreateNotificationCommand;
use App\Application\Commands\CreateNotificationVariableCommand;
use App\Application\Commands\CreateTemplateCommand;
use App\Application\Handlers\CreateNotificationHandler;
use App\Application\Handlers\CreateNotificationVariableHandler;
use App\Domain\Appointment\Entities\Appointment;
use App\Domain\Factories\TemplateFactory;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\Interfaces\NotificationInterface;
use App\Domain\Notification\ValueObjects\NotificationTargetContactAddress;
use App\Domain\Notification\ValueObjects\NotificationTargetContactName;
use App\Domain\NotificationVariable\Repositories\NotificationVariableRepositoryInterface;
use App\Domain\Template\Entities\Template;
use App\Domain\Template\Entities\WhatsAppTemplate;
use App\Domain\Template\Interfaces\TemplateInterface;
use App\Domain\Template\Repositories\TemplateRepositoryInterface;
use App\Domain\Template\ValueObjects\TemplateId;
use App\Domain\Template\ValueObjects\TemplateLanguage;
use App\Domain\Template\ValueObjects\TemplateTitle;
use App\Domain\TemplateVariable\Entities\TemplateVariable;
use App\Domain\TemplateVariable\Repositories\TemplateVariableRepositoryInterface;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableId;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableSyntax;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableTemplateId;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableValue;
use App\Infrastructure\Services\Notifications\NotificationServiceInterface;
use App\Jobs\SendNotification;
use Exception;

class NotificationApplicationService
{
    private NotificationInterface $sender;
    private CreateNotificationHandler $createNotificationHandler;
    private TemplateRepositoryInterface $templateRepository;
    private TemplateVariableRepositoryInterface $templateVariableRepository;
    private NotificationVariableRepositoryInterface $notificationVariableRepository;
    private CreateNotificationVariableHandler $createNotificationVariableHandler;

    public function __construct(CreateNotificationHandler $createNotificationHandler)
    {
        $this->createNotificationHandler = $createNotificationHandler;
    }

    public function createNotificationHandler(CreateNotificationHandler $createNotificationHandler): NotificationApplicationService
    {
        $this->createNotificationHandler = $createNotificationHandler;
        return $this;
    }

    public function templateRepository(TemplateRepositoryInterface $templateRepository): NotificationApplicationService
    {
        $this->templateRepository = $templateRepository;
        return $this;
    }
    public function templateVariableRepository(TemplateVariableRepositoryInterface $templateVariableRepository): NotificationApplicationService
    {
        $this->templateVariableRepository = $templateVariableRepository;
        return $this;
    }
    public function createNotificationVariableHandler(CreateNotificationVariableHandler $createNotificationVariableHandler): NotificationApplicationService
    {
        $this->createNotificationVariableHandler = $createNotificationVariableHandler;
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
        $idTemplateLoad = 1; //Create a system param to use it
        $templateCommandObj = new CreateTemplateCommand();
        $templateCommandObj->templateId($idTemplateLoad);
        $idTemplate = new TemplateId($templateCommandObj->getTemplateId());

        $objTemplate = $this->templateRepository->findById($idTemplate);

        $templateVariables = $this->templateVariableRepository->findByTemplateId(
            new TemplateVariableTemplateId((string)$objTemplate->getId())
        );

        $command = new CreateNotificationCommand();
        $command->notificationId(0)
            ->notificationTitle('Appointment Remainder')
            ->notificationSentDate('2024-06-30')
            ->notificationMessage('Appointment Remainder')
            ->notificationTargetContactName((string)$appointment->getName())
            ->notificationTargetContactAddress('+5598984257623')
            ->notificationOriginContactAddress('+5598984257623')
            ->notificationShippingState('waiting')
            ->notificationTemplateId((string) $objTemplate->getId());
        $newNotification = $this->createNotification($command);
        if (!$newNotification) {
            throw new Exception("Was no possible to create the notification.");
        }
        $variablesOptions = [
            '{{1}}' => (string)$appointment->getName(),
            '{{2}}' => (string)'Studio Beleza',
            '{{3}}' => (string)$appointment->getStartDate(),
            '{{4}}' => (string)$appointment->getStartHour(),
            '{{5}}' => (string)'Skin care',
            '{{6}}' => (string)'Rua das Amoras, Brazil',
            '{{7}}' => (string)"+55(98)984257623",
            '{{8}}' => (string)"http://localhost:3000",
        ];

        if (is_array($templateVariables) && count($templateVariables) > 0) {
            foreach ($templateVariables as $key => $variable) {
                $syntax = (string) $variable->getVariable();
                if (array_key_exists($syntax, $variablesOptions)) {

                    $value = $variablesOptions[$syntax];
                    $command = new CreateNotificationVariableCommand();
                    $command->notificationId((string)$newNotification->getId())
                        ->notificationVariableId(0)
                        ->notificationVariableSyntax($syntax)
                        ->notificationVariableValue($value)
                        ->notificationVariableTemplateId((string)$variable->getId());
                    $newNotificationVariable = $this->createNotificationVariableHandler->handler($command);
                    if (!$newNotificationVariable) {
                        throw new Exception("Was no possible to create the massage variable.");
                    }

                    $newNotification->addVariable($newNotificationVariable);
                }
            }
        }
        return $newNotification;
    }
    public function createAppointmentNotificationBkp(Appointment $appointment)
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
        $templateObj->setTitle(new TemplateTitle('confirm_service'));

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
        $varOj->setVariable(new TemplateVariableSyntax('{{8}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $notification->setTemplate($templateObj);

        $resp = SendNotification::dispatch('1')->onQueue('notifications');
        return false;
        //---return $this->sender->send($notification);
    }

    public function createNotification(
        CreateNotificationCommand $command
    ): ?Notification {
        return $this->createNotificationHandler->handler($command);
    }
}
