<?php

namespace App\Helpers;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\Application\Commands\AccountReceivableItem\CreateAccountReceivableItemCommand;
use App\Application\Handlers\AccountReceivable\GetAccountReceivableByIdHandler;
use App\Application\Handlers\AccountReceivable\GetAllAccountReceivableHandler;
use App\Application\Handlers\AccountReceivable\UpdateAccountReceivableHandler;
use App\Application\Handlers\AccountReceivableItem\CreateAccountReceivableItemHandler;
use App\Application\Handlers\AccountReceivableItem\GetAccountReceivableItemByIdHandler;
use App\Application\Handlers\AccountReceivableItem\GetAllAccountReceivableItemHandler;
use App\Application\Handlers\AccountReceivableItem\UpdateAccountReceivableItemHandler;
use \App\Utilitarios;
use \App\ContaReceber;
use \App\ContaReceberItem;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\Helpers\ContaReceberCartao;
use \App\Helpers\ContaReceberCartaoHelper;
use \App\Helpers\FinanceiroMovimentacoeHelper;
use \App\Validators\CaixaValidator;
use \App\Validators\ContaReceberItemValidator;
use \App\Pessoa;
use \App\Caixa;
use \App\Exceptions\CobrancaReceberException;
use App\Validators\AccountReceivable\AccountReceivableValidator;
use App\Domain\AccountReceivable\Repositories\AccountReceivableRepositoryInterface;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableId;
use App\Domain\Cashier\Repositories\CashierRepositoryInterface;
use App\Domain\Cashier\ValueObjects\CashierId;
use Exception;

class ContaReceberItemHelper
{
    protected GetAllAccountReceivableHandler $getAllAccountReceivableHandler;
    protected GetAllAccountReceivableItemHandler $getAllAccountReceivableItemHandler;
    protected UpdateAccountReceivableHandler $updateAccountReceivableHandler;
    protected UpdateAccountReceivableItemHandler $updateAccountReceivableItemHandler;
    protected GetAccountReceivableByIdHandler $getAccountReceivableByIdHandler;
    protected GetAccountReceivableItemByIdHandler $getAccountReceivableItemByIdHandler;
    protected AccountReceivableValidator $accountReceivableValidator;
    protected CreateAccountReceivableItemHandler $createAccountReceivableItemHandler;
    private AccountReceivableRepositoryInterface $repository;
    private CashierRepositoryInterface $cashierRepository;

    public function __construct(
        GetAllAccountReceivableHandler $getAllAccountReceivableHandler,
        GetAllAccountReceivableItemHandler $getAllAccountReceivableItemHandler,
        UpdateAccountReceivableItemHandler $updateAccountReceivableItemHandler,
        GetAccountReceivableItemByIdHandler $getAccountReceivableItemByIdHandler,
        GetAccountReceivableByIdHandler $getAccountReceivableByIdHandler,
        CreateAccountReceivableItemHandler $createAccountReceivableItemHandler,
        UpdateAccountReceivableHandler $updateAccountReceivableHandler,
        AccountReceivableRepositoryInterface $repository,
        CashierRepositoryInterface $cashierRepository
    ) {
        $this->getAllAccountReceivableItemHandler = $getAllAccountReceivableItemHandler;
        $this->getAllAccountReceivableHandler = $getAllAccountReceivableHandler;
        $this->updateAccountReceivableHandler = $updateAccountReceivableHandler;
        $this->updateAccountReceivableItemHandler = $updateAccountReceivableItemHandler;
        $this->getAccountReceivableByIdHandler = $getAccountReceivableByIdHandler;
        $this->getAccountReceivableItemByIdHandler = $getAccountReceivableItemByIdHandler;
        $this->createAccountReceivableItemHandler = $createAccountReceivableItemHandler;
        $this->repository = $repository;
        $this->cashierRepository = $cashierRepository;
    }

