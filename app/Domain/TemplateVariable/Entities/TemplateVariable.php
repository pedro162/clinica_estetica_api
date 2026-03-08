<?php

namespace App\Domain\TemplateVariable\Entities;

use App\Domain\TemplateVariable\ValueObjects\TemplateVariableId;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableSyntax;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableTemplateId;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableValue;

class TemplateVariable
{
    protected TemplateVariableId $id;
    protected TemplateVariableSyntax $variable;
    protected TemplateVariableValue $value;
    protected TemplateVariableTemplateId $template_id;

    public function setId(TemplateVariableId $id): TemplateVariable
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): TemplateVariableId
    {
        return $this->id;
    }

    public function setValue(TemplateVariableValue $value): TemplateVariable
    {
        $this->value = $value;
        return $this;
    }

    public function getValue(): TemplateVariableValue
    {
        return $this->value;
    }

    public function setVariable(TemplateVariableSyntax $variable): TemplateVariable
    {
        $this->variable = $variable;
        return $this;
    }

    public function getVariable(): TemplateVariableSyntax
    {
        return $this->variable;
    }

    public function setTemplateId(TemplateVariableTemplateId $template_id): TemplateVariable
    {
        $this->template_id = $template_id;
        return $this;
    }

    public function getTemplateId(): TemplateVariableTemplateId
    {
        return $this->template_id;
    }
}
