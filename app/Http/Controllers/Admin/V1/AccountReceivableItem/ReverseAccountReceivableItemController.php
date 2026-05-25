<?php

namespace App\Http\Controllers\Admin\V1\AccountReceivableItem;

use App\Application\Commands\AccountReceivableItem\CreateAccountReceivableItemCommand;
use App\Application\Services\AccountReceivableItem\AccountReceivableItemApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AccountReceivableItem\ReverseAccountReceivableItemRequest;
use App\Http\Resources\V1\AccountReceivableItem\ReverseAccountReceivableItemResource;

class ReverseAccountReceivableItemController extends Controller
{
    protected AccountReceivableItemApplicationServiceInterface $service;

    public function __construct(AccountReceivableItemApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Reverse the specified resource in storage.
     *
     * @param  \App\Http\Requests\V1\AccountReceivableItem\ReverseAccountReceivableItemRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ReverseAccountReceivableItemRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->reverse(CreateAccountReceivableItemCommand::build($data));
        return ApiResponseClass::sendRequest(
            new ReverseAccountReceivableItemResource($data),
            '',
            204
        );
    }
}
