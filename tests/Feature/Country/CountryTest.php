<?php

namespace Tests\Feature\Country;

use App\Pais;
use App\User;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CountryTest extends TestCase
{
    protected Pais $payload;
    protected Pais $country;

    protected function setUp(): void
    {
        parent::setUp();

        $this->payload = factory(Pais::class)->make(['active' => 'yes']);
        $this->country = factory(Pais::class)->create(['active' => 'yes']);
        $user = factory(User::class)->create();
        Passport::actingAs($user);
    }

    public function testGetAllCountries()
    {
        $response = $this->getJson(route('pais.index'));
        //$response->dumpHeaders();
        //$response->dumpSession();
        //$response->dump();
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'success'
            ]);
    }

    public function testCrateANewCountry()
    {
        $data = $this->payload->toArray();
        unset($data['id'], $data['user_id'], $data['user_update_id'], $data['tenant_id']);

        $response = $this->postJson(route('pais.store'), $data);
        //$response->dumpHeaders();
        //$response->dumpSession();
        //$response->dump();
        //dd($response->json());
        $response->assertCreated()
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'data' => $data
            ]);
    }

    public function testUpdateACountry()
    {
        $data = $this->payload->toArray();
        unset($data['user_update_id']);
        $response = $this->putJson(route('pais.update', ['id' => $this->country->id]), $data);
        $response->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseHas(
            $this->country->getTable(),
            array_merge($data, ['id' => $this->country->id])
        );
    }

    public function testGetACountryById()
    {
        $data = $this->country->toArray();
        $response = $this->getJson(route('pais.show', ['id' => $this->country->id]));

        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJsonPath('data.id', $this->country->id)
            ->assertJson([
                'data' => $data
            ]);

        $this->assertDatabaseHas($this->country->getTable(), $data);
    }
}
