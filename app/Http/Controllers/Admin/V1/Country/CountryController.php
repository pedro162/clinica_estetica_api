<?php

namespace App\Http\Controllers\Admin\V1\Country;

use App\Application\Commands\Country\CreateCountryCommand;
use App\Application\Services\Country\CountryApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Country\CreateCountryRequest;
use App\Http\Requests\V1\Country\DestroyCountryRequest;
use App\Http\Requests\V1\Country\GetAllCountryRequest;
use App\Http\Requests\V1\Country\ShowCountryRequest;
use App\Http\Requests\V1\Country\StoreCountryRequest;
use App\Http\Requests\V1\Country\UpdateCountryRequest;
use App\Http\Resources\V1\Country\CountryCollection;
use App\Http\Resources\V1\Country\CountryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected CountryApplicationServiceInterface $service;

    public function __construct(CountryApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(GetAllCountryRequest $request): JsonResponse
    {
        $dataRequest = $request->all();
        $data = $this->service->getAll($dataRequest);

        return ApiResponseClass::sendRequest(
            new CountryCollection($data),
            '',
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCountryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCountryRequest $request): JsonResponse
    {
        $data = $this->service->store(CreateCountryCommand::build($request->validated()));
        return ApiResponseClass::sendRequest(new CountryResource($data), 'Country Created Successful', 201);
    }

    /**
     * Display the specified resource.
     * 
     * @param  ShowCountryRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(ShowCountryRequest $request, $id): JsonResponse
    {
        $request->validated();
        $data = $this->service->findById(CreateCountryCommand::build(['id' => $id]));
        return ApiResponseClass::sendRequest(new CountryResource($data), '', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\V1\Country\UpdateCountryRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(UpdateCountryRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->update(CreateCountryCommand::build($data));
        return ApiResponseClass::sendRequest(new CountryResource($data), '', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DestroyCountryRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(DestroyCountryRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->destroy(CreateCountryCommand::build($data));
        return ApiResponseClass::sendRequest(new CountryResource($data), '', 204);
    }
}
