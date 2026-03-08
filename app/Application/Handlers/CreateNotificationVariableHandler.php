<?php

namespace App\Application\Handlers;

use App\Application\Commands\CreateNotificationVariableCommand;
use App\Domain\NotificationVariable\Entities\NotificationVariable;
use App\Domain\NotificationVariable\Repositories\NotificationVariableRepositoryInterface;
use App\Domain\NotificationVariable\ValueObjects\NotificationId;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableId;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableSyntax;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableTemplateVariableId;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableValue;

class CreateNotificationVariableHandler
{
    private NotificationVariableRepositoryInterface $repository;

    public function __construct(NotificationVariableRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateNotificationVariableCommand $command): ?NotificationVariable
    {
        $template = new NotificationVariable();
        $template->setId(new NotificationVariableId($command->getNotificationVariableId()));
        $template->setVariable(new NotificationVariableSyntax($command->getNotificationVariableSyntax()));
        $template->setValue(new NotificationVariableValue($command->getNotificationVariableValue()));
        $template->setNotificationId(new NotificationId($command->getNotificationId()));
        $template->setTemplateId(new NotificationVariableTemplateVariableId($command->getNotificationVariableTemplateId()));

        return $this->repository->save($template);
    }
}
