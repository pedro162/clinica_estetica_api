<?php

namespace App\Application\Services;

use App\Application\Commands\CreateTemplateCommand;
use App\Application\Handlers\CreateTemplateHandler;
use App\Domain\Template\Entities\Template;

class TemplateApplicationService
{
    private CreateTemplateHandler $createTemplateHandler;

    public function __construct(CreateTemplateHandler $createTemplateHandler)
    {
        $this->createTemplateHandler = $createTemplateHandler;
    }

    public function createTemplate(
        string $templateId = '',
        string $templateTitle = '',
        string $templateBody = '',
    ): ?Template {

        $command = new CreateTemplateCommand();

        $command->templateId($templateId)
            ->templateTitle($templateTitle)
            ->templateBody($templateBody);

        return $this->createTemplateHandler->handler($command);
    }
}
