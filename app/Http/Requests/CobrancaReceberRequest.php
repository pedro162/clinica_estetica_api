<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CobrancaReceberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vrCobrancaReceber'                     => 'required',
            'dsHistorico'                           => 'required|max:255',
            'idCobrancaTipo'                        => 'required|numeric|min:1',
            'Financeiro_PlanosDePagamentos_id'      => 'required|numeric|min:1',
            'Financeiro_OperadoresFinanceiros_id'   => 'required|numeric|min:1',
            'idReferencia'                          => 'required|numeric|min:1',
            'tpReferencia'                          => 'required|max:255',
            //'nrDoc'                                 => 'required',
            //'dsArquivo'                             => 'required',
            'dtCompetencia'                         => 'required|date',
            'naoGeraContraPartida'                  => 'required|boolean',
            //'idPlanoDeContasSubconta'               => 'required|numeric|min:1',
            'pessoa_id'                              => 'required|numeric|min:1',
            'filial_id'                             => 'required|numeric|min:1',
            'idPessoaRca'                           => 'required|numeric|min:1'
        ];
    }
}
