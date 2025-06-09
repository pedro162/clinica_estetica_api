<?php

namespace Tests\Feature\Person;

use App\Application\Handlers\Person\CreatePersonHandler;
use App\Application\Services\Person\PersonApplicationService;
use App\Domain\Person\Entities\Person;
use App\Infrastructure\Persistence\Eloquent\EloquentPersonRepository;
use App\Pessoa;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Tests\Feature\SetupTest;

class PersonServiceTest extends TestCase
{
    protected PersonApplicationService $personApplicationService;
    protected Pessoa $payload;
    protected Pessoa $person;
    //Test Documentatin: https://www.devmedia.com.br/teste-unitario-com-phpunit/41231#assertgreaterthan-
    ///opt/lampp$ sudo ./manager-linux-x64.run

    protected function setUp(): void
    {
        parent::setUp();
        $this->payload = factory(Pessoa::class)->make();
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
        unset($data['id']);
        $this->postJson(route('pessoa.store'), $data)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJson([
                'data' => $data
            ]);
    }

    public function testUpdatePerson()
    {
        $this->person->name = 'Pessoa de teste';
        $data = $this->person->toArray();

        $response = $this->putJson(route('pessoa.update', ['id' => $this->person->id]), $data)
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);
        $this->assertDatabaseHas($this->person->getTable(), [
            'id' => $this->person->id,
            'name' => $this->person->name
        ]);
    }
}
