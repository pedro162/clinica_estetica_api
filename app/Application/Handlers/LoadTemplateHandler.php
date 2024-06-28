<?php

namespace App\Application\Handlers;

use App\Application\Commands\CreateTemplateCommand;
use App\Domain\Template\Entities\Template;
use App\Domain\Template\Repositories\TemplateRepositoryInterface;;

use App\Domain\Template\ValueObjects\TemplateId;
use App\Domain\Template\ValueObjects\TemplateBody;
use App\Domain\Template\ValueObjects\TemplateTitle;

class LoadTemplateHandler
{
    private TemplateRepositoryInterface $repository;

    public function __construct(TemplateRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateTemplateCommand $command): ?Template
    {
        $template = new Template();
        return $this->repository->findById(new TemplateId($command->getTemplateId()));
    }
}
