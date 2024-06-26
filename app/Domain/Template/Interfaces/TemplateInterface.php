<?php

namespace App\Domain\Template\Interfaces;

use App\Application\Handlers\HttpRequestResponseHandler;
use App\Domain\Template\Entities\Template;

interface TemplateInterface
{
    public function getVariables(): array;
    public function getName();
    public function getLanguage();
    public function getBody();
    public function getBodyFill();
}
