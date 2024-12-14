<?php

namespace App\Application\Services\AccountReceivable;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\Application\Commands\AccountReceivableItem\CreateAccountReceivableItemCommand;
use App\Application\Handlers\AccountReceivable\CreateAccountReceivableHandler;
use App\Application\Handlers\AccountReceivable\GetAllAccountReceivableHandler;
use App\Application\Handlers\AccountReceivable\GetAccountReceivableByIdHandler;
use App\Application\Handlers\AccountReceivable\UpdateAccountReceivableHandler;
use App\Application\Handlers\AccountReceivableItem\CreateAccountReceivableItemHandler;
use App\ContaReceber;
use App\Domain\AccountReceivable\Entities\AccountReceivable;
use App\Exceptions\CobrancaReceberException;
use App\FormaPagamento;
use App\Helpers\ContaReceberItemHelper;
use App\Pessoa;
use App\Utilitarios;
use App\Validators\AccountReceivable\AccountReceivableValidator;
use Illuminate\Support\Collection;

class AccountReceivableApplicationService implements AccountReceivableApplicationServiceInterface
{
    private CreateAccountReceivableHandler $createAccountReceivableHandler;
    protected GetAllAccountReceivableHandler $getAllAccountReceivableHandler;
    protected UpdateAccountReceivableHandler $updateAccountReceivableHandler;
    protected GetAccountReceivableByIdHandler $getAccountReceivableByIdHandler;
    protected AccountReceivableValidator $accountReceivableValidator;
    private CreateAccountReceivableItemHandler $createAccountReceivableItemHandler;

    public function __construct(
        CreateAccountReceivableHandler $createAccountReceivableHandler,
        GetAllAccountReceivableHandler $getAllAccountReceivableHandler,
        UpdateAccountReceivableHandler $updateAccountReceivableHandler,
        GetAccountReceivableByIdHandler $getAccountReceivableByIdHandler,
        AccountReceivableValidator $accountReceivableValidator,
        CreateAccountReceivableItemHandler $createAccountReceivableItemHandler
    ) {
        $this->createAccountReceivableHandler = $createAccountReceivableHandler;
        $this->getAllAccountReceivableHandler = $getAllAccountReceivableHandler;
        $this->updateAccountReceivableHandler = $updateAccountReceivableHandler;
        $this->getAccountReceivableByIdHandler = $getAccountReceivableByIdHandler;
        $this->accountReceivableValidator = $accountReceivableValidator;
        $this->createAccountReceivableItemHandler = $createAccountReceivableItemHandler;
    }

