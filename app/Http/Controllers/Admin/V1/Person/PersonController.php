<?php

namespace App\Http\Controllers\Admin\V1\Person;

use App\Application\Commands\Person\CreatePersonCommand;
use App\Application\Services\Person\PersonApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Person\CreatePersonRequest;
use App\Http\Requests\V1\Person\DestroyPersonRequest;
use App\Http\Requests\V1\Person\GetAllPersonRequest;
use App\Http\Requests\V1\Person\ShowPersonRequest;
use App\Http\Requests\V1\Person\StorePersonRequest;
use App\Http\Requests\V1\Person\UpdatePersonRequest;
use App\Http\Resources\V1\Person\PersonCollection;
use App\Http\Resources\V1\Person\PersonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    protected PersonApplicationServiceInterface $service;

    public function __construct(PersonApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetAllPersonRequest $request)
    {
        $data = $this->service->getAll($request->all());
        return ApiResponseClass::sendRequest(new PersonCollection($data), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\Person\StorePersonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonRequest $request)
    {
        $data = $this->service->store(CreatePersonCommand::build($request->validated()));
        return ApiResponseClass::sendRequest(new PersonResource($data), 'Person Created Successful', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Requests\V1\Person\ShowPersonRequest
     */
    public function show(ShowPersonRequest $request, $id)
    {
        $request->validated();
        $data = $this->service->findById(CreatePersonCommand::build(['id' => $id]));
        return ApiResponseClass::sendRequest(new PersonResource($data), '', 200);
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
     * @param  \App\Http\Requests\V1\Person\UpdatePersonRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->update(CreatePersonCommand::build($data));
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\V1\Person\DestroyPersonRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPersonRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->destroy(CreatePersonCommand::build($data));
        return response()->noContent();
    }
}
