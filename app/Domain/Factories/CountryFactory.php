<?php

namespace App\Domain\Factories;

use App\Application\Commands\CreateCountryCommand;
use App\Domain\Country\Entities\Country;

class CountryFactory
{
    const WHATS_APP_TEMPLATE = 'whatsapp';

    public static function create($type, CreateCountryCommand $command): Country
    {
        return (new Country());
    }
}
