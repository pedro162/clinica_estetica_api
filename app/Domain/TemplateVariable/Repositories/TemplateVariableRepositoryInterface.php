<?php

namespace App\Domain\TemplateVariable\Repositories;

use App\Domain\TemplateVariable\Entities\TemplateVariable;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableId;

interface TemplateVariableRepositoryInterface
{
    public function save(TemplateVariable $task): ?TemplateVariable;
    public function findById(TemplateVariableId $id): ?TemplateVariable;
}
