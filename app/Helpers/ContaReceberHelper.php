<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Utilitarios;
use \App\ContaReceber;
use \App\ContaReceber as CobrancaReceber;
use \App\ContaReceberItem;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\ContaReceberCartao;
use \App\Helpers\ContaReceberCartaoHelper;
use \App\Helpers\ContaReceberItemHelper;
use \App\Pessoa;
use \App\Exceptions\CobrancaReceberException;

class ContaReceberHelper
{

    public function validaGerCobranca(int $idPessoa, float $vrCobranca, int $idFormaPagamento, int $idPlanoPagamento, $idOperadorFinanceiro = null, array $dados = []): array
    {
        $erros = [];

        $objFormaPagamento      = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $idFormaPagamento)->first();
        $objPlanoPagamento      = $objFormaPagamento->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')->where('plano_pagamentos.id', '=', $idPlanoPagamento)->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objOperadorFinanceiro  = $objFormaPagamento->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')->where('operador_financeiros.id', '=', $idOperadorFinanceiro)->first();
        //$objPrazo               = $objFormaPagamento->prazoPagamento()->where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objPessoa              = Pessoa::where('active', '=', 'yes')->where('id', '=', $idPessoa)->first();


        //tipo_pagamento



        $vrCobranca   = Utilitarios::removeMaskMoney($vrCobranca);

        if (!$objPessoa) {
            $erros[] = 'A pessoa de código nº ' . $idPessoa . ' não foi identificada.';
        }

        if (!$objFormaPagamento) {
            $erros[] = 'A forma de pagamento de código nº ' . $idFormaPagamento . ' não foi identificada.';
        }

        /* if(! $objPrazo){
            throw new CobrancaReceberException('O prazo de pagamento de código nº '.$idPlanoPagamento.' não foi identificado.');
        } */

        if (!$objPlanoPagamento) {
            $erros[] = 'O plano de pagamento de código nº ' . $idPlanoPagamento . ' não foi identificado.';
        }

        if (!$objOperadorFinanceiro) {
            if ($objFormaPagamento->hasOperadorFinanceiro == 'yes') {
                $erros[] = 'O operador financeiro de código nº ' . $idOperadorFinanceiro . ' não foi identificado.';
            }
        }

        if (!$vrCobranca) {
            $erros[] = 'O valor da cobrança informado é inválido.';
        }

        return $erros;
    }

    public function gerarCobranca(int $idPessoa, float $vrCobranca, int $idFormaPagamento, int $idPlanoPagamento, $idOperadorFinanceiro = null, array $dados = [])
    {
        $objFormaPagamento      = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $idFormaPagamento)->first();
        $objPlanoPagamento      = $objFormaPagamento->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')->where('plano_pagamentos.id', '=', $idPlanoPagamento)->first(); //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objOperadorFinanceiro  = $objFormaPagamento->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')->where('operador_financeiros.id', '=', $idOperadorFinanceiro)->first();
        //$objPrazo               = $objFormaPagamento->prazoPagamento()->where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $objPessoa              = Pessoa::where('active', '=', 'yes')->where('id', '=', $idPessoa)->first();


        //tipo_pagamento



        $vrCobranca   = Utilitarios::removeMaskMoney($vrCobranca);
        $erros = $this->validaGerCobranca($idPessoa, $vrCobranca, $idFormaPagamento, $idPlanoPagamento, $idOperadorFinanceiro, $dados);

        if ((is_array($erros) && count($erros) > 0)) {
            throw new CobrancaReceberException(implode('<br/>', $erros));
        }

        $qtdParcela         = $objPlanoPagamento->qtdParcelas ?? 1;;
        $dataParcelas       = [];
        $qtdDiasIntervalo   = $objPlanoPagamento->qtdDiasIntervaloParcelas ?? 0;
        $qtdDiasPriParcela  = $objPlanoPagamento->qtd_dias_pri_parcela ?? 0;
        $vrParcelaBase      = $vrCobranca / $qtdParcela;
        $vrParcelaBase      = number_format($vrParcelaBase, 2, '.', ',');
        $vrParcelaBase      = (float) $vrParcelaBase;

        $objDtVencimento = new \DateTime();

        if ($qtdDiasPriParcela > 0) {
            $objDtVencimento->add(new \DateInterval('P' . $qtdDiasPriParcela . 'D'));
        }

        $vrTotalParelasGeradas = 0;

        for ($i = 0; !($i == $qtdParcela); $i++) {
            $dtVencimento = $objDtVencimento->format("Y-m-d H:i:s");
            $dataParcelas[] = [
                'pessoa_id' => $objPessoa->id,
                'descricao' => $dados['descricao'] ?? "Recita financeira",
                'documento' => $dados['documento'] ?? null,
                'dtVencimentoOriginal' => $dtVencimento,
                'dtVencimento' => $dtVencimento,
                'vrPago' => 0,
                'vrBruto' => $vrParcelaBase,
                'vrLiquido' => $vrParcelaBase,
                'vrDevolvido' => 0,
                'vrTaxa' => 0,
                'vrDesconto' => 0,
                'vrJuros' => 0,
                'user_id' => \Auth::User()->id,
                'active' => 'yes',
                'importacao_dados' => 'no',
                'referencia_id' => $dados['referencia_id'] ?? null,
                'referencia' => $dados['referencia'] ?? null,
                'filial_id' => $dados['filial_id'] ?? null,
                'responsavel_id' => $dados['responsavel_id'] ?? 0,
                'forma_pagamento_id' => $objFormaPagamento->id,
                'plano_pagamento_id' => $objPlanoPagamento->id,
                'operador_financeiro_id' => $objOperadorFinanceiro->id ?? 0,
                'status' => 'aberto',

            ]; //responsavel_id

            if ($qtdDiasIntervalo > 0) {

                $objDtVencimento->add(new \DateInterval('P' . $qtdDiasIntervalo . 'D'));
            }

            $vrTotalParelasGeradas += $vrParcelaBase;
        }

        $difParcelas    = $vrParcelaBase - $vrTotalParelasGeradas;
        $difParcelasAbs = abs($difParcelas);

        //-- Tento jogar a diferença das parcela na primeira parcela
        if ($difParcelasAbs > 0.02 && is_array($dataParcelas) && count($dataParcelas) > 0) {
            $dataParcelas[0]['vrPago']      += 0;
            $dataParcelas[0]['vrBruto']     += $difParcelas;
            $dataParcelas[0]['vrLiquido']   += $difParcelas;
        }

        $datacobReceberObjArr = [
            'data_cob_receber' => [],
            'data_cob_receber_cartoes' => [],
            'data_cob_receber_boletos' => [],
        ];

        if (trim($objFormaPagamento->tipo) == 'cartao_credito' || trim($objFormaPagamento->tipo) == 'cartao_debito') {

            $dtVencimento = $objDtVencimento->format("Y-m-d H:i:s");
            $dtPagamento        = null;
            $dtBaixa            = null;
            $rashbaixa          = null;
            $statusCobCartao    = 'pago'; //aberto
            $dataCartoes        = [];

            if (isset($dados['documento']) && strlen(trim($dados['documento'])) >= 3) {
                $statusCobCartao    = 'pago';
                //$dtPagamento        = date('Y-m-d H:i:s');
                //$dtBaixa            = date('Y-m-d H:i:s');
                //$randId             = rand(111111111, 999999999);
                //$rashbaixa          = $objPessoa->id.''.$randId.''.date('ymdhis');
            }

            $dataParcela = [
                'pessoa_id' => $objPessoa->id,
                'descricao' => $dados['descricao'] ?? "Recita financeira",
                'documento' => $dados['documento'] ?? null,
                'dtVencimentoOriginal' => $dtVencimento,
                'dtVencimento' => $dtVencimento,
                'vrPago' => 0,
                'vrBruto' => $vrCobranca,
                'vrLiquido' => $vrCobranca,
                'vrDevolvido' => 0,
                'vrTaxa' => 0,
                'vrDesconto' => 0,
                'vrJuros' => 0,
                'user_id' => \Auth::User()->id,
                'active' => 'yes',
                'importacao_dados' => 'no',
                'referencia_id' => $dados['referencia_id'] ?? null,
                'referencia' => $dados['referencia'] ?? null,
                'filial_id' => $dados['filial_id'] ?? null,
                'responsavel_id' => $dados['responsavel_id'] ?? 0,
                'qtd_parcelas' => $qtdParcela ?? 1,
                'nr_parcela' => $qtdParcela ?? 1,
                'forma_pagamento_id' => $objFormaPagamento->id,
                'plano_pagamento_id' => $objPlanoPagamento->id,
                'operador_financeiro_id' => $objOperadorFinanceiro->id ?? 0,
                'status' => $statusCobCartao,

            ];

            $objCobReceber = ContaReceber::create($dataParcela);
            if (!$objCobReceber) {
                throw new CobrancaReceberException('Não foi possível gerar os contas a receber.Tente novamente ou entre em contato com o suporte.');
            }

            //---- Salvo os itens da baixa----------------------------------------------
            if ($statusCobCartao == 'pago') {

                $objCobReceberItemHelp = new ContaReceberItemHelper();
                $errosEncontrados = $objCobReceberItemHelp->validaGerCobrancaItem(
                    $objCobReceber,
                    $vrCobranca,
                    $objFormaPagamento->id,
                    $objPlanoPagamento->id,
                    $objOperadorFinanceiro->id ?? 0,
                    $dataParcela
                );

                if (is_array($errosEncontrados) && count($errosEncontrados) > 0) {
                    throw new CobrancaReceberException(implode('<br/>', $errosEncontrados));
                }

                $responseHelper = $objCobReceberItemHelp->gerarCobrancaItem(
                    $objCobReceber,
                    $vrCobranca,
                    $objFormaPagamento->id,
                    $objPlanoPagamento->id,
                    $objOperadorFinanceiro->id ?? 0,
                    $dataParcela
                );

                if (!$responseHelper) {
                    throw new CobrancaReceberException('Não foi possível realizar a baixa do contas a receber vinculado ao cartão informado. Tente novamente ou entre em contato com o suporte.');
                }
                $dataCartoes = $responseHelper['data_cob_receber_cartoes'] ??  [];
            }


            $datacobReceberObjArr['data_cob_receber'][]         = $objCobReceber;
            $datacobReceberObjArr['data_cob_receber_cartoes'][] = $dataCartoes;
        } else {

            if (is_array($dataParcelas) && count($dataParcelas) > 0) {
                foreach ($dataParcelas as $key => $val) {
                    $objCobReceber = ContaReceber::create($val);
                    if (!$objCobReceber) {
                        throw new CobrancaReceberException('Não foi possível gerar os contas a receber.Tente novamente ou entre em contato com o suporte.');
                    }
                    $datacobReceberObjArr['data_cob_receber'][] = $objCobReceber;
                }
            } else {
                throw new CobrancaReceberException('Não foi possível identificar quantas parcelas deveriam ser geradas. Tente novamente ou entre em contato com o suporte.');
            }
        }

        return $datacobReceberObjArr;
    }

    public function baixar(array $dados, int $id){

        $id = $id ?? $dados['id'];
        $callBack = $dados['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ($id <= 0) {
            throw new CobrancaReceberException('Parâmetro ínválido');
        }

        $vrCobranca = $dados['vr_final'] ?? 0;
        $vrCobranca   = Utilitarios::removeMaskMoney($vrCobranca); 

         if (! ($vrCobranca > 0)) {
            throw new CobrancaReceberException('O valor para baixa é inválido');
        }

        $registro = CobrancaReceber::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if (! $registro) {
            throw new CobrancaReceberException('Registro não identificado. Tentenovamente ou entre em contato com o suporte');
        }

        $dataParcela = [
            'pessoa_id' => $registro->pessoa->id,
            'descricao' => $dados['descricao'] ?? "Recita financeira",
            'documento' => $dados['documento'] ?? null,
            'dtVencimentoOriginal' => $registro->dtVencimentoOriginal,
            'dtVencimento' => $registro->dtVencimento,
            'vrPago' => 0,
            'vrBruto' => $vrCobranca,
            'vrLiquido' => $vrCobranca,
            'vrDevolvido' => 0,
            'vrTaxa' => 0,
            'vrDesconto' => 0,
            'vrJuros' => 0,
            'user_id' => \Auth::User()->id,
            'active' => 'yes',
            'importacao_dados' => 'no',
            'referencia_id' => $registro->referencia_id ?? null,
            'referencia' => $registro->referencia ?? null,
            'filial_id' => $registro->filial_id ?? null,
            'responsavel_id' => $registro->responsavel_id ?? 0,
            'qtd_parcelas' => 1,
            'nr_parcela' => 1,
            'forma_pagamento_id' => $registro->formaPagamento->id,
            'plano_pagamento_id' => $registro->planoPagamento->id,
            'operador_financeiro_id' => $registro->operadorFinanceiro->id ?? 0,
            'status' => 'aberto',

        ];

        $objCobReceberItemHelp = new ContaReceberItemHelper();
        
        //contaRecebrItem
        $dataResponse = $objCobReceberItemHelp->gerarCobrancaItem(
            $registro,
            $vrCobranca,
            $registro->formaPagamento->id,
            $registro->planoPagamento->id,
            $registro->operadorFinanceiro->id ?? 0,
            $dataParcela
        );
        if(!(is_array($dataResponse) && count($dataResponse) > 0)){
            throw new CobrancaReceberException('Não foi possível concluir a operação. Tentenovamente ou entre em contato com o suporte');
        }

        $dataItens = $dataResponse['data_cob_receber_item'] ?? [];

        if(!(is_array($dataItens) && count($dataItens) > 0)){
            throw new CobrancaReceberException('Não foi possível concluir a operação. Tentenovamente ou entre em contato com o suporte');
        }

        
       
        foreach($dataItens as $key=>$contaRecebrItem){
            if(!( $contaRecebrItem)){
                throw new CobrancaReceberException('Não foi possível concluir a operação. Tentenovamente ou entre em contato com o suporte');
            }
            $objCobReceberItemHelp = new ContaReceberItemHelper();
            $objCobReceberItemHelp->baixar($dados, $contaRecebrItem->id);
        }

        

        return $registro;
    }

    public function update(array $data, int $id){
        $dadosRequest = [];

        $dadosRequest['descricao']                  = $data['descricao'];
        $dadosRequest['user_update_id']             = \Auth::User()->id;
        $dadosRequest['active']                     =  'yes';

        $registro = CobrancaReceber::where('active', '=', 'yes')->where('id', '=', $id)->first();
        if (!$registro) {
            throw new CobrancaReceberException('Registro não identificado');
        }
        
        $registro->update($dadosRequest);

        return $registro;
    }

    public function info(array $data, $id, $idAssistente = 0)
    {

        $dados = $data;
        $id = $id ?? $dados['id'];
        $callBack = $dados['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ($id <= 0) {
            throw new CobrancaReceberException('Parâmetro ínválido');
        }


        $registro = CobrancaReceber::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if ($registro == null) {
            throw new CobrancaReceberException('Registro não encontrado');
        }

        return $registro;
    }

    public function faturamentoLiquidezMesAnoWidgetJson(array $data){
        
        $rawSqlYear = \DB::raw('YEAR(cr.created_at)');
        $rawSqlMes = \DB::raw('MONTH(cr.created_at)');
        $rawSqlDia = \DB::raw('DAY(cr.created_at)');
        $rawSqlFilial = \DB::raw('cr.filial_id');

        $data['campos'] = [
            \DB::raw('SUM(IFNULL(cr.vrLiquido, 0)) as vrFaturamentoLiquidez'),
            \DB::raw('YEAR(cr.created_at) as anoFaturamentoLiquidez'),
            \DB::raw('MONTH(cr.created_at) as mesFaturamentoLiquidez'),
            //\DB::raw('DAY(cr.created_at) as diaFaturamentoLiquidez'),
            \DB::raw('cr.filial_id as filial_id'),
        ];

        //select SUM(IFNULL(cr.vrLiquido, 0)) as vrFaturamentoLiquidez, YEAR(cr.created_at) as anoFaturamentoLiquidez, MONTH(cr.created_at) as mesFaturamentoLiquidez, DAY(cr.created_at) as diaFaturamentoLiquidez, cr.filial_id as filial_id from `conta_recebers` as `cr` inner join `pessoas` on `pessoas`.`id` = `cr`.`pessoa_id` inner join `filials` as `fl` on `cr`.`filial_id` = `fl`.`id` inner join `pessoas` as `pesfl` on `fl`.`pessoa_id` = `pesfl`.`id` inner join `forma_pagamentos` as `fp` on `fp`.`id` = `cr`.`forma_pagamento_id` where `cr`.`active` = yes and `pessoas`.`active` = yes group by filial_id,anoFaturamentoLiquidez,mesFaturamentoLiquidez order by `cr`.`id` desc
        $data['raw_grop_by'] = "{$rawSqlFilial},{$rawSqlYear},{$rawSqlMes}"; 

        

        return $this->json($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json(array $data)
    {
        $consulta = $data;

        if(! isset($consulta['ordem'])){

             $consulta['ordem'] =  'id-desc';
        }

        $campos =  $data['campos'] ?? [];
        $parse = [
            'id'=>'cr.id',
            'name'=>'pessoas.name',
            'filial_id'=>'cr.filial_id',
        ];

        $registro = \DB::table('conta_recebers as cr');
        $registro->join('pessoas', function ($join) {
            $join->on('pessoas.id', '=', 'cr.pessoa_id');
        })->join('filials as fl', function ($join) {

            $join->on('cr.filial_id', '=', 'fl.id');
        })->join('pessoas as pesfl', function ($join) {

            $join->on('fl.pessoa_id', '=', 'pesfl.id');
        })->join('forma_pagamentos as fp', function ($join) {
            $join->on('fp.id', '=', 'cr.forma_pagamento_id');
        });

        if (is_array($consulta) && count($consulta) > 0) {
            foreach ($consulta as $key => $val) {

                switch (trim($key)) {
                    case 'id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('cr.id', $val);
                        }
                        break;
                    case 'nmPessoa':
                    case 'pessoa_name':
                    case 'name_pessoa':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('pessoas.name', 'like', '%' . $val . '%');
                        }
                        break;
                    case 'vencido':

                         if (is_string($val)) {
                            $registro->whereIn('cr.status', ['aberto']);
                            
                            if(trim($val) == 'yes'){
                                $registro->where('cr.dtVencimento', '<', date('Y-m-d'));

                            }elseif(trim($val) == 'no'){
                                $registro->where('cr.dtVencimento', '>=', date('Y-m-d'));
                            }
                         }
                        
                        break;

                    case 'pessoa_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('pessoas.id', $val);
                        }
                        break;
                    case 'referencia_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }

                        $val = explode(',', $val);

                        $registro->whereIn('cr.referencia_id', $val);
                        break;

                    case 'referencia':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('cr.referencia', $val);
                        }
                        break;
                    case 'status':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('cr.status', $val);
                        }
                        break;
                    case 'limite':
                        $val = (int) $val;
                        if (is_integer($val) && $val > 0) {

                            $registro->limit($val);
                        }
                        break;
                    case 'ordem':


                        if ($val[0] == ',') {
                            $val = substr($val, 1);
                        }
                        if ($val[strlen($val) - 1] == ',') {
                            $val = substr($val, 0, -1);
                        }

                        $val = explode(',', $val);
                        for ($i = 0; !($i == count($val)); $i++) {
                            $atual = explode('-', $val[$i]);
                            if (array_key_exists(trim($atual[0]), $parse)) {

                                $parsed = $parse[trim($atual[0])];

                                if ($parsed) {

                                    $registro->orderBy($parsed, $atual[1]);
                                }
                            }
                        }

                        break;

                    case 'campos':
                        if (is_array($val) && count($val) > 0) {
                            //$campos = $this->montaCamposConsulta($registro, $val);

                        }
                        break;
                    case 'grop_by':
                        $registro->groupBy($val);
                        break;
                    case 'raw_grop_by':
                        $registro->groupByRaw($val);
                        break;
                }
            }
        }
        $sqlDsReferencia = '(
                    CASE 
                        WHEN cr.referencia = "ordem_servicos" THEN "Ordem de serviço"
                        ELSE "Referência não mapeada"
                    END
                )
                as dsReferencia
            ';
        if ($campos) {
            $registro->select($campos);
        } else {
            $registro->select('cr.*', \DB::raw('(IFNULL(cr.vrLiquido, 0) - (IFNULL(cr.vrPago, 0) + IFNULL(cr.vrDevolvido, 0)))  vrAberto'), \DB::raw($sqlDsReferencia), 'fp.cdCobrancaTipo', 'fp.name as name_cob_tp', 'pessoas.name', 'pesfl.name as name_filial');
        }

        $registro = $registro->where('cr.active', '=', 'yes')
            ->where('pessoas.active', '=', 'yes')->get();


        if (isset($consulta['to_require']) && $consulta['to_require'] == true) {
            $dataToRequest = [];
            foreach ($registro as $reg) {
                $dataToRequest[] = ['label' => $reg->name, 'value' => $reg->id];
            }

            $registro = $dataToRequest;
        }

        return  $registro;
    }
}
