<?php

namespace App\Http\Controllers\Admin\V1\Service;

use App\Application\Commands\Service\CreateServiceCommand;
use App\Application\Services\Service\ServiceApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Service\DestroyServiceRequest;
use App\Http\Requests\V1\Service\GetAllServiceRequest;
use App\Http\Requests\V1\Service\ShowServiceRequest;
use App\Http\Requests\V1\Service\StoreServiceRequest;
use App\Http\Requests\V1\Service\UpdateServiceRequest;
use App\Http\Resources\V1\Service\GetAllServiceResource;
use App\Http\Resources\V1\Service\ServiceResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{


    public function __construct(
        protected ServiceApplicationServiceInterface $service,
        protected ServiceRepositoryInterface $personRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetAllServiceRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->service->getAll($request->all());
            DB::commit();
            return ApiResponseClass::sendRequest(new GetAllServiceResource($data), '', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\Service\StoreServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->service->store(CreateServiceCommand::build($request->validated()));
            DB::commit();
            return ApiResponseClass::sendRequest(new ServiceResource($data->refresh()), 'Service Created Successful', JsonResponse::HTTP_CREATED);
        } catch (ServicoException $e) {
            DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Requests\V1\Service\ShowServiceRequest
     */
    public function show(ShowServiceRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $request->validated();
            $data = $this->service->findById(CreateServiceCommand::build(['id' => $id]));
            DB::commit();
            return ApiResponseClass::sendRequest(new ServiceResource($data), '', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\V1\Service\UpdateServiceRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $requestData = $request->validated();
            $requestData['id'] = $id;
            $this->service->update(CreateServiceCommand::build($requestData));

            DB::commit();
            return ApiResponseClass::sendRequest(new ServiceResource([]), '', JsonResponse::HTTP_NO_CONTENT);
        } catch (ServicoException $e) {
            DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\V1\Service\DestroyServiceRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyServiceRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['id'] = $id;
            $data = $this->service->destroy(CreateServiceCommand::build($data));

            DB::commit();
            return ApiResponseClass::sendRequest(new ServiceResource([]), '', JsonResponse::HTTP_NO_CONTENT);
        } catch (ServicoException $e) {
            DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
