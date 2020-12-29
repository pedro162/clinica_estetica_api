<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Pessoa;
use \Illuminate\Support\Facades\Validator;

class CobrancaReceber extends Model
{
    protected $fillable = [
    	'idReferencia',
		'tpReferencia',
		'pessoa_id',
		'nrDuplicata',
		'dtCobrancaReceber',
		'dtCompetencia',
		'dtVencimentoCobrancaReceber',
		'tpLancamento',
		'dsHistorico',
		'vrBruto',
		'vrDesconto',
		'vrCobrancaReceber',
		'vrTaxas',
		'nrCodigoDeBarras',
		'nrNotaDevolucao',
		'vrDevolucao',
		'vrDescontoFinanceiro',
		'qtdProrrogacao',
		'statusCobranca',
		'isEstornado',
		'idFuncionarioEstorno',
		'dsMotivoEstorno',
		'idDesdobramentoReceber',
		'dtDesdobramento',
		'idFuncionarioDesdobramento',
		'idPessoaBaixa',
		'dtCobrancaReceberBaixa',
		'idReferenciaPrincipal',
		'tpReferenciaPrincipal',
		'nrParcela',
		'vrJuros',
		'vrJurosDispensados',
		'vrJurosProrrogacao',
		'vrTaxaJuros',
		'vrMulta',
		'vrMultaDispensada',
		'vrAcrescimos',
		'vrCreditoCliente',
		'vrPago',
		'vrIof',
		'dtCobrancaReceberRecebimento',
		'nrDocumento',
		'isEstornavel',
		'dsObservacoesBaixa',
		'dtSistemaBaixa',
		'idPessoaCustodia',
		'idPessoaCustodiaOrigem',
		'cascade',
		'statusCustodia',
		'dtCustodia',
		'dtProtesto',
		'isDuplicataOriginal',
		'user_id',
		'user_update_id',
		'pl_pgto_id',
		'op_finan_id',
		'pessoa_rca_id',
		'active',
		'filial_id',
		'statusTransito',
    ];


    public function pessoa()
    {
    	return $this->hasOne(Pessoa::class, 'id', 'pessoa_id');
    }


    public static function saveContasReceber(Array $params)
    {
    	if(count($params) == 0){
    		return false;
    	}


    	$resultSatinizar = self::requestProdutoReceber($params);
    	
    	if($resultSatinizar->fails()){
        	 throw new \Exception('Alguns dados iformados são inválidos.');
        }
			
		$paramsToCommit =
        [
            'vrCobrancaReceber'         => $params['vrCobrancaReceber'],
            'vrBruto'         			=> $params['vrBruto'],
            'dsHistorico'               => $params['dsHistorico'],
            'idCobrancaTipo'            => $params['idCobrancaTipo'],
            'pl_pgto_id'   				=> $params['pl_pgto_id'],
            'op_finan_id'				=> $params['op_finan_id'],
            'idReferencia'              => $params['idReferencia'],
            'tpReferencia'              => $params['tpReferencia'],
            //'nrDoc'                   => $params['nrDoc'],
            //'dsArquivo'               => $params['dsArquivo'],
            'dtCompetencia'             => $params['dtCompetencia'],
            'naoGeraContraPartida'      => $params['naoGeraContraPartida'],
            //'idPlanoDeContasSubconta' => $params['idPlanoDeContasSubconta'],
            'pessoa_id'                 => $params['pessoa_id'],
            'filial_id'                 => $params['filial_id'],
            'idFuncionarioEstorno'      => $params['idFuncionarioEstorno'] ?? null,
            'idFuncionarioDesdobramento'=> $params['idFuncionarioDesdobramento'] ?? null,
            'idPessoaBaixa'				=> $params['idPessoaBaixa'] ?? null,
            'pessoa_rca_id'             => $params['pessoa_rca_id'] ?? null,
            'idPessoaCustodia'          => $params['idPessoaCustodia'] ?? null,
            'idPessoaCustodiaOrigem'    => $params['idPessoaCustodiaOrigem'] ?? null,
            'user_id'    				=> $params['user_id'],
            'active'    				=> $params['active'],
        ];

        return self::create($paramsToCommit);
	}


	public static function requestProdutoReceber($request)
    {
        $validador = Validator::make($request,[
            'vrCobrancaReceber'				=>'required|numeric|min:0.001',
			'vrBruto'						=>'required|numeric|min:0.001',
			'idCobrancaTipo'				=>'required|numeric|min:1',
			'pl_pgto_id'					=>'required|numeric|min:1',
			'op_finan_id'					=>'required|numeric|min:1',
			'idReferencia'					=>'required|numeric|min:1',
			'tpReferencia'					=>'required|string|min:0|max:255',
			'dtCompetencia'					=>'required|date',
			'naoGeraContraPartida'			=>'required|boolean',
			'pessoa_id'						=>'required|numeric|min:1',
			'filial_id'						=>'required|numeric|min:1',
			'idFuncionarioEstorno'			=>'numeric|min:1|nullable',
			'idFuncionarioDesdobramento'	=>'numeric|min:1|nullable',
			'idPessoaBaixa'					=>'numeric|min:1|nullable',
			'pessoa_rca_id'					=>'numeric|min:1|nullable',
			'idPessoaCustodia'				=>'numeric|min:1|nullable',
			'idPessoaCustodiaOrigem'		=>'numeric|min:1|nullable',
			'user_id'						=>'required|numeric|min:1',
			'active'           				=>'required|string|max:255',

        ]);

        return $validador;
    }
}
