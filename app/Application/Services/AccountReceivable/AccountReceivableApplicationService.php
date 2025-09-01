<?php

namespace App\Application\Services\AccountReceivable;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\Application\Commands\AccountReceivableItem\CreateAccountReceivableItemCommand;
use App\Application\Handlers\AccountReceivable\CreateAccountReceivableHandler;
use App\Application\Handlers\AccountReceivable\GetAllAccountReceivableHandler;
use App\Application\Handlers\AccountReceivable\GetAccountReceivableByIdHandler;
use App\Application\Handlers\AccountReceivable\UpdateAccountReceivableHandler;
use App\Application\Handlers\AccountReceivableItem\CreateAccountReceivableItemHandler;
use App\Classes\ApiResponseClass;
use App\ContaReceber;
use App\Domain\AccountReceivable\Entities\AccountReceivable;
use App\Exceptions\CobrancaReceberException;
use App\FormaPagamento;
use App\Helpers\ContaReceberHelper;
use App\Helpers\ContaReceberItemHelper;
use App\Pessoa;
use App\Utilitarios;
use App\Validators\AccountReceivable\AccountReceivableValidator;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AccountReceivableApplicationService implements AccountReceivableApplicationServiceInterface
{
    private CreateAccountReceivableHandler $createAccountReceivableHandler;
    protected GetAllAccountReceivableHandler $getAllAccountReceivableHandler;
    protected UpdateAccountReceivableHandler $updateAccountReceivableHandler;
    protected GetAccountReceivableByIdHandler $getAccountReceivableByIdHandler;
    protected AccountReceivableValidator $accountReceivableValidator;
    private CreateAccountReceivableItemHandler $createAccountReceivableItemHandler;
    private ContaReceberHelper $accountReceivableHelper;
    private ContaReceberItemHelper $accountReceivableItemHelper;

    public function __construct(
        CreateAccountReceivableHandler $createAccountReceivableHandler,
        GetAllAccountReceivableHandler $getAllAccountReceivableHandler,
        UpdateAccountReceivableHandler $updateAccountReceivableHandler,
        GetAccountReceivableByIdHandler $getAccountReceivableByIdHandler,
        AccountReceivableValidator $accountReceivableValidator,
        CreateAccountReceivableItemHandler $createAccountReceivableItemHandler,
        ContaReceberHelper $accountReceivableHelper,
        ContaReceberItemHelper $accountReceivableItemHelper
    ) {
        $this->createAccountReceivableHandler = $createAccountReceivableHandler;
        $this->getAllAccountReceivableHandler = $getAllAccountReceivableHandler;
        $this->updateAccountReceivableHandler = $updateAccountReceivableHandler;
        $this->getAccountReceivableByIdHandler = $getAccountReceivableByIdHandler;
        $this->accountReceivableValidator = $accountReceivableValidator;
        $this->createAccountReceivableItemHandler = $createAccountReceivableItemHandler;
        $this->accountReceivableHelper = $accountReceivableHelper;
        $this->accountReceivableItemHelper = $accountReceivableItemHelper;
    }

    public function store(
        CreateAccountReceivableCommand $command
    ): ?Collection {
        $propertiesData = $command->getDataProperties();

        $result = $this->accountReceivableHelper->gerarCobranca(
            (int)$propertiesData['personId'],
            (float) $propertiesData['grossValue'],
            (int) $propertiesData['paymentMethodId'],
            (int) $propertiesData['paymentPlanId'],
            isset($propertiesData['financialOperatorId']) ? (int) $propertiesData['financialOperatorId'] : null,
            $propertiesData
        );

        $resultAccountReceivable = $result['data_cob_receber'] ?? [];
        $createdRecords = collect();

        foreach ($resultAccountReceivable as $accountReceivable) {
            $createdRecords->push($accountReceivable);
        }

        return $createdRecords;
    }

    public function update(
        CreateAccountReceivableCommand $command
    ): void {
        $this->updateAccountReceivableHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllAccountReceivableHandler->handler($data);
    }

    public function findById(
        CreateAccountReceivableCommand $command
    ): ?ContaReceber {
        return $this->getAccountReceivableByIdHandler->handler($command);
    }

    protected function accountReceivableParseData(array $data)
    {
        return [
            'pessoa_id' => $data['pessoa_id'] ?? null,
            'descricao' => $data['descricao'] ?? "Recita financeira",
            'documento' => $data['documento'] ?? null,
            'dtVencimentoOriginal' => $data['dtVencimentoOriginal'],
            'dtVencimento' => $data['dtVencimento'] ?? null,
            'vrPago' => $data['vrPago'] ?? 0,
            'vrBruto' => $data['vrBruto'] ?? 0,
            'vrLiquido' => $data['vrLiquido'] ?? 0,
            'vrDevolvido' => $data['vrDevolvido'] ?? 0,
            'vrTaxa' => $data['vrTaxa'] ?? 0,
            'vrDesconto' => $data['vrDesconto'] ?? 0,
            'vrJuros' => $data['vrJuros'] ?? 0,
            'importacao_dados' => $data['importacao_dados'] ?? 'no',
            'referencia_id' => $data['referencia_id'] ?? null,
            'referencia' => $data['referencia'] ?? null,
            'filial_id' => $data['filial_id'] ?? null,
            'responsavel_id' => $data['responsavel_id'] ?? 0,
            'forma_pagamento_id' => $data['forma_pagamento_id'] ?? null,
            'plano_pagamento_id' => $data['plano_pagamento_id'] ?? null,
            'operador_financeiro_id' => $data['operador_financeiro_id'] ?? null,
            'status' => $data['status'] ?? 'aberto',
        ];
    }

    public function payOff(CreateAccountReceivableCommand $command, array $data = []): ?ContaReceber
    {
        $dataCommand = $command->getDataProperties();
        $newData = array_merge($dataCommand, $data);
        return $this->accountReceivableHelper->baixar($newData, $newData['id']);
    }
}
