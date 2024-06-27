<?php

namespace App\Domain\Template\ValueObjects;

class TemplateLanguage
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException("Template language cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