    public function validaGerCobrancaItem(ContaReceber $accountReceivableObject, float $billingAmount, int $paymentMethodId, int $paymentPlanId, $financialOperatorId = null, array $data = []): array
    {
        $erros = [];

        $paymentMethodObject = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $paymentMethodId)->first();
        $planOfPaymentObject = $paymentMethodObject->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')->where('plano_pagamentos.id', '=', $paymentPlanId)->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $paymentPlanId)->first();
        $financialOperatorObject = $paymentMethodObject->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')->where('operador_financeiros.id', '=', $financialOperatorId)->first();
        $personObject = $accountReceivableObject->pessoa;
        $openNettAmoun = $this->repository->sumOpenNetAmounts(new AccountReceivableId((string) $accountReceivableObject->id));

        $interestValue = (float)Utilitarios::removeMaskMoney($data['vrJuros'] ?? 0);
        $feeValue = (float)Utilitarios::removeMaskMoney($data['vrTaxa'] ?? 0);
        $discountValue = (float)Utilitarios::removeMaskMoney($data['vrDesconto'] ?? 0);

        $interestValue = $interestValue  >= 0 ? $interestValue : 0;
        $feeValue = $feeValue  >= 0 ? $feeValue : 0;
        $discountValue = $discountValue  >= 0 ? $discountValue : 0;
        $billingBalance = $accountReceivableObject->vrLiquido - (abs($accountReceivableObject->vrPago) + abs($openNettAmoun));

        $billingAmount = $billingAmount - ($interestValue + $feeValue);

        $balanceDifference =  $billingBalance - $billingAmount;
        $balanceDifferenceAbs = abs($balanceDifference);
        $balanceDifferenceFormat = number_format($billingBalance, 2, ',', '.');

        if ($billingBalance <= 0) {
            $erros[] = 'Não há mais saldo para novas cobrança.';
        }

        if (! ($billingBalance >= $billingAmount)) {
            if ($balanceDifferenceAbs > 0.02) {
                $erros[] = 'O saldo para novas cobranças é de ' . $balanceDifferenceFormat . ' .';
            }
        }

        if (! $personObject) {
            $erros[] = 'A pessoa de código nº ' . $accountReceivableObject->pessoa_id . ' não foi identificada.';
        }

        if (! $paymentMethodObject) {
            $erros[] = 'A forma de pagamento de código nº ' . $paymentMethodId . ' não foi identificada.';
        }

        if (! $planOfPaymentObject) {
            $erros[] = 'O plano de pagamento de código nº ' . $paymentPlanId . ' não foi identificado.';
        }

        if (!$financialOperatorObject) {
            if ($paymentMethodObject->hasOperadorFinanceiro == 'yes') {
                $erros[] = 'O operador financeiro de código nº ' . $financialOperatorId . ' não foi identificado.';
            }
        }

        if (!$billingAmount) {
            $erros[] = 'O valor da cobrança informado é inválido.';
        }

