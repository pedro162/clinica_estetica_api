<?php

namespace App\Domain\NotificationVariable\Repositories;

use App\Domain\NotificationVariable\Entities\NotificationVariable;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableId;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableTemplateVariableId;

interface NotificationVariableRepositoryInterface
{
    public function save(NotificationVariable $task): ?NotificationVariable;
    public function findById(NotificationVariableId $id): ?NotificationVariable;
    public function findByTemplateId(NotificationVariableTemplateVariableId $id): ?array;
}
