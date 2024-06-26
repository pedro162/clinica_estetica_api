<?php

namespace App\Domain\TemplateVariable\Entities;

use App\Domain\TemplateVariable\Interfaces\TemplateVariableInterface;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableId;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableSyntax;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableValue;

class TemplateVariable
{
    protected TemplateVariableId $id;
    protected TemplateVariableSyntax $variable;
    protected TemplateVariableValue $value;
    protected array $variables;

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
}
