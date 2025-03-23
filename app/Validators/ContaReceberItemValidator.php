<?php

namespace App\Validators;

use \App\Utilitarios;
use \App\ContaReceber;
use \App\ContaReceberItem;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\Helpers\ContaReceberCartao;
use \App\Helpers\ContaReceberCartaoHelper;
use \App\Pessoa;
use \App\Caixa;
use Illuminate\Support\Facades\Validator;
use \App\Exceptions\CobrancaReceberException;

class ContaReceberItemValidator
{


    public function validarBaixar(int $id, array $dados = [])
    {

        $erros = [];

        $id                     = $id ?? $dados['id'];
        $caixa_id               = $dados['caixa_id'] ?? 0;
        $dados['receber_id']     = $id;

        $errosEncontrados = $this->validaBaixaRequest($dados);
        if (is_array($errosEncontrados) && count($errosEncontrados) > 0) {
            $erros =  array_merge($errosEncontrados, $erros);
        }

        if (is_array($erros) && count($erros) > 0) {
            throw new CobrancaReceberException(implode('<br/>', $erros));
        }

        if ($id > 0) {
            $registro = ContaReceberItem::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if (! $registro) {
                throw new CobrancaReceberException('Caixa não identificao. Tente novamente ou entre em contato com o suporte.');
            } else {

                if (! ($registro->status == 'aberto')) {
                    $erros[] = "O contas a receber de código encontra-se \"{$registro->status}\" e não poderá ser baixado";
                }

                $objCobrancaReceber = $registro->contaReceber;
                if (! $objCobrancaReceber) {
                    throw new CobrancaReceberException('O cabeçalho do contas a receber não foi identificado. Tente novamente ou entre em contato com o suporte.');
                }

                $vrPagoToal = $objCobrancaReceber->vrPago + $registro->vrLiquido;
                $dif = $objCobrancaReceber->vrLiquido - $vrPagoToal;
                $difAbs = abs($dif);
                $difAbsFormat = number_format($difAbs, 2, ',', '.');

                if ($vrPagoToal > $objCobrancaReceber->vrLiquido) {
                    if ($difAbs > 0.02) {
                        $erros[] = "O saldo disónível para baixa é de apenas {$difAbsFormat}";
                    }
                }
            }
        }

        if ($caixa_id > 0) {
            $objCaixa = Caixa::where('active', '=', 'yes')
                ->where('id', '=', $caixa_id)->first();

            if (! $objCaixa) {
                throw new CobrancaReceberException('Caixa não identificao. Tente novamente ou entre em contato com o suporte.');
            }
        }

        return $erros;
    }

    protected function validaBaixaRequest(array $dados)
    {
        $errosEncontrados = [];

        $validator = Validator::make($dados, [
            'ds_observacao' => 'required|max:255|min:2',
            'caixa_id' => 'required|min:1',
            'receber_id' => 'required|min:1',
            'vr_pago'   => 'required',
        ], [
            'ds_observacao.required' => 'Informe uma obervação para o contas a receber.',
            'ds_observacao.max' => 'A obervação deve ter até :max caracteres.',
            'ds_observacao.min' => 'A obervação deve conter pelo menos :min caracteres.',
            'caixa_id.required' => 'Informe o código da caixa titular do conta a receber.',
            'caixa_id.min' => 'O código da caixa deve ter pelo menos  :min caracteres.',
            'receber_id.required' => 'Informe o código do contas a areceber.',
            'receber_id.min' => 'O código do contas a areceber deve ter pelo menos :min caracteres.',
            'vr_pago.required' => 'Informe o valor pago do contas a receber.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            $errosEncontrados[] = $msg;;
        }

        return $errosEncontrados;
    }
}