    public function store(
        CreateAccountReceivableCommand $command
    ): ?Collection {

        $installMents = $this->generateInstallMents(
            $command->getDataProperties()
        );

        $createdRecords = collect();

        foreach ($installMents as $installMent) {
            $accountReceivable = $this->createAccountReceivableHandler->handler(
                CreateAccountReceivableCommand::build($installMent)
            );

            $createdRecords->push($accountReceivable);

            if ($accountReceivable->status != 'pago') {
                continue;
            }

            $accountReceivableItem = $this->createAccountReceivableItemHandler->handler(
                CreateAccountReceivableItemCommand::build($installMent)
            );

            if (!$accountReceivableItem) {
                throw new CobrancaReceberException('Não foi possível realizar a baixa do contas a receber vinculado ao cartão informado. Tente novamente ou entre em contato com o suporte.');
            }
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

    protected function generateInstallMents(array $data = []): array
    {
        $paymentMethodObject      = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $data['forma_pagamento_id'])->first();
        $paymentPlanObject      = $paymentMethodObject->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')->where('plano_pagamentos.id', '=', $data['plano_pagamento_id'])->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $data['plano_pagamento_id'])->first();
        $operatorFainantialObject  = $paymentMethodObject->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')->where('operador_financeiros.id', '=', $data['operador_financeiro_id'])->first();
        $objPessoa              = Pessoa::where('active', '=', 'yes')->where('id', '=', $data['pessoa_id'])->first();

        $accountReceivableValue   = Utilitarios::removeMaskMoney($data['vrBruto']);
        $erros = $this->accountReceivableValidator->validaGerCobranca($data['pessoa_id'], $accountReceivableValue, $data['forma_pagamento_id'], $data['plano_pagamento_id'], $data['operador_financeiro_id'], $data);

        if ((is_array($erros) && count($erros) > 0)) {
            throw new CobrancaReceberException(implode('<br/>', $erros));
        }

        $installMentsQuantity = $paymentPlanObject->qtdParcelas ?? 1;;
        $installMents = [];
        $quantityDaysGap   = $paymentPlanObject->qtdDiasIntervaloParcelas ?? 0;
        $quantityOfDaysFirstInstallMent  = $paymentPlanObject->qtd_dias_pri_parcela ?? 0;
        $installMentBaseValue = $accountReceivableValue / $installMentsQuantity;
        $installMentBaseValue = (float) $installMentBaseValue;

        $dueDateObject = new \DateTime();

        if ($quantityOfDaysFirstInstallMent > 0) {
            $dueDateObject->add(new \DateInterval('P' . $quantityOfDaysFirstInstallMent . 'D'));
        }

        $totalInstallmentsValue = 0;
        $defaultReferenceId = date('ymdhis');
        $defaultReference = 'sem_referencia';
        $status    = 'aberto';

        if (trim($paymentMethodObject->tipo) == 'cartao_credito' || trim($paymentMethodObject->tipo) == 'cartao_debito') {
            $installMentsQuantity = 0;

            if (isset($data['documento']) && strlen(trim($data['documento'])) >= 3) {
                $status    = 'pago';
            }
        }

        for ($i = 0; !($i == $installMentsQuantity); $i++) {
            $dueDate = $dueDateObject->format("Y-m-d H:i:s");
            $installMents[] = $this->accountReceivableParseData([
                'pessoa_id' => $objPessoa->id,
                'descricao' => $data['descricao'] ?? "Recita financeira",
                'documento' => $data['documento'] ?? null,
                'dtVencimentoOriginal' => $dueDate,
                'dtVencimento' => $dueDate,
                'vrBruto' => $installMentBaseValue,
                'vrLiquido' => $installMentBaseValue,
                'referencia_id' => $data['referencia_id'] ?? $defaultReferenceId,
                'referencia' => $data['referencia'] ?? $defaultReference,
                'filial_id' => $data['filial_id'] ?? null,
                'responsavel_id' => $data['responsavel_id'] ?? 0,
                'forma_pagamento_id' => $paymentMethodObject->id,
                'plano_pagamento_id' => $paymentPlanObject->id,
                'operador_financeiro_id' => $operatorFainantialObject->id ?? 0,
                'status' => $status,
            ]);

            if ($quantityDaysGap > 0) {
                $dueDateObject->add(new \DateInterval('P' . $quantityDaysGap . 'D'));
            }

            $totalInstallmentsValue += $installMentBaseValue;
        }

        $installMentsDiff    = $installMentBaseValue - $totalInstallmentsValue;
        $installMentsDiffAbs = abs($installMentsDiff);

        if ($installMentsDiffAbs > 0.02 && is_array($installMents) && count($installMents) > 0) {
            $installMents[0]['vrPago']      += 0;
            $installMents[0]['vrBruto']     += $installMentsDiff;
            $installMents[0]['vrLiquido']   += $installMentsDiff;
        }

        return $installMents;
    }

    public function payOff(array $data, int $id)
    {
        $id = $id ?? $data['id'];

        if ($id <= 0) {
            throw new CobrancaReceberException('Parâmetro ínválido');
        }

        $accountReceivableValue = $data['vr_final'] ?? 0;
        $accountReceivableValue   = Utilitarios::removeMaskMoney($accountReceivableValue);

        if (!($accountReceivableValue > 0)) {
            throw new CobrancaReceberException('O valor para baixa é inválido');
        }

        $registro = $this->findById(CreateAccountReceivableCommand::build(['id' => $id]));

        if (!$registro) {
            throw new CobrancaReceberException('Registro não identificado. Tentenovamente ou entre em contato com o suporte');
        }

        $installMent = $this->accountReceivableParseData([
            'pessoa_id' => $registro->pessoa->id,
            'descricao' => $data['descricao'] ?? "Recita financeira",
            'documento' => $data['documento'] ?? null,
            'dtVencimentoOriginal' => $registro->dtVencimentoOriginal,
            'dtVencimento' => $registro->dtVencimento,
            'vrBruto' => $accountReceivableValue,
            'vrLiquido' => $accountReceivableValue,
            'user_id' => \Auth::User()->id,
            'active' => 'yes',
            'importacao_dados' => 'no',
            'referencia_id' => $registro->referencia_id ?? date('ymdhis'),
            'referencia' => $registro->referencia ?? 'sem_referencia',
            'filial_id' => $registro->filial_id ?? null,
            'responsavel_id' => $registro->responsavel_id ?? 0,
            'qtd_parcelas' => 1,
            'nr_parcela' => 1,
            'forma_pagamento_id' => $registro->formaPagamento->id,
            'plano_pagamento_id' => $registro->planoPagamento->id,
            'operador_financeiro_id' => $registro->operadorFinanceiro->id ?? 0,
            'status' => 'aberto',

        ]);

        $accountReceivableItem = $this->createAccountReceivableItemHandler->handler(
            CreateAccountReceivableItemCommand::build($installMent)
        );

        if (!$accountReceivableItem) {
            throw new CobrancaReceberException('Não foi possível realizar a baixa do contas a receber vinculado ao cartão informado. Tente novamente ou entre em contato com o suporte.');
        }

        $dataResponse = $accountReceivableItem;

        if (!(is_array($dataResponse) && count($dataResponse) > 0)) {
            throw new CobrancaReceberException('Não foi possível concluir a operação. Tentenovamente ou entre em contato com o suporte');
        }

        $dataItens = $dataResponse['data_cob_receber_item'] ?? [];

        if (!(is_array($dataItens) && count($dataItens) > 0)) {
            throw new CobrancaReceberException('Não foi possível concluir a operação. Tentenovamente ou entre em contato com o suporte');
        }

        foreach ($dataItens as $key => $contaRecebrItem) {
            if (!($contaRecebrItem)) {
                throw new CobrancaReceberException('Não foi possível concluir a operação. Tentenovamente ou entre em contato com o suporte');
            }
            $objCobReceberItemHelp = new ContaReceberItemHelper();
            $objCobReceberItemHelp->baixar($data, $contaRecebrItem->id);
        }

        return $registro;
    }
}
