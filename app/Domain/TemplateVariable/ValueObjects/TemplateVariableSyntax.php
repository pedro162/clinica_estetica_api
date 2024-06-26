<?php

namespace App\Domain\TemplateVariable\ValueObjects;

class TemplateVariableSyntax
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException("TemplateVariable body cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
