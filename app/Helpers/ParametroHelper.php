<?php

namespace App\Helpers;

use App\Domain\Parameter\Entities\Parameter;
use App\Domain\Parameter\ValueObjects\ParameterId;
use App\Domain\Parameter\ValueObjects\ParameterName;
use App\Domain\Parameter\ValueObjects\ParameterTenantId;
use App\Domain\Parameter\ValueObjects\ParameterType;
use App\Exceptions\CobrancaReceberException;
use App\Infrastructure\Persistence\Eloquent\Parameter\ParameterRepository;
use App\Parametro;

class ParametroHelper extends BaseHelper
{
    public function updater(array $dados, int $id)
    {
        $id             = $id ?? $dados['id'];
        $callBack       = $dados['callBack'] ?? '';
        $caixa_id       = $dados['caixa_id'] ?? 0;

        if ($id <= 0) {
            throw new CobrancaReceberException('Parâmetro ínválido');
        }

        if (! ($caixa_id > 0)) {
            throw new CobrancaReceberException('Parâmetro ínválido para o caixa de baixa');
        }

        $registro = Parametro::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if (! $registro) {
            throw new CobrancaReceberException('Registro não identificao. Tente novamente ou entre em contato com o suporte.');
        }
    }

    public function save(array $data): ?Parameter
    {
        $repository = new ParameterRepository();
        $parameter = (new Parameter())
            ->id(new ParameterId($data['id']))
            ->name(new ParameterName($data['name']))
            ->type(new ParameterType($data['type']))
            ->tenantId(new ParameterTenantId($data['tenant_id']));
        return $repository->save($parameter);
    }

    public function update(array $data): ?Parameter
    {
        $repository = new ParameterRepository();
        $parameter = (new Parameter())
            ->id(new ParameterId($data['id']))
            ->name(new ParameterName($data['name']))
            ->type(new ParameterType($data['type']))
            ->tenantId(new ParameterTenantId($data['tenant_id']));
        return $repository->save($parameter);
    }

    public function findById(string $id): Parameter
    {
        $repository = new ParameterRepository();
        return $repository->findById(new ParameterId($id));
    }

    public function json(array $consulta)
    {
        $repository = new ParameterRepository();
        return $repository->getAll($consulta);
    }
}
