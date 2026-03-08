<?php

namespace App\Http\Controllers\Admin\V1\AccountReceivable;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\Application\Services\AccountReceivable\AccountReceivableApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Exceptions\CobrancaReceberException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AccountReceivable\GetAllAccountReceivableRequest;
use App\Http\Requests\V1\AccountReceivable\PayOffAccountReceivableRequest;
use App\Http\Requests\V1\AccountReceivable\ShowAccountReceivableRequest;
use App\Http\Requests\V1\AccountReceivable\StoreAccountReceivableRequest;
use App\Http\Requests\V1\AccountReceivable\UpdateAccountReceivableRequest;
use App\Http\Resources\V1\AccountReceivable\AccountReceivableResource;
use App\Http\Resources\V1\AccountReceivable\GetAllAccountReceivableResource;
use Illuminate\Http\JsonResponse;

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
        try {
            \DB::beginTransaction();
            $data = $this->service->getAll($request->all());
            \DB::commit();
            return ApiResponseClass::sendRequest(new GetAllAccountReceivableResource($data), '', JsonResponse::HTTP_OK);
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            \DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\AccountReceivable\StoreAccountReceivableRequest  $request
     * @return Illuminate\Http\JsonResponse
     */
    public function store(StoreAccountReceivableRequest $request): JsonResponse
    {
        try {
            \DB::beginTransaction();
            $data = $this->service->store(CreateAccountReceivableCommand::build($request->validated()));
            \DB::commit();

            return ApiResponseClass::sendRequest(
                new GetAllAccountReceivableResource($data),
                'Account receivable created successful',
                JsonResponse::HTTP_CREATED
            );
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            \DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Illuminate\Http\JsonResponse
     */
    public function show(ShowAccountReceivableRequest $request, $id): JsonResponse
    {
        try {
            \DB::beginTransaction();
            $request->validated();
            $data = $this->service->findById(CreateAccountReceivableCommand::build(['id' => $id]));
            \DB::commit();
            return ApiResponseClass::sendRequest(new AccountReceivableResource($data), '', JsonResponse::HTTP_OK);
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            \DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
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
        try {
            \DB::beginTransaction();

            $data = $request->validated();
            $data['id'] = $id;
            $data = $this->service->update(CreateAccountReceivableCommand::build($data));

            \DB::commit();

            return ApiResponseClass::sendRequest(new AccountReceivableResource([]), '', JsonResponse::HTTP_NO_CONTENT);
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            \DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
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
        try {
            \DB::beginTransaction();

            $data = $request->validated();
            $data['id'] = $id;
            $data = $this->service->payOff(CreateAccountReceivableCommand::build($data), $data);

            \DB::commit();
            return ApiResponseClass::sendRequest(new AccountReceivableResource($data), 'Accounts receivable successfully cleared', JsonResponse::HTTP_OK);
        } catch (CobrancaReceberException $e) {
            \DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            \DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
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
