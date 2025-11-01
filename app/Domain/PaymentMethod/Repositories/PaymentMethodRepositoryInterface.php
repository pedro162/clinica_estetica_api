<?php

namespace App\Domain\PaymentMethod\Repositories;

use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorId;
use App\FormaPagamento;
use App\Domain\PaymentMethod\Entities\PaymentMethod;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodId;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanId;

/**
 * Interface for Payment Method Repository
 */
interface PaymentMethodRepositoryInterface
{
    /**
     * Save a new payment method
     *
     * @param PaymentMethod $task
     * @return FormaPagamento|null
     */
    public function save(PaymentMethod $task): ?FormaPagamento;

    /**
     * Find a payment method by its ID
     *
     * @param PaymentMethodId $id
     * @return FormaPagamento|null
     */
    public function findById(PaymentMethodId $id): ?FormaPagamento;

    /**
     * Get all payment methods with optional filtering
     *
     * @param array $filter
     * @return array|null
     */
    public function getAll(array $filter = []): ?array;

    /**
     * Update a payment method
     *
     * @param PaymentMethod $parameter
     * @return void
     */
    public function update(PaymentMethod $parameter): void;

    /**
     * Remove a payment method
     *
     * @param PaymentMethod $parameter
     * @return void
     */
    public function destroy(PaymentMethod $parameter): void;

    /**
     * Add financial operators to a payment method
     *
     * @param PaymentMethod $parameter
     * @param array $data
     * @return void
     */
    public function addFinancialOperator(PaymentMethod $parameter, array $data = []): void;

    /**
     * Remove financial operators from a payment method
     *
     * @param PaymentMethod $parameter
     * @param array $data
     * @return void
     */
    public function removeFinancialOperator(PaymentMethod $parameter, array $data = []): void;

    /**
     * Sinc financial operators of a payment method
     *
     * @param PaymentMethod $parameter
     * @param array $data
     * @return void
     */
    public function syncFinancialOperator(PaymentMethod $parameter, array $data = []): void;

    /**
     * Add payment plans to a payment method
     *
     * @param PaymentMethod $parameter
     * @param array $data
     * @return void
     */
    public function addPaymentPlan(PaymentMethod $parameter, array $data = []): void;

    /**
     * Remove payment plans from a payment method
     *
     * @param PaymentMethod $parameter
     * @param array $data
     * @return void
     */
    public function removePaymentPlan(PaymentMethod $parameter, array $data = []): void;

    /**
     * Sync payment plans of a payment method
     *
     * @param PaymentMethod $parameter
     * @param array $data
     * @return void
     */
    public function syncPaymentPlan(PaymentMethod $parameter, array $data = []): void;
}
