<?php

namespace App\Http\Controllers\Admin\V1\PaymentPlan;

use App\Application\Commands\PaymentPlan\CreatePaymentPlanCommand;
use App\Application\Services\PaymentPlan\PaymentPlanApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PaymentPlan\CreatePaymentPlanRequest;
use App\Http\Requests\V1\PaymentPlan\DestroyPaymentPlanRequest;
use App\Http\Requests\V1\PaymentPlan\GetAllPaymentPlanRequest;
use App\Http\Requests\V1\PaymentPlan\ShowPaymentPlanRequest;
use App\Http\Requests\V1\PaymentPlan\StorePaymentPlanRequest;
use App\Http\Requests\V1\PaymentPlan\UpdatePaymentPlanRequest;
use App\Http\Resources\V1\PaymentPlan\PaymentPlanCollection;
use App\Http\Resources\V1\PaymentPlan\PaymentPlanResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentPlanController extends Controller
{
    protected PaymentPlanApplicationServiceInterface $service;

    public function __construct(PaymentPlanApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetAllPaymentPlanRequest $request)
    {
        $data = $this->service->getAll($request->all());
        return ApiResponseClass::sendRequest(new PaymentPlanCollection($data), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\PaymentPlan\StorePaymentPlanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentPlanRequest $request)
    {
        $data = $this->service->store(CreatePaymentPlanCommand::build($request->validated()));
        return ApiResponseClass::sendRequest(new PaymentPlanResource($data), 'PaymentPlan Created Successful', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Requests\V1\PaymentPlan\ShowPaymentPlanRequest
     */
    public function show(ShowPaymentPlanRequest $request, $id)
    {
        $request->validated();
        $data = $this->service->findById(CreatePaymentPlanCommand::build(['id' => $id]));
        return ApiResponseClass::sendRequest(new PaymentPlanResource($data), '', 200);
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
     * @param  \App\Http\Requests\V1\PaymentPlan\UpdatePaymentPlanRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentPlanRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->update(CreatePaymentPlanCommand::build($data));
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\V1\PaymentPlan\DestroyPaymentPlanRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPaymentPlanRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->destroy(CreatePaymentPlanCommand::build($data));
        return response()->noContent();
    }
}
