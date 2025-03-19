<?php

namespace App\Http\Controllers\Admin\V1\AccountReceivable;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\Application\Services\AccountReceivable\AccountReceivableApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AccountReceivable\CreateAccountReceivableRequest;
use App\Http\Requests\V1\AccountReceivable\GetAllAccountReceivableRequest;
use App\Http\Requests\V1\AccountReceivable\PayOffAccountReceivableRequest;
use App\Http\Requests\V1\AccountReceivable\ShowAccountReceivableRequest;
use App\Http\Requests\V1\AccountReceivable\StoreAccountReceivableRequest;
use App\Http\Requests\V1\AccountReceivable\UpdateAccountReceivableRequest;
use App\Http\Resources\V1\AccountReceivable\AccountReceivableCollection;
use App\Http\Resources\V1\AccountReceivable\AccountReceivableResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountReceivableController extends Controller
{
    protected AccountReceivableApplicationServiceInterface $service;

    public function __construct(AccountReceivableApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function index(GetAllAccountReceivableRequest $request): JsonResponse
    {
        $data = $this->service->getAll($request->all());
        return ApiResponseClass::sendRequest(new AccountReceivableCollection($data), '', JsonResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\AccountReceivable\StoreAccountReceivableRequest  $request
     * @return Illuminate\Http\JsonResponse
     */
    public function store(StoreAccountReceivableRequest $request): JsonResponse
    {
        $data = $this->service->store(CreateAccountReceivableCommand::build($request->validated()));
        return ApiResponseClass::sendRequest(new AccountReceivableCollection($data), 'Account receivable created successful', JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Illuminate\Http\JsonResponse
     */
    public function show(ShowAccountReceivableRequest $request, $id): JsonResponse
    {
        $request->validated();
        $data = $this->service->findById(CreateAccountReceivableCommand::build(['id' => $id]));
        return ApiResponseClass::sendRequest(new AccountReceivableResource($data), '', JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\V1\AccountReceivable\UpdateAccountReceivableRequest $request
     * @param  int  $id
     * @return Illuminate\Http\JsonResponse
     */
    public function update(UpdateAccountReceivableRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->update(CreateAccountReceivableCommand::build($data));

        return ApiResponseClass::sendRequest(new AccountReceivableResource([]), '', JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\V1\AccountReceivable\PayOffAccountReceivableRequest $request
     * @param  int  $id
     * @return Illuminate\Http\JsonResponse
     */
    public function payOff(PayOffAccountReceivableRequest $request, $id, $idAssistente = 0): JsonResponse
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->payOff(CreateAccountReceivableCommand::build($data), $data);
        return ApiResponseClass::sendRequest(new AccountReceivableResource($data), 'Accounts receivable successfully cleared', JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
    }
}
