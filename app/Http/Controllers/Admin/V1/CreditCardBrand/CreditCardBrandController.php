<?php

namespace App\Http\Controllers\Admin\V1\CreditCardBrand;

use App\Application\Commands\CreditCardBrand\CreateCreditCardBrandCommand;
use App\Application\Services\CreditCardBrand\CreditCardBrandApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CreditCardBrand\DestroyCreditCardBrandRequest;
use App\Http\Requests\V1\CreditCardBrand\GetAllCreditCardBrandRequest;
use App\Http\Requests\V1\CreditCardBrand\ShowCreditCardBrandRequest;
use App\Http\Requests\V1\CreditCardBrand\StoreCreditCardBrandRequest;
use App\Http\Requests\V1\CreditCardBrand\UpdateCreditCardBrandRequest;
use App\Http\Resources\V1\CreditCardBrand\GetAllCreditCardBrandResource;
use App\Http\Resources\V1\CreditCardBrand\CreditCardBrandResource;
use Illuminate\Http\JsonResponse;

class CreditCardBrandController extends Controller
{
    protected CreditCardBrandApplicationServiceInterface $service;

    public function __construct(CreditCardBrandApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(GetAllCreditCardBrandRequest $request): JsonResponse
    {
        $data = $this->service->getAll($request->all());
        return ApiResponseClass::sendRequest(new GetAllCreditCardBrandResource($data), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\CreditCardBrand\StoreCreditCardBrandRequest  $request
     * @return JsonResponse
     */
    public function store(StoreCreditCardBrandRequest $request): JsonResponse
    {
        $requestData = $request->validated();
        $entity = CreateCreditCardBrandCommand::build($requestData);
        $data = $this->service->store($entity);
        $entity->id((string) $data->id);

        return ApiResponseClass::sendRequest(new CreditCardBrandResource($data), 'CreditCardBrand Created Successful', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Http\Requests\V1\CreditCardBrand\ShowCreditCardBrandRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(ShowCreditCardBrandRequest $request, $id): JsonResponse
    {
        $request->validated();
        $data = $this->service->findById(CreateCreditCardBrandCommand::build(['id' => $id]));
        return ApiResponseClass::sendRequest(new CreditCardBrandResource($data), '', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\V1\CreditCardBrand\UpdateCreditCardBrandRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(UpdateCreditCardBrandRequest $request, $id): JsonResponse
    {
        $requestData = $request->validated();
        $requestData['id'] = $id;

        $entity = CreateCreditCardBrandCommand::build($requestData);
        $this->service->update($entity);
        return ApiResponseClass::sendRequest(new CreditCardBrandResource([]), '', JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\V1\CreditCardBrand\DestroyCreditCardBrandRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(DestroyCreditCardBrandRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $data['id'] = $id;
        $this->service->destroy(CreateCreditCardBrandCommand::build($data));
        return ApiResponseClass::sendRequest(new CreditCardBrandResource([]), '', JsonResponse::HTTP_NO_CONTENT);
    }
}
