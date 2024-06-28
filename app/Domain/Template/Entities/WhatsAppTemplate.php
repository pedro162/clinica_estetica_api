<?php

namespace App\Domain\Template\Entities;

use App\Domain\Template\Interfaces\TemplateInterface;
use App\Domain\Template\Entities\Template;
use App\Domain\Template\ValueObjects\TemplateLanguage;

class WhatsAppTemplate extends Template implements TemplateInterface
{
    public function getVariablesTemplate(): array
    {
        return $this->getVariables();
    }
    public function getName(): string
    {
        return (string) $this->getTitle();
    }
    public function getLanguageTemplate(): TemplateLanguage
    {
        return $this->language; //TODO
    }

    public function getBodyFill(): string
    {
        return $data = '';
    }
}
