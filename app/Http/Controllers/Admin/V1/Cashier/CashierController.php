<?php

namespace App\Http\Controllers\Admin\V1\Cashier;

use App\Application\Commands\Cashier\CreateCashierCommand;
use App\Application\Services\Cashier\CashierApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cashier\CreateCashierRequest;
use App\Http\Requests\V1\Cashier\GetAllCashierRequest;
use App\Http\Requests\V1\Cashier\ShowCashierRequest;
use App\Http\Requests\V1\Cashier\StoreCashierRequest;
use App\Http\Requests\V1\Cashier\UpdateCashierRequest;
use App\Http\Resources\V1\Cashier\GetAllCashierResource;
use App\Http\Resources\V1\Cashier\CashierResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    protected CashierApplicationServiceInterface $service;

    public function __construct(CashierApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetAllCashierRequest $request)
    {
        $data = $this->service->getAll($request->all());
        return ApiResponseClass::sendRequest(new GetAllCashierResource($data), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\Cashier\StoreCashierRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCashierRequest $request)
    {
        $data = $this->service->store(CreateCashierCommand::build($request->validated()));
        return ApiResponseClass::sendRequest(new CashierResource($data), 'Cashier Created Successful', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Requests\V1\Cashier\ShowCashierRequest
     */
    public function show(ShowCashierRequest $request, $id)
    {
        $request->validated();
        $data = $this->service->findById(CreateCashierCommand::build(['id' => $id]));
        return ApiResponseClass::sendRequest(new CashierResource($data), '', 200);
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
     * @param  \App\Http\Requests\V1\Cashier\UpdateCashierRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCashierRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->update(CreateCashierCommand::build($data));
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
