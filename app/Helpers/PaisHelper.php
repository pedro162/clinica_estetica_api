<?php

namespace App\Helpers;

use App\Application\Commands\CreateCountryCommand;
use App\Application\Handlers\CreateCountryHandler;
use App\Application\Services\CountryApplicationService;
use \App\Utilitarios;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pais;
use App\Exceptions\PaisException;
use App\Infrastructure\Persistence\Eloquent\Country\CountryRepository;

class PaisHelper
{

    public function info($dados, $id)
    {

        $id = $id ?? $dados['id'];
        $callBack = $dados['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ($id <= 0) {
            throw new PaisException('Parâmetro ínválido');
        }



        $registro = Pais::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if ($registro == null) {
            throw new PaisException('Registro não encontrado');
        }

        return $registro;
    }



    public function store($dados)
    {
        $dadosRequest = [];

        $dadosRequest['user_id']            = \Auth::User()->id;
        $dadosRequest['user_update_id']     = \Auth::User()->id;
        $dadosRequest['nmPais']             = $dados['nmPais'];
        $dadosRequest['cdPais']             = $dados['cdPais'];
        $dadosRequest['padrao']             = $dados['padrao'];
        $dadosRequest['active']             = 'yes';
        $createCountryCommand = (new CreateCountryCommand())
            ->id(0)
            ->name($dados['nmPais'])
            ->isDefault($dados['padrao'] === 'yes')
            ->code($dados['cdPais']);

        $objRepo = new CountryRepository();
        $objCreateHandler = new CreateCountryHandler($objRepo);
        $objServiceCountry = new CountryApplicationService($objCreateHandler);
        $result = $objServiceCountry->createCountry($createCountryCommand);

        if (! $result) {
            throw new PaisException('Erro ao cadastrar');
        }

        return $result->build();
    }


    public function json($consulta)
    {
        $repository = new CountryRepository();
        return $repository->getAll($consulta);
    }
}
