<?php

namespace App\Application\Commands;

class CreateTemplateCommand
{
    protected string $templateId;
    protected string $templateTitle;
    protected string $templateBody;

    public function templateId(string $templateId): CreateTemplateCommand
    {
        $this->templateId = $templateId;
        return $this;
    }

    public function templateTitle(string $templateTitle): CreateTemplateCommand
    {
        $this->templateTitle = $templateTitle;
        return $this;
    }

    public function templateBody(string $templateBody): CreateTemplateCommand
    {
        $this->templateBody = $templateBody;
        return $this;
    }

    public function getTemplateId(): ?string
    {
        return $this->templateId;
    }

    public function getTemplateTitle(): ?string
    {
        return $this->templateTitle;
    }
    public function getTemplateBody(): ?string
    {
        return $this->templateBody;
    }
}
