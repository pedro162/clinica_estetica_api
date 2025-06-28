<?php

namespace App\Http\Controllers\Admin\V1\FinancialOperator;

use App\Application\Commands\FinancialOperator\CreateFinancialOperatorCommand;
use App\Application\Services\FinancialOperator\FinancialOperatorApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\FinancialOperator\DestroyFinancialOperatorRequest;
use App\Http\Requests\V1\FinancialOperator\GetAllFinancialOperatorRequest;
use App\Http\Requests\V1\FinancialOperator\ShowFinancialOperatorRequest;
use App\Http\Requests\V1\FinancialOperator\StoreFinancialOperatorRequest;
use App\Http\Requests\V1\FinancialOperator\UpdateFinancialOperatorRequest;
use App\Http\Resources\V1\FinancialOperator\FinancialOperatorCollection;
use App\Http\Resources\V1\FinancialOperator\FinancialOperatorResource;

class FinancialOperatorController extends Controller
{
    protected FinancialOperatorApplicationServiceInterface $service;

    public function __construct(FinancialOperatorApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetAllFinancialOperatorRequest $request)
    {
        $data = $this->service->getAll($request->all());
        return ApiResponseClass::sendRequest(new FinancialOperatorCollection($data), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\FinancialOperator\StoreFinancialOperatorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFinancialOperatorRequest $request)
    {
        $data = $this->service->store(CreateFinancialOperatorCommand::build($request->validated()));
        return ApiResponseClass::sendRequest(new FinancialOperatorResource($data), 'FinancialOperator Created Successful', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Requests\V1\FinancialOperator\ShowFinancialOperatorRequest
     */
    public function show(ShowFinancialOperatorRequest $request, $id)
    {
        $request->validated();
        $data = $this->service->findById(CreateFinancialOperatorCommand::build(['id' => $id]));
        return ApiResponseClass::sendRequest(new FinancialOperatorResource($data), '', 200);
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
     * @param  \App\Http\Requests\V1\FinancialOperator\UpdateFinancialOperatorRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFinancialOperatorRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->update(CreateFinancialOperatorCommand::build($data));
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\V1\FinancialOperator\DestroyFinancialOperatorRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyFinancialOperatorRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->destroy(CreateFinancialOperatorCommand::build($data));
        return response()->noContent();
    }
}
