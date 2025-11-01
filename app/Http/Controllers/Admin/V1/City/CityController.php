<?php

namespace App\Http\Controllers\Admin\V1\City;

use App\Application\Commands\City\CreateCityCommand;
use App\Application\Services\City\CityApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\City\CreateCityRequest;
use App\Http\Requests\V1\City\GetAllCityRequest;
use App\Http\Requests\V1\City\ShowCityRequest;
use App\Http\Requests\V1\City\StoreCityRequest;
use App\Http\Requests\V1\City\UpdateCityRequest;
use App\Http\Resources\V1\City\GetAllCityResource;
use App\Http\Resources\V1\City\CityResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected CityApplicationServiceInterface $service;

    public function __construct(CityApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetAllCityRequest $request)
    {
        $data = $this->service->getAll($request->all());
        return ApiResponseClass::sendRequest(new GetAllCityResource($data), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\City\StoreCityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCityRequest $request)
    {
        $data = $this->service->store(CreateCityCommand::build($request->validated()));
        return ApiResponseClass::sendRequest(new CityResource($data), 'City Created Successful', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Requests\V1\City\ShowCityRequest
     */
    public function show(ShowCityRequest $request, $id)
    {
        $request->validated();
        $data = $this->service->findById(CreateCityCommand::build(['id' => $id]));
        return ApiResponseClass::sendRequest(new CityResource($data), '', 200);
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
     * @param  \App\Http\Requests\V1\City\UpdateCityRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCityRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->update(CreateCityCommand::build($data));
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
