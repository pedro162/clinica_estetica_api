<?php

namespace App\Http\Controllers\Admin\V1\City;

use App\Application\Commands\City\CreateCityCommand;
use App\Application\Services\City\CityApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\City\CreateCityRequest;
use App\Http\Requests\V1\City\ShowCityRequest;
use App\Http\Requests\V1\City\StoreCityRequest;
use App\Http\Resources\V1\City\CityResource;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(protected CityApplicationServiceInterface $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->service->getAll();
        return ApiResponseClass::sendRequest(CityResource::collection($data), '', 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCityRequest $request)
    {
        $data = $this->service->store(CreateCityCommand::build($request->validate()));
        return ApiResponseClass::sendRequest(new CityResource($data), 'City Created Successful', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowCityRequest $request, $id)
    {
        //$data = $this->service->find(CreateCityCommand::build(['id'=>$id]));
        //return ApiResponseClass::sendRequest(new CityResource($data), '', 200);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
