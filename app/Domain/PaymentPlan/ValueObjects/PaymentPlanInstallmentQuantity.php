<?php

namespace App\Domain\PaymentPlan\ValueObjects;

class PaymentPlanInstallmentQuantity
{
    private int $value;

    public function __construct(int $value)
    {
        if ((int) $value < 0) {
            throw new \InvalidArgumentException("The installment quantity should be a positive number");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
