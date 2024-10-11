<?php

namespace App\Domain\Factories;

use App\Application\Commands\CreateTemplateCommand;
use App\Domain\Template\Entities\WhatsAppTemplate;
use App\Domain\Template\Interfaces\TemplateInterface;
use App\Domain\Template\ValueObjects\TemplateBody;
use App\Domain\Template\ValueObjects\TemplateId;
use App\Domain\Template\ValueObjects\TemplateTitle;

class TemplateFactory
{
    const WHATS_APP_TEMPLATE = 'whatsapp';

    public static function create($tipo, CreateTemplateCommand $command): TemplateInterface
    {
        switch ($tipo) {
            case self::WHATS_APP_TEMPLATE:
                $objTemplate = new WhatsAppTemplate();
                $objTemplate->setId(new TemplateId($command->getTemplateId()));
                $objTemplate->setBody(new TemplateBody($command->getTemplateBody()));
                $objTemplate->setTitle(new TemplateTitle($command->getTemplateTitle()));

                return $objTemplate;
            default:
                throw new \Exception("Template type not available.");
        }
    }
}
