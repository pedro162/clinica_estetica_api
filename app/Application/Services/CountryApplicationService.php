<?php

namespace App\Application\Services;

use App\Application\Commands\CreateCountryCommand;
use App\Application\Handlers\CreateCountryHandler;
use App\Domain\Country\Entities\Country;

class CountryApplicationService
{
    private CreateCountryHandler $createCountryHandler;

    public function __construct(CreateCountryHandler $createCountryHandler)
    {
        $this->createCountryHandler = $createCountryHandler;
    }

    public function createCountry(
        CreateCountryCommand $command
    ): ?Country {

        return $this->createCountryHandler->handler($command);
    }
}
