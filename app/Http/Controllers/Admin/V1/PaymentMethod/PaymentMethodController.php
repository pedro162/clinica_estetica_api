<?php

namespace App\Http\Controllers\Admin\V1\PaymentMethod;

use App\Application\Commands\PaymentMethod\CreatePaymentMethodCommand;
use App\Application\Services\PaymentMethod\PaymentMethodApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PaymentMethod\DestroyPaymentMethodRequest;
use App\Http\Requests\V1\PaymentMethod\GetAllPaymentMethodRequest;
use App\Http\Requests\V1\PaymentMethod\ShowPaymentMethodRequest;
use App\Http\Requests\V1\PaymentMethod\StorePaymentMethodRequest;
use App\Http\Requests\V1\PaymentMethod\UpdatePaymentMethodRequest;
use App\Http\Resources\V1\PaymentMethod\GetAllPaymentMethodResource;
use App\Http\Resources\V1\PaymentMethod\PaymentMethodResource;

class PaymentMethodController extends Controller
{
    protected PaymentMethodApplicationServiceInterface $service;

    public function __construct(PaymentMethodApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetAllPaymentMethodRequest $request)
    {
        $data = $this->service->getAll($request->all());
        return ApiResponseClass::sendRequest(new GetAllPaymentMethodResource($data), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\PaymentMethod\StorePaymentMethodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentMethodRequest $request)
    {
        $requestData = $request->validated();
        $entity = CreatePaymentMethodCommand::build($requestData);
        $data = $this->service->store($entity);
        $entity->id((string) $data->id);

        $this->syncFinanceOperator($entity, $requestData ?? []);
        $this->syncPaymentPlan($entity, $requestData ?? []);
        return ApiResponseClass::sendRequest(new PaymentMethodResource($data), 'PaymentMethod Created Successful', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Requests\V1\PaymentMethod\ShowPaymentMethodRequest
     */
    public function show(ShowPaymentMethodRequest $request, $id)
    {
        $request->validated();
        $data = $this->service->findById(CreatePaymentMethodCommand::build(['id' => $id]));
        return ApiResponseClass::sendRequest(new PaymentMethodResource($data), '', 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\V1\PaymentMethod\UpdatePaymentMethodRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentMethodRequest $request, $id)
    {
        $requestData = $request->validated();
        $requestData['id'] = $id;

        $entity = CreatePaymentMethodCommand::build($requestData);
        $data = $this->service->update($entity);
        $this->syncFinanceOperator($entity, $requestData ?? []);
        $this->syncPaymentPlan($entity, $requestData ?? []);

        return response()->noContent();
    }

    /**
     * Sync financial operators
     *
     * @param CreatePaymentMethodCommand $entity
     * @param array $data
     * @return void
     */
    protected function syncFinanceOperator(CreatePaymentMethodCommand $entity, array $data): void
    {
        $ids = $data['operador_financeiro_id'] ?? [];

        foreach ($ids as $id) {
            $entity->addFinanceOperators(['id' => $id]);
        }

        $this->service->syncFinancialOperators($entity);
    }

    /**
     * Sync payment plans
     *
     * @param CreatePaymentMethodCommand $entity
     * @param array $data
     * @return void
     */
    protected function syncPaymentPlan(CreatePaymentMethodCommand $entity, array $data): void
    {
        $ids = $data['plano_pagamento_id'] ?? [];

        foreach ($ids as $id) {
            $entity->addPaymentPlans(['id' => $id]);
        }

        $this->service->syncPaymentPlans($entity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\V1\PaymentMethod\DestroyPaymentMethodRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPaymentMethodRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->destroy(CreatePaymentMethodCommand::build($data));
        return response()->noContent();
    }
}
