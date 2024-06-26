<?php

namespace App\Domain\Template\Entities;

use App\Domain\Template\Interfaces\TemplateInterface;
use App\Domain\Template\ValueObjects\TemplateId;
use App\Domain\Template\ValueObjects\TemplateBody;
use App\Domain\Template\ValueObjects\TemplateTitle;
use App\Domain\TemplateVariable\Entities\TemplateVariable;

class Template
{
    protected TemplateId $id;
    protected TemplateBody $body;
    protected TemplateTitle $title;
    protected array $variables;

    public function setId(TemplateId $id): Template
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): TemplateId
    {
        return $this->id;
    }

    public function setTitle(TemplateTitle $title): Template
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): TemplateTitle
    {
        return $this->title;
    }

    public function setBody(TemplateBody $body): Template
    {
        $this->body = $body;
        return $this;
    }

    public function getBody(): TemplateBody
    {
        return $this->body;
    }

    public function getVariables(): array
    {
        return $this->variables;
    }

    public function addVariable(TemplateVariable $variable)
    {
        $this->variables[] = $variable;
        return $this;
    }

    public function getLanguage()
    {
        return ''; //TODO
    }
}
