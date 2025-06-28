<?php

namespace App\Http\Controllers\Admin\V1\PersonAddress;

use App\Application\Commands\PersonAddress\CreatePersonAddressCommand;
use App\Application\Services\PersonAddress\PersonAddressApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\PersonAddress\Repositories\PersonAddressRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PersonAddress\DestroyPersonAddressRequest;
use App\Http\Requests\V1\PersonAddress\GetAllPersonAddressRequest;
use App\Http\Requests\V1\PersonAddress\ShowPersonAddressRequest;
use App\Http\Requests\V1\PersonAddress\StorePersonAddressRequest;
use App\Http\Requests\V1\PersonAddress\UpdatePersonAddressRequest;
use App\Http\Resources\V1\PersonAddress\PersonAddressCollection;
use App\Http\Resources\V1\PersonAddress\PersonAddressResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonAddressController extends Controller
{
    protected PersonAddressApplicationServiceInterface $service;
    protected PersonAddressRepositoryInterface $personRepository;

    public function __construct(
        PersonAddressApplicationServiceInterface $service,
        PersonAddressRepositoryInterface $personRepository
    ) {
        $this->service = $service;
        $this->personRepository = $personRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetAllPersonAddressRequest $request)
    {
        $data = $this->service->getAll($request->all());
        return ApiResponseClass::sendRequest(new PersonAddressCollection($data), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\PersonAddress\StorePersonAddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonAddressRequest $request)
    {
        $data = $this->service->store(CreatePersonAddressCommand::build($request->validated()));
        return ApiResponseClass::sendRequest(new PersonAddressResource($data), 'PersonAddress Created Successful', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Requests\V1\PersonAddress\ShowPersonAddressRequest
     */
    public function show(ShowPersonAddressRequest $request, $id)
    {
        $request->validated();
        $data = $this->service->findById(CreatePersonAddressCommand::build(['id' => $id]));
        return ApiResponseClass::sendRequest(new PersonAddressResource($data), '', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\V1\PersonAddress\UpdatePersonAddressRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonAddressRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->update(CreatePersonAddressCommand::build($data));
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\V1\PersonAddress\DestroyPersonAddressRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPersonAddressRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data = $this->service->destroy(CreatePersonAddressCommand::build($data));
        return response()->noContent();
    }
}
