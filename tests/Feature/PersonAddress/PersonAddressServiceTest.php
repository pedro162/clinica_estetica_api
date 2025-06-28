<?php

namespace Tests\Feature\PersonAddress;

use App\Application\Services\PersonAddress\PersonAddressApplicationService;
use App\Logradouro;
use App\Pessoa;
use App\User;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PersonAddressServiceTest extends TestCase
{
    protected PersonAddressApplicationService $personApplicationService;
    protected Logradouro $payload;
    protected Logradouro $address;
    protected Pessoa $pessoa;


    protected function setUp(): void
    {
        parent::setUp();
        $this->payload = factory(Logradouro::class)->make();
        $this->address = factory(Logradouro::class)->create();
        $user = factory(User::class)->create();
        $this->pessoa = factory(Pessoa::class)->create();
        Passport::actingAs($user, ['*']);
    }

    public function testGetAllPersonAddresss()
    {
        $response = $this->getJson(route('logradouro.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ]);
    }

    public function testCreateANewPersonAddress()
    {
        $data = $this->payload->toArray();
        unset($data['id'], $data['user_id'], $data['user_update_id']);
        $this->postJson(route('logradouro.store', ['idPessoa' => $this->pessoa->id]), $data)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJson([
                'data' => $data
            ]);
    }

    public function testUpdatePersonAddress()
    {
        $data = $this->payload->toArray();
        unset($data['id'], $data['user_id'], $data['user_update_id']);

        $response = $this->putJson(route('logradouro.update', ['idPessoa' => $this->pessoa->id, 'id' => $this->address->id]), $data)
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);
        $this->assertDatabaseHas(
            $this->address->getTable(),
            array_merge($data, ['id' => $this->address->id])
        );
    }

    public function testGetAPersonAddresssById()
    {
        $data = $this->address->toArray();
        $response = $this->getJson(route('logradouro.show', ['idPessoa' => $this->pessoa->id, 'id' => $this->address->id]));

        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJsonPath('data.id', $this->address->id)
            ->assertJson([
                'data' => $data
            ]);

        $this->assertDatabaseHas($this->address->getTable(), $data);
    }
}
