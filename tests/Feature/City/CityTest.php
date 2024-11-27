<?php

namespace Tests\Feature\City;

use App\Estado;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
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
}
