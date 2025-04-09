<?php

namespace App\Http\Controllers\Admin\V1\PaymentMethod;

use App\Application\Commands\PaymentMethod\CreatePaymentMethodCommand;
use App\Application\Services\PaymentMethod\PaymentMethodApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PaymentMethod\CreatePaymentMethodRequest;
use App\Http\Requests\V1\PaymentMethod\GetAllPaymentMethodRequest;
use App\Http\Requests\V1\PaymentMethod\ShowPaymentMethodRequest;
use App\Http\Requests\V1\PaymentMethod\StorePaymentMethodRequest;
use App\Http\Requests\V1\PaymentMethod\UpdatePaymentMethodRequest;
use App\Http\Resources\V1\PaymentMethod\PaymentMethodCollection;
use App\Http\Resources\V1\PaymentMethod\PaymentMethodResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        return ApiResponseClass::sendRequest(new PaymentMethodCollection($data), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\PaymentMethod\StorePaymentMethodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentMethodRequest $request)
    {
        $data = $this->service->store(CreatePaymentMethodCommand::build($request->validated()));
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
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->update(CreatePaymentMethodCommand::build($data));
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
