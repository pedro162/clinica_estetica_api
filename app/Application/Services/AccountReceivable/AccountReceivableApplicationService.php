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
        try {

            \DB::beginTransaction();
            $propertiesData = $command->getDataProperties();

            $result = $this->accountReceivableHelper->gerarCobranca(
                (int)$propertiesData['personId'],
                (float) $propertiesData['grossValue'],
                (int) $propertiesData['paymentMethodId'],
                (int) $propertiesData['paymentPlanId'],
                (int) $propertiesData['financialOperatorId'],
                $propertiesData
            );

            $resultAccountReceivable = $result['data_cob_receber'] ?? [];
            $createdRecords = collect();

            foreach ($resultAccountReceivable as $accountReceivable) {
                $createdRecords->push($accountReceivable);
            }

            \DB::commit();

            return $createdRecords;
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            \DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    public function update(
        CreateAccountReceivableCommand $command
    ): void {
        try {

            \DB::beginTransaction();
            $this->updateAccountReceivableHandler->handler($command);
            \DB::commit();
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            \DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAll(array $data = []): ?Collection
    {
        try {

            \DB::beginTransaction();
            $result = $this->getAllAccountReceivableHandler->handler($data);
            \DB::commit();

            return $result;
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            \DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function findById(
        CreateAccountReceivableCommand $command
    ): ?ContaReceber {
        try {
            \DB::beginTransaction();
            $result = $this->getAccountReceivableByIdHandler->handler($command);
            \DB::commit();

            return $result;
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            \DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
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
        try {
            \DB::beginTransaction();
            $dataCommand = $command->getDataProperties();
            $newData = array_merge($dataCommand, $data);
            $result = $this->accountReceivableHelper->baixar($newData, $newData['id']);
            \DB::commit();

            return $result;
        } catch (CobrancaReceberException $e) {
            \DB::rollback();
            Log::info("It was no possible to pay off the account receivable: ", [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'code' => $e->getCode(),
            ]);
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            \DB::rollback();
            Log::info("It was no possible to pay off the account receivable: ", [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'code' => $e->getCode(),
            ]);
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
