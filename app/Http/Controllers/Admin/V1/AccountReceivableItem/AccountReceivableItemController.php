<?php

namespace App\Http\Controllers\Admin\V1\AccountReceivableItem;

use App\Application\Commands\AccountReceivableItem\CreateAccountReceivableItemCommand;
use App\Application\Services\AccountReceivableItem\AccountReceivableItemApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AccountReceivableItem\CreateAccountReceivableItemRequest;
use App\Http\Requests\V1\AccountReceivableItem\GetAllAccountReceivableItemRequest;
use App\Http\Requests\V1\AccountReceivableItem\ShowAccountReceivableItemRequest;
use App\Http\Requests\V1\AccountReceivableItem\StoreAccountReceivableItemRequest;
use App\Http\Requests\V1\AccountReceivableItem\UpdateAccountReceivableItemRequest;
use App\Http\Resources\V1\AccountReceivableItem\AccountReceivableItemCollection;
use App\Http\Resources\V1\AccountReceivableItem\AccountReceivableItemResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountReceivableItemController extends Controller
{
    protected AccountReceivableItemApplicationServiceInterface $service;

    public function __construct(AccountReceivableItemApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetAllAccountReceivableItemRequest $request)
    {
        $data = $this->service->getAll($request->all());
        return ApiResponseClass::sendRequest(new AccountReceivableItemCollection($data), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\AccountReceivableItem\StoreAccountReceivableItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountReceivableItemRequest $request)
    {
        $data = $this->service->store(CreateAccountReceivableItemCommand::build($request->validated()));
        return ApiResponseClass::sendRequest(new AccountReceivableItemResource($data), 'AccountReceivableItem Created Successful', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Requests\V1\AccountReceivableItem\ShowAccountReceivableItemRequest
     */
    public function show(ShowAccountReceivableItemRequest $request, $id)
    {
        $request->validated();
        $data = $this->service->findById(CreateAccountReceivableItemCommand::build(['id' => $id]));
        return ApiResponseClass::sendRequest(new AccountReceivableItemResource($data), '', 200);
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
     * @param  \App\Http\Requests\V1\AccountReceivableItem\UpdateAccountReceivableItemRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountReceivableItemRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->update(CreateAccountReceivableItemCommand::build($data));
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
