<?php

namespace App\Domain\PaymentPlan\ValueObjects;

class PaymentPlanGenerateInvoiceManually
{
    private string $value;

    public function __construct(string $value)
    {
        if (!(isset($value) && strlen(trim($value)) > 0)) {
            throw new \InvalidArgumentException("The generate invoice manually field cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
