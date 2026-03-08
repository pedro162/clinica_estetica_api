<?php

namespace App\Domain\Person\ValueObjects;

use DateTimeImmutable;

class PersonBirthOrFoundation
{
    private DateTimeImmutable $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException('Birth/foundation field cannot be empty');
        }

        $this->value = new DateTimeImmutable($value);
    }

    public function __toString()
    {
        return $this->value->format('Y-m-d');
    }
}
