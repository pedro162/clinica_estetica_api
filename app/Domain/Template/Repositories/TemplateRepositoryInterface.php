<?php

namespace App\Domain\Template\Repositories;

use App\Domain\Template\Entities\Template;
use App\Domain\Template\ValueObjects\TemplateId;

interface TemplateRepositoryInterface
{
    public function save(Template $task): ?Template;
    public function findById(TemplateId $id): ?Template;
}
