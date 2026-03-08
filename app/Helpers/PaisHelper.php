<?php

namespace App\Helpers;

use App\Application\Commands\Country\CreateCountryCommand as CountryCreateCountryCommand;
use App\Application\Handlers\Country\CreateCountryHandler;
use App\Application\Handlers\Country\GetAllCountryHandler;
use App\Application\Handlers\Country\GetCountryByIdHandler;
use App\Application\Handlers\Country\UpdateCountryHandler;

class PaisHelper
{
    protected CreateCountryHandler $createCountryHandler;
    protected GetAllCountryHandler $getAllCountryHandler;
    protected UpdateCountryHandler $updateCountryHandler;
    protected GetCountryByIdHandler $getCountryByIdHandler;

    public function __construct(
        CreateCountryHandler $createCountryHandler,
        GetAllCountryHandler $getAllCountryHandler,
        UpdateCountryHandler $updateCountryHandler,
        GetCountryByIdHandler $getCountryByIdHandler
    ) {
        $this->createCountryHandler = $createCountryHandler;
        $this->getAllCountryHandler = $getAllCountryHandler;
        $this->updateCountryHandler = $updateCountryHandler;
        $this->getCountryByIdHandler = $getCountryByIdHandler;
    }

    public function info($dados, $id)
    {
        $dados['id'] = $id;
        return $this->getCountryByIdHandler->handler(CountryCreateCountryCommand::build($dados));
    }

    public function store($dados)
    {
        return $this->createCountryHandler->handler(CountryCreateCountryCommand::build($dados));
    }

    public function json($dados)
    {
        return $this->getAllCountryHandler->handler($dados);
    }
}
