<?php

namespace App\Domain\TemplateVariable\Repositories;

use App\Domain\TemplateVariable\Entities\TemplateVariable;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableId;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableTemplateId;

interface TemplateVariableRepositoryInterface
{
    public function save(TemplateVariable $task): ?TemplateVariable;
    public function findById(TemplateVariableId $id): ?TemplateVariable;
    public function findByTemplateId(TemplateVariableTemplateId $id): ?array;
}
