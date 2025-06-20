<?php

namespace App\Http\Controllers\Admin\V1\Person;

use App\Application\Commands\Person\CreatePersonCommand;
use App\Application\Services\Person\PersonApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Person\Repositories\PersonRepositoryInterface;
use App\Domain\Person\ValueObjects\PersonDocument;
use App\Exceptions\PessoaException;
use App\Grupo;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Person\CreatePersonRequest;
use App\Http\Requests\V1\Person\DestroyPersonRequest;
use App\Http\Requests\V1\Person\GetAllPersonRequest;
use App\Http\Requests\V1\Person\ShowPersonRequest;
use App\Http\Requests\V1\Person\StorePersonRequest;
use App\Http\Requests\V1\Person\UpdatePersonRequest;
use App\Http\Resources\V1\Person\PersonCollection;
use App\Http\Resources\V1\Person\PersonResource;
use App\Logradouro;
use App\Telefone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    protected PersonApplicationServiceInterface $service;
    protected PersonRepositoryInterface $personRepository;

    public function __construct(
        PersonApplicationServiceInterface $service,
        PersonRepositoryInterface $personRepository
    ) {
        $this->service = $service;
        $this->personRepository = $personRepository;
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
        $document = preg_replace("/[^0-9]/", '', trim($request['documento']));
        $request['documento'] = $document;

        if ($this->personRepository->findByDocument(new PersonDocument((string) $document))) {
            throw new PessoaException('Pessoa já se encontra cadastrada.');
        }

        $data = $this->service->store(CreatePersonCommand::build($request->validated()));

        $grupo = Grupo::where('id', '=', $request['groupo_id'])
            ->where('active', '=', 'yes')->first();

        $addressData = array_intersect_key($request->all(), array_flip([
            'cep',
            'logradouro',
            'numero',
            'tipo',
            'complemento',
            'bairro',
            'cidade',
            'estado',
            'bloco'
        ]));

        $addressData['user_id']  = $data->user_id;
        $addressData['active']   = 'yes';
        $addressData['importancia']   = 'principal';

        $dadosContato = array_intersect_key($request->all(), array_flip([
            'celular_1',
            'celular_2',
            'telefone',
        ]));

        $logradouro         = Logradouro::create($addressData);
        $resultLogradouro   = $data->adicionarLogradouro($logradouro, ['active' => 'yes', 'user_id' => $data->user_id]);
        $resultGrupoPessoa  = $data->adicionarGrupo($grupo, ['active' => 'yes', 'user_id' => $data->user_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

        foreach ($dadosContato as $key => $value) {
            $tipo = $key == 'telefone' ? 'fixo' : 'celular';
            $contato        = Telefone::create([
                'numero' => $value ?? '00000000000',
                'tipo' => $tipo,
                'user_id' => $data['user_id'],
                'active' => 'yes',
                'pessoa_id' => $data['id']
            ]);
        }

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
