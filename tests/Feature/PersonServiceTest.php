<?php

namespace Tests\Feature;

use App\Application\Handlers\CreatePersonHandler;
use App\Application\Services\PersonApplicationService;
use App\Infrastructure\Persistence\Eloquent\EloquentPersonRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonServiceTest extends TestCase
{
    protected PersonApplicationService $personApplicationService;
    //Test Documentatin: https://www.devmedia.com.br/teste-unitario-com-phpunit/41231#assertgreaterthan-
    ///opt/lampp$ sudo ./manager-linux-x64.run


    protected function setUp(): void
    {
        parent::setUp();
        $this->testPersonApplicationServiceBootstrap();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /* public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    } */

    /**
     * Attempt to create a person using the DDD Service class resource
     *@return void
     */
    public function testCreateNaturalPersonUsingServicePersonWithUseAnUrl()
    {
        $response = $this->personApplicationService->createPerson(0, 'Pedro', 'aguiar', '61224450370', '', 'm', '');

        $idPerson = (string) $response->getId();
        $idPerson = (int) $idPerson;
        $this->assertGreaterThan(0, $idPerson, "it was not possible to create a natural person");
    }

    private function testPersonApplicationServiceBootstrap()
    {
        $objRepo = new EloquentPersonRepository();
        $objCreatHandler = new CreatePersonHandler($objRepo);
        $objServicePerson = new PersonApplicationService($objCreatHandler);
        $this->personApplicationService = $objServicePerson;
    }
}
