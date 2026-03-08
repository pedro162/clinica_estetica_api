<?php

namespace Tests\Feature\City;

use App\Cidade;
use App\Estado;
use App\User;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->create();
        Passport::actingAs($user);
    }

    public function testGetAllCities()
    {
        $response = $this->getJson(route('cidade.index'));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'success'
            ]);
    }

    public function testCrateANewCity()
    {

        $response = $this->postJson(route('cidade.store'), [
            'nmCidade' => 'Test city',
            'cdCidade' => '123',
            'sigla' => 'TS',
            'estado_id' => factory(Estado::class)->create()->id
        ]);
        //$response->dumpHeaders();
        //$response->dumpSession();
        //$response->dump();
        $response->assertCreated()
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJson([
                'data' => [
                    'nmCidade' => 'Test city',
                    'cdCidade' => '123',
                    'sigla' => 'TS'
                ]
            ])->assertJsonPath('data.sigla', 'TS');
    }

    public function testUpdateACity()
    {
        $city = factory(Cidade::class)->create();

        $response = $this->putJson(route('cidade.update', ['id' => $city->id]), [
            'nmCidade' => 'Updated city',
            'cdCidade' => '123',
            'sigla' => 'TS',
            'estado_id' => $city->estado_id
        ]);

        $response->dump();
        $response->assertStatus(204);

        $this->assertDatabaseHas($city->getTable(), [
            'nmCidade' => 'Updated city',
            'cdCidade' => '123',
            'sigla' => 'TS',
            'estado_id' => $city->estado_id
        ]);
    }

    public function testGetACityById()
    {
        $city = factory(Cidade::class)->create();

        $response = $this->getJson(route('cidade.show', ['id' => $city->id]));

        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJsonPath('data.id', $city->id);

        $this->assertDatabaseHas($city->getTable(), [
            'id' => $city->id
        ]);
    }
}
