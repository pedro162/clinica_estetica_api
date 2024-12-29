<?php

namespace App\Http\Controllers\Admin\V1\AccountReceivable;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\Application\Services\AccountReceivable\AccountReceivableApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AccountReceivable\CreateAccountReceivableRequest;
use App\Http\Requests\V1\AccountReceivable\GetAllAccountReceivableRequest;
use App\Http\Requests\V1\AccountReceivable\ShowAccountReceivableRequest;
use App\Http\Requests\V1\AccountReceivable\StoreAccountReceivableRequest;
use App\Http\Requests\V1\AccountReceivable\UpdateAccountReceivableRequest;
use App\Http\Resources\V1\AccountReceivable\AccountReceivableCollection;
use App\Http\Resources\V1\AccountReceivable\AccountReceivableResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index(GetAllAccountReceivableRequest $request)
    {
        $data = $this->service->getAll($request->all());
        return ApiResponseClass::sendRequest(new AccountReceivableCollection($data), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\AccountReceivable\StoreAccountReceivableRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountReceivableRequest $request)
    {
        $data = $this->service->store(CreateAccountReceivableCommand::build($request->validated()));
        return ApiResponseClass::sendRequest(new AccountReceivableCollection($data), 'AccountReceivable Created Successful', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Requests\V1\AccountReceivable\ShowAccountReceivableRequest
     */
    public function show(ShowAccountReceivableRequest $request, $id)
    {
        $request->validated();
        $data = $this->service->findById(CreateAccountReceivableCommand::build(['id' => $id]));
        return ApiResponseClass::sendRequest(new AccountReceivableResource($data), '', 200);
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
     * @param  \App\Http\Requests\V1\AccountReceivable\UpdateAccountReceivableRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountReceivableRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->update(CreateAccountReceivableCommand::build($data));
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
