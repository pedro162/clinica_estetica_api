<?php

namespace Tests\Feature\Person;

use App\Application\Handlers\Person\CreatePersonHandler;
use App\Application\Services\Person\PersonApplicationService;
use App\Domain\Person\Entities\Person;
use App\Grupo;
use App\Infrastructure\Persistence\Eloquent\EloquentPersonRepository;
use App\Logradouro;
use App\Pessoa;
use App\Telefone;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Tests\Feature\SetupTest;

class PersonServiceTest extends TestCase
{
    //use RefreshDatabase;

    protected PersonApplicationService $personApplicationService;
    protected Pessoa $payload;
    protected Pessoa $person;
    protected Logradouro $address;
    protected Telefone $phone;
    //Test Documentatin: https://www.devmedia.com.br/teste-unitario-com-phpunit/41231#assertgreaterthan-
    ///opt/lampp$ sudo ./manager-linux-x64.run

    protected function setUp(): void
    {
        parent::setUp();
        $this->payload = factory(Pessoa::class)->make();
        $this->address = factory(Logradouro::class)->make();
        $this->phone = factory(Telefone::class)->make();
        $this->person = factory(Pessoa::class)->create();
        $user = factory(User::class)->create();
        Passport::actingAs($user, ['*']);
    }

    public function testGetAllPersons()
    {
        $response = $this->getJson(route('pessoa.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ]);
    }

    public function testCreateANewPerson()
    {
        $data = $this->payload->toArray();
        $addressData = $this->address->toArray();
        $phoneData = $this->phone->toArray();
        $phoneData['numero'] = preg_replace('/\D/', '', $phoneData['numero']);

        unset($data['id'], $data['user_id'], $data['user_update_id']);
        unset($addressData['pessoa_id'], $addressData['id'], $addressData['user_id'], $addressData['user_update_id'], $addressData['tenant_id']);
        unset($phoneData['pessoa_id'], $phoneData['id'], $phoneData['user_id'], $phoneData['user_update_id'], $phoneData['tenant_id']);

        $data['grupo_id'] = Grupo::first() ? Grupo::first()->id : factory(Grupo::class)->create()->id;
        $data['endereco'] = $addressData;
        $data['logradouro'][] = $addressData;
        $data['contatos'][] = $phoneData;
        $data['telefone'][] = $phoneData;

        $dataResponse = $data;
        unset($dataResponse['contatos'], $dataResponse['endereco'], $dataResponse['grupo_id']);
        unset($data['id'], $data['user_id'], $data['user_update_id']);

        $this->postJson(route('pessoa.store'), $data)
            ->assertJsonStructure([
                'success',
                'data',
            ])->assertJson([
                'data' => $dataResponse
            ]);
    }

    public function testUpdatePerson()
    {
        $data = $this->payload->toArray();
        $addressData = $this->address->toArray();
        $phoneData = $this->phone->toArray();
        $phoneData['numero'] = preg_replace('/\D/', '', $phoneData['numero']);

        unset($data['id'], $data['user_id'], $data['user_update_id']);
        unset($addressData['pessoa_id'], $addressData['id'], $addressData['user_id'], $addressData['user_update_id'], $addressData['tenant_id']);
        unset($phoneData['pessoa_id'], $phoneData['id'], $phoneData['user_id'], $phoneData['user_update_id'], $phoneData['tenant_id']);

        $data['grupo_id'] = Grupo::first() ? Grupo::first()->id : factory(Grupo::class)->create()->id;
        $data['endereco'] = $addressData;
        $data['logradouro'][] = $addressData;
        $data['contatos'][] = $phoneData;
        $data['telefone'][] = $phoneData;

        $dataResponse = $data;
        unset($dataResponse['contatos'], $dataResponse['telefone'], $dataResponse['endereco'], $dataResponse['logradouro'], $dataResponse['grupo_id']);
        unset($data['id'], $data['user_id'], $data['user_update_id']);


        $response = $this->putJson(route('pessoa.update', ['id' => $this->person->id]), $data)
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);
        $this->assertDatabaseHas(
            $this->person->getTable(),
            array_merge($dataResponse, ['id' => $this->person->id])
        );
    }

    public function testGetAPersonsById()
    {
        $data = $this->person->toArray();
        $response = $this->getJson(route('pessoa.show', ['id' => $this->person->id]));

        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJsonPath('data.id', $this->person->id)
            ->assertJson([
                'data' => $data
            ]);

        $this->assertDatabaseHas($this->person->getTable(), $data);
    }
}