        return $erros;
    }

    public function gerarCobrancaItem(ContaReceber $accountReceivableObject, float $billingAmount, int $paymentMethodId, int $paymentPlanId, $financialOperatorId = null, array $data = [])
    {
        $paymentMethodObject      = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $paymentMethodId)->first();
        $planOfPaymentObject      = $paymentMethodObject->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')->where('plano_pagamentos.id', '=', $paymentPlanId)->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $paymentPlanId)->first();
        $financialOperatorObject  = $paymentMethodObject->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')->where('operador_financeiros.id', '=', $financialOperatorId)->first();
        $personObject              = $accountReceivableObject->pessoa;

        $interestValue = (float)Utilitarios::removeMaskMoney($data['vrJuros'] ?? 0);
        $feeValue = (float)Utilitarios::removeMaskMoney($data['vrTaxa'] ?? 0);
        $discountValue = (float)Utilitarios::removeMaskMoney($data['vrDesconto'] ?? 0);

        $erros = $this->validaGerCobrancaItem($accountReceivableObject, $billingAmount, $paymentMethodId, $paymentPlanId, $financialOperatorId, $data);

        if ((is_array($erros) && count($erros) > 0)) {
            throw new CobrancaReceberException(implode('<br/>', $erros));
        }

        $installmentCount = $data['qtdParcelas'] ?? $planOfPaymentObject->qtdParcelas ?? 1;;
        $installmentListData = [];
        $intervalDays = $planOfPaymentObject->qtdDiasIntervaloParcelas ?? 0;
        $daysUntilFirstInstallment = $planOfPaymentObject->qtd_dias_pri_parcela ?? 0;
        $installmentBaseAmount = $billingAmount / $installmentCount;
        $installmentBaseAmount = (float) $installmentBaseAmount;

        $interestBaseAmount = $interestValue / $installmentCount;
        $interestBaseAmount = (float) $interestBaseAmount;

        $feeBaseAmount = $feeValue / $installmentCount;
        $feeBaseAmount = (float) $feeBaseAmount;

        $discountBaseAmount = $discountValue / $installmentCount;
        $discountBaseAmount = (float) $discountBaseAmount;


        $objDtVencimento = new \DateTime();

        if ($daysUntilFirstInstallment > 0) {
            $objDtVencimento->add(new \DateInterval('P' . $daysUntilFirstInstallment . 'D'));
        }

        $totalGeneratedInstallments = 0;
        $totalGeneratedFee = 0;
        $totalGeneratedDiscount = 0;
        $totalGeneratedInterest = 0;
        $paymentDate        = null;
        $settlementDate     = null;
        $amountPaid         = 0;
        $amountFee          = 0;
        $amountDiscount     = 0;
        $amountInterest     = 0;
        $settlementType     = 'user';
        $billingStatus      = 'aberto'; //aberto
        $settlementHash     = null;
        $cashRegisterId     = null;
        $isCreditCardPayment = false;

        if (trim($paymentMethodObject->tipo) == 'cartao_credito' || trim($paymentMethodObject->tipo) == 'cartao_debito') {
            if (isset($data['documento']) && strlen(trim($data['documento'])) >= 3) {
                $billingStatus = 'pago';
            }
        }

        if (trim($paymentMethodObject->tipo) == 'cartao_credito' || trim($paymentMethodObject->tipo) == 'cartao_debito') {
            $isCreditCardPayment = true;
        }

        for ($i = 0; !($i == $installmentCount); $i++) {

            if ($billingStatus == 'pago') {
                $paymentDate    = date('Y-m-d H:i:s');
                $settlementDate = date('Y-m-d H:i:s');
                $randId         = rand(111111111, 999999999);
                $amountPaid     = $installmentBaseAmount;
                $settlementHash = ($i + 1) . '' . $personObject->id . '' . $randId . '' . date('ymdhis');
                $cashRegisterId = null;
            }

            $dtVencimento = $objDtVencimento->format("Y-m-d H:i:s");

            //--- Preparo os dados para salvar -----------------------------------
            $installmentData = [
                'documento' => $data['documento'] ?? null,
                'dtPagamento' => $paymentDate,
                'dtBaixa' => $settlementDate,
                'descricao' => $data['descricao'] ?? "Baixa contas a receber códigonº {$accountReceivableObject->id}",
                'vrBruto' => $installmentBaseAmount,
                'vrLiquido' => $installmentBaseAmount,
                'vrPago' => $amountPaid,
                'vrTaxa' => $feeBaseAmount ?? null,
                'vrDesconto' => $discountBaseAmount ?? null,
                'vrJuros' => $interestBaseAmount ?? null,
                'status' => $billingStatus,
                'forma_pagamentos_id' => $paymentMethodObject->id,
                'plano_pagamento_id' => $planOfPaymentObject->id,
                'operador_financeiro_id' => $financialOperatorObject->id ?? 0,
                'conta_receber_id' => $accountReceivableObject->id,
                'caixa_id' => $cashRegisterId,
                'tpBaixa' => $settlementType,
                'rashBaixa' => $settlementHash,
                'bandeira_cartao_id' => $data['bandeira_cartao_id'] ?? null,
                'is_cartao' => $isCreditCardPayment,
            ];

            $installmentListData[] = $installmentData;

            if ($intervalDays > 0) {
                $objDtVencimento->add(new \DateInterval('P' . $intervalDays . 'D'));
            }

            $totalGeneratedInstallments += $installmentBaseAmount;
            $totalGeneratedFee += $amountFee;
            $totalGeneratedDiscount += $amountDiscount;
            $totalGeneratedInterest += $amountInterest;
        }

        $difParcelas    = $billingAmount - $totalGeneratedInstallments;
        $difParcelasAbs = abs($difParcelas);

        $difInterest    = $totalGeneratedInterest <= 0 ? 0 : $interestValue - $totalGeneratedInterest;
        $difInterestAbs = abs($difInterest);

        $difFeeValue    = $totalGeneratedFee <= 0 ? 0 : $feeValue - $totalGeneratedFee;
        $difFeeValueAbs = abs($difFeeValue);

        $difDiscountValue    = $totalGeneratedDiscount <= 0 ? 0 : $discountValue - $totalGeneratedDiscount;
        $difDiscountValueAbs = abs($difDiscountValue);

        //-- Tento jogar a diferença das parcela na primeira parcela
        if ($difParcelasAbs > 0.02 && is_array($installmentListData) && count($installmentListData) > 0) {
            $installmentListData[0]['vrPago']      += 0;
            $installmentListData[0]['vrBruto']     += $difParcelas;
            $installmentListData[0]['vrLiquido']   += $difParcelas;
            $installmentListData[0]['vrTaxa']      += $difFeeValueAbs;
            $installmentListData[0]['vrDesconto']  += $difDiscountValueAbs;
            $installmentListData[0]['vrJuros']   += $difInterestAbs;
        }

        $datacobReceberObjArr = [
            'data_cob_receber_item' => [],
            'data_cob_receber_cartoes' => [],
            'data_cob_receber_boletos' => [],
        ];

        $totalValuePayed = 0;

        if (is_array($installmentListData) && count($installmentListData) > 0) {

            foreach ($installmentListData as $key => $val) {
                $accountReceivableItem = $this->createAccountReceivableItemHandler->handler(
                    CreateAccountReceivableItemCommand::build($val)
                );

                if (! $accountReceivableItem) {
                    throw new CobrancaReceberException('Não foi possível gerar os contas a receber.Tente novamente ou entre em contato com o suporte.');
                }

                if ($billingStatus == 'pago') {
                    $totalValuePayed += $accountReceivableItem->vrPago;
                }

                if (!empty($val['is_cartao']) && $val['is_cartao']) {

                    $objCobCartHelper   = app(ContaReceberCartaoHelper::class);
                    $idBandeira         = $data['bandeira_cartao_id'] ?? 1; //Gravar a bandeira do cartão na tabela de cobranças
                    $dataCartoes        = $objCobCartHelper->gerarCarteiraCartao(
                        $accountReceivableItem->id,
                        $idBandeira,
                        [
                            'status' => 'aberto',
                            'nr_doc' => $installmentData['nr_doc'] ?? $installmentData['documento']
                        ]
                    );

                    if (! $dataCartoes) {
                        throw new CobrancaReceberException('Não foi possível gerar a carteira de cartões.Tente novamente ou entre em contato com o suporte.');
                    }

                    $datacobReceberObjArr['data_cob_receber_cartoes'][] = $dataCartoes;
                }

                $datacobReceberObjArr['data_cob_receber_item'][] = $accountReceivableItem;
            }
        } else {
            throw new CobrancaReceberException('Não foi possível identificar quantas parcelas deveriam ser geradas. Tente novamente ou entre em contato com o suporte.');
        }

        return $datacobReceberObjArr;
    }

    public function baixar(array $data, int $id)
    {
        $erros = [];

        $id = $id ?? $data['id'];
        $cashierRegisterId  = $data['caixa_id'] ?? 0;

        if ($id <= 0) {
            throw new CobrancaReceberException('Parâmetro ínválido');
        }

        if (! ($cashierRegisterId > 0)) {
            throw new CobrancaReceberException('Parâmetro ínválido para o caixa de baixa');
        }

        $cashierRegisterValidator  = new CaixaValidator();
        $errosEncontrados = $cashierRegisterValidator->validarCaixaBaixar($cashierRegisterId, $data);

        if (is_array($errosEncontrados) && count($errosEncontrados) > 0) {
            $erros = array_merge($erros, $errosEncontrados);
        }

        $objContaReceberItemValidator   = new ContaReceberItemValidator();
        $errosEncontrados               = $objContaReceberItemValidator->validarBaixar($id, $data);

        if (is_array($errosEncontrados) && count($errosEncontrados) > 0) {
            $erros = array_merge($erros, $erros);
        }

        if (is_array($erros) && count($erros) > 0) {
            throw new CobrancaReceberException(implode('<br/>', $erros));
        }

        $cashierRegister = $this->cashierRepository->findById(new CashierId((string) $cashierRegisterId));

        if (! $cashierRegister) {
            throw new CobrancaReceberException('Caixa não identificao. Tente novamente ou entre em contato com o suporte.');
        }

        $registro = $this->getAccountReceivableItemByIdHandler->handler(CreateAccountReceivableItemCommand::build(['id' => $id]));

        if (! $registro) {
            throw new CobrancaReceberException('Contas a receber não identificado. Tente novamente ou entre em contato com o suporte.');
        }

        $objCobrancaReceber = $registro->contaReceber;

        if (! $objCobrancaReceber) {
            throw new CobrancaReceberException('O cabeçalho do contas a receber não foi identificado. Tente novamente ou entre em contato com o suporte.');
        }

        //--------------------- Gerar movimentação de caixa ----------------------------------------
        $objMovimentacaoHelper = new FinanceiroMovimentacoeHelper();

        $dataRequest = [];
        $dataRequest['referencia']         = 'conta_recebers';
        $dataRequest['referencia_id']      = $registro->conta_receber_id;
        $dataRequest['sub_referencia']     = 'conta_receber_items';
        $dataRequest['sub_referencia_id']  = $registro->id;
        $dataRequest['historico']          = 'Baixa parcial contas a receber código nº ' . $registro->conta_receber_id . ' - Cliente: ' . $objCobrancaReceber->pessoa->name;
        $dataRequest['caixa_id']           = $cashierRegister->id;
        $dataRequest['vr_movimentacao']    = $registro->vrLiquido;
        $dataRequest['conciliado']         = 'no';
        $dataRequest['estornado']          = 'no';
        $dataRequest['hash_operacao']      = null;

        $registroMovimentacao = $objMovimentacaoHelper->store($dataRequest);

        if (! $registroMovimentacao) {
            throw new CobrancaReceberException('Não foi possível gerar movimentação de caixa. Tente novamente ou entre em contato com o suporte.');
        }

        //--------------------- Marcar o contas a receber como pago ----------------------------------------
        $dataRequest = [];
        $dataRequest['status']         = 'pago';
        $dataRequest['vrPago']         = $registro->vrLiquido;
        $dataRequest['user_update_id'] = \Auth::User()->id;
        $dataRequest['id'] = $registro->id;

        $registro->status = "pago";
        $registro->user_update_id = \Auth::User()->id;
        $registro->vrPago = $registro->vrLiquido;

        $this->updateAccountReceivableItemHandler->handler(
            CreateAccountReceivableItemCommand::build($dataRequest)
        );

        //---Atualizo o cabeçalho-------------------------
        $dataRequestBKP = $dataRequest;
        $amountPaidToal = $objCobrancaReceber->vrPago + $dataRequestBKP['vrPago'];
        $dataRequest = [
            'vrPago' => $amountPaidToal,
            'vrTaxa' => $objCobrancaReceber->vrTaxa + $registro->vrTaxa,
            'vrDesconto' => $objCobrancaReceber->vrDesconto + $registro->vrDesconto,
            'vrJuros' => $objCobrancaReceber->vrJuros + $registro->vrJuros,
            'id' => $objCobrancaReceber->id
        ];

        if ($dataRequest['vrPago'] >= $objCobrancaReceber->vrLiquido) {
            $dataRequest['status'] = 'pago';
        }

        $this->updateAccountReceivableHandler->handler(
            CreateAccountReceivableCommand::build($dataRequest)
        );

        if (! $objCobrancaReceber) {
            throw new CobrancaReceberException('Não foi possível atualizar o valor pago do contas a receber. Tente novamente ou entre em contato com o suporte.');
        }

        return $registro;
    }
}
