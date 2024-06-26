<?php

namespace App\Domain\Template\Entities;

use App\Domain\Template\Interfaces\TemplateInterface;
use App\Domain\Template\Entities\Template;

class WhatsAppTemplate extends Template implements TemplateInterface
{
    public function getVariables(): array
    {
        return $this->getVariables();
    }
    public function getName(): string
    {
        return (string) $this->getTitle();
    }
    public function getLanguage()
    {
        return ''; //TODO
    }

    public function getBodyFill(): string
    {
        return $data = '';
    }
}
