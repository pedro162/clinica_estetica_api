<?php

namespace App\Domain\Template\Interfaces;

use App\Domain\Template\ValueObjects\TemplateLanguage;

interface TemplateInterface
{
    public function getVariablesTemplate(): array;
    public function getName();
    public function getLanguageTemplate(): TemplateLanguage;
    public function getBody();
    public function getBodyFill();
}
