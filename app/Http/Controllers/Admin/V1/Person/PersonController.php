<?php

namespace App\Http\Controllers\Admin\V1\Person;

use App\Application\Commands\Person\CreatePersonCommand;
use App\Application\Services\Person\PersonApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Person\Repositories\PersonRepositoryInterface;
use App\Domain\Person\ValueObjects\PersonDocument;
use App\Domain\PersonAddress\Entities\PersonAddress;
use App\Domain\PersonAddress\Repositories\PersonAddressRepositoryInterface;
use App\Exceptions\PessoaException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Person\DestroyPersonRequest;
use App\Http\Requests\V1\Person\GetAllPersonRequest;
use App\Http\Requests\V1\Person\ShowPersonRequest;
use App\Http\Requests\V1\Person\StorePersonRequest;
use App\Http\Requests\V1\Person\UpdatePersonRequest;
use App\Http\Resources\V1\Person\GetAllPersonResource;
use App\Http\Resources\V1\Person\PersonResource;

class PersonController extends Controller
{
    protected PersonApplicationServiceInterface $service;
    protected PersonRepositoryInterface $personRepository;
    protected PersonAddressRepositoryInterface $addressRepository;
    protected ContactRepositoryInterface $phoneRepotitory;

    public function __construct(
        PersonApplicationServiceInterface $service,
        PersonRepositoryInterface $personRepository,
        PersonAddressRepositoryInterface $addressRepository,
        ContactRepositoryInterface $phoneRepotitory
    ) {
        $this->service = $service;
        $this->personRepository = $personRepository;
        $this->addressRepository = $addressRepository;
        $this->phoneRepotitory = $phoneRepotitory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetAllPersonRequest $request)
    {
        $data = $this->service->getAll($request->all());
        return ApiResponseClass::sendRequest(new GetAllPersonResource($data), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\Person\StorePersonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonRequest $request)
    {
        $requestData = $request->validated();

        if ($this->personRepository->findByDocument(new PersonDocument((string) $requestData['documento']))) {
            throw new PessoaException('Pessoa já se encontra cadastrada.');
        }

        $data = $this->service->store(CreatePersonCommand::build($requestData));
        $addressData = $requestData['endereco'] ?? [];
        $dadosContato = $requestData['contatos'] ?? [];

        $this->personRepository->syncGroupe((int)$data->id, $requestData['grupo_id']);
        $this->syncEndereco($data, $addressData);
        $this->syncContatos($data, $dadosContato);

        return ApiResponseClass::sendRequest(new PersonResource($data->refresh()), 'Person Created Successful', 201);
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
        $requestData = $request->validated();
        $requestData['id'] = $id;

        $command = CreatePersonCommand::build($requestData);

        $this->service->update($command);
        $data = $this->service->findById($command);

        $addressData = $requestData['endereco'] ?? [];
        $dadosContato = $requestData['contatos'] ?? [];

        $this->personRepository->syncGroupe((int)$data->id, $requestData['grupo_id']);
        $this->syncEndereco($data, $addressData);
        $this->syncContatos($data, $dadosContato);

        return response()->noContent();
    }

    protected function syncEndereco($data, $enderecoData)
    {
        $address = $data->logradouro()->where('importancia', '=', 'principal')->first();

        $enderecoData['id']  = $address ? $address->id : null;
        $enderecoData['active']   =  $enderecoData['active'] ?? 'yes';
        $enderecoData['importancia']  = $enderecoData['importancia'] ?? 'principal';
        $enderecoData['estado']   = $enderecoData['estado'] ?? $addressData['estado_id'] ?? null;

        if ($enderecoData['id'] > 0) {
            $this->addressRepository->update(PersonAddress::buildEntity($enderecoData));
        } else {
            $address = $this->addressRepository->save(PersonAddress::buildEntity($enderecoData));
        }

        $this->personRepository->syncAddress((int)$data->id, (int) $address->id);
    }

    protected function syncContatos($data, $contactData)
    {
        $this->personRepository->deletePhones((int)$data->id);

        foreach ($contactData as $value) {
            $value['tipo'] = $value['tipo'] ?? 'telefone';
            $value['importancia'] = $value['importancia'] ?? 'secundario';
            $value['numero'] = $value['numero'] ?? $value['valor'] ?? '00000000000';
            $value['pessoa_id'] = $data->id;

            unset($value['valor']);
            $this->phoneRepotitory->crateSimple($value);
        }
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
