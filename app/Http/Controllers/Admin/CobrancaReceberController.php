<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\CobrancaReceber;
use \App\Pessoa;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\Utilitarios;
use \App\OperadorFinanceiro;
use \App\OrdemServico;
use \App\Filial;
use \App\VendaItem;
use \App\Venda;
use \App\ServicoItem;
use \App\Servico;
use \App\User;
use \App\Rca;
use \App\Exceptions\CobrancaReceberException;
use \App\ExceptionApplication;
use \App\CobrancaReceberDesdobramentoDestino;
use \App\CobrancaReceberDesdobramento;
use \App\CobrancaReceberDesdobramentoOrigen;
use \App\Http\Requests\CobrancaReceberRequest;
use Illuminate\Support\Facades\Validator;



class CobrancaReceberController extends Controller
{

    protected function requestProduto($request)
    {
        $validador = Validator::make($request,[
            'pessoa'=>'required'            

        ]);

        return $validador;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            \DB::beginTransaction();

            $registro = null;

            $dados = $request->all();
            $registro = CobrancaReceber::where('active', '=', 'yes');

            if(isset($dados['id']) && ($dados['id'] > 0)){
                $registro = $registro->where('pessoa_id','=',$dados['id']);
            }

            if(isset($dados['ids']) && ($dados['ids'] > 0)){
                $registro = $registro->whereIn('id', explode(',', $dados['ids']));
            }

            $registro = $registro->get();
            
            \DB::commit();

            return view('admin.cobranca_receber.index', compact('registro'));

        }catch(\ExceptionApplication $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
       
        }catch(\Exception $e){
            
            \DB::rollback();
            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);
        }
        

    }


      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Request $request)
    {
        try{

            $registro = null;

            \DB::transaction(function() use (&$request, &$registro){
                $dados = $request->all();
                $registro = CobrancaReceber::where('active', '=', 'yes');

                if(isset($dados['id']) && ($dados['id'] > 0)){
                    $registro = $registro->where('pessoa_id','=',$dados['id']);
                }

                if(isset($dados['statusCobranca']) && (strlen(trim($dados['statusCobranca'])) != 0)){
                    $registro = $registro->where('statusCobranca','=',$dados['statusCobranca']);
                }

                $registro = $registro->get();
            });
            
            //return view('admin.cobranca_receber.index', compact('registro'));
            return response()->json(['data'=>$registro], 201);

        }catch(\Exception $e){

            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);
        }
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CobrancaReceberRequest $request)
    {
        try{
            
            $falidator = $request->validated();
            $dados = $request->all();
            if(! (is_array($dados) && (count($dados) > 0) )){
                return response()->json(['errors'=>['error' => 'Parâmetro inválido.']], 400);
            }
            
            \DB::transaction(function(){
                $params =
                    [
                        'vrCobrancaReceber'                     => '',
                        'dsHistorico'                           => '',
                        'idCobrancaTipo'                        => '',
                        'pl_pgto_id'                            => '',
                        'op_finan_id'                           => '',
                        'idReferencia'                          => '',
                        'tpReferencia'                          => '',
                        //'nrDoc'                                 => '',
                        //'dsArquivo'                             => '',
                        'dtCompetencia'                         => '',
                        'naoGeraContraPartida'                  => '',
                        //'idPlanoDeContasSubconta'               => '',
                        'pessoa_id'                              => '',
                        'filial_id'                             => '',
                        'idPessoaRca'                           => ''
                    ];

                CobrancaReceber::create($params);

            });

        }catch(\Exception $e){
              return response()->json(['error'=>['Algo errado aconteceu no servidor']], 500);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function mensalidade($id)
    {
        try {

            if((! isset($id)) || ($id <= 0)){
                return response()->json(['errors'=>['params'=>'Parametro inválido']], 400);
            }

            $registro           = null;
            $formaPagamento     = null;
            $planoPagamento     = null;
            $operadorFinanceiro = null;
            $servico            = null;
            \DB::transaction(function() use (&$id, &$registro, &$formaPagamento, &$planoPagamento, &$operadorFinanceiro, &$servico){
                $registro = Pessoa::where('active', '=', 'yes')->where('id', '=', $id)->first();

                $formaPagamento         = FormaPagamento::where('active', '=', 'yes')->get();
                $planoPagamento         = PlanoPagamento::where('active', '=', 'yes')->get();
                $operadorFinanceiro     = OperadorFinanceiro::where('active', '=', 'yes')->get();
                $servico                = Servico::where('active', '=', 'yes')->where('type', '=', 'mensalidade')->first();
            });
            
            if(($registro == null) || ($formaPagamento == null) || ($servico == null)){
                 return response()->json(['errors'=>['erro'=>'Erro ao carregar o registro'], 'class'=>'warning'], 400);
            }
          

            return view('admin.cobranca_receber.mensalidade', compact('registro', 'formaPagamento', 'planoPagamento', 'operadorFinanceiro', 'servico'));

        } catch (\Exception $e) {
            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor']], 500);
        }
    }

    public function saveMensalidade(Request $request, $id)
    {
        try {
                       
            if((! isset($id)) || ($id <= 0)){
                return response()->json(['errors'=>['params'=>'Parametro inválido']], 400);
            }

            $registro          = null;
            $formaPagamento    = null;
            $errors            = [];
            $dados             = $request->all();
            $ordemServico      = null;
            
            if(isset($dados['fields']) && is_array($dados['fields']) && (count($dados['fields']) > 0)){
               
               $result = Utilitarios::getFormTable($dados['fields']);
               $dados['fields'] = $result;

            }

            if(! (is_array($dados) && (count($dados) > 0)) ){
                return response()->json(['errors'=>['params'=>'Dados inválidos']], 400);
            }
            \DB::transaction(function() use (&$id, &$dados, &$ordemServico){
                $pessoa = Pessoa::where('active', '=', 'yes')->where('id', '=', $id)->first();
                $formaPagamento = FormaPagamento::where('active', '=', 'yes')->get();
                $servico = Servico::where('active', '=', 'yes')->where('id', '=', $dados['servico_id'])->first();

                if(! $servico){
                    throw new \Exception('Serviço não identificado.');
                }

                $paramsOrdem                    = [];
                $paramsOrdem['vrTotal']         = str_replace(['.', ','],['', '.'], $dados['vrLiquido'] );
                $paramsOrdem['status']          = 'aberto';
                //$paramsOrdem['observacao']      = dados['observacao0'];
                $paramsOrdem['pessoa_id']       = $pessoa->id;
                $paramsOrdem['pessoa_rca_id']   = \Auth::User()->id;
                $paramsOrdem['filial_id']       = Filial::first()->id;
                $paramsOrdem['user_id']         = \Auth::User()->id;
                $paramsOrdem['active']          = 'yes';
                $ordemServico = OrdemServico::create($paramsOrdem);
                if($ordemServico){
                   // dd($dados);
                   //-------------------------------- SALVA A ORDEM DE SERVICO --------------------------------------------------------
                    foreach ($dados['fields'] as $key => $value) {
                       $params =
                        [
                            'vrCobrancaReceber'                     => str_replace(['.', ','],['', '.'], $value['valor']),
                            'vrBruto'                               => str_replace(['.', ','],['', '.'], $value['valor']),
                            'dsHistorico'                           => 'Mensalidade treino academia',
                            'forma_pagamento_id'                    => $value['formPgto'],
                            'pl_pgto_id'                            => $value['planoPgto'],
                            'op_finan_id'                           => $value['operadorFinan'],
                            'idReferencia'                          => $ordemServico->id,
                            'tpReferencia'                          => 'OrdemServico',
                            'nrDoc'                                 => $value['cvNsu'],
                            //'dsArquivo'                           => $value[''],
                            'dtCompetencia'                         => date('Y-m-d H:i:s'),
                            'naoGeraContraPartida'                  => true,
                            //'idPlanoDeContasSubconta'             => $value[''],
                            'pessoa_id'                             => $pessoa->id,
                            'filial_id'                             => 1,
                            'pessoa_rca_id'                         => \Auth::User()->id,
                            'idFuncionarioEstorno'                  => null,
                            'idFuncionarioDesdobramento'            => null,
                            'idPessoaBaixa'                         => null,
                            'idPessoaCustodia'                      => \Auth::User()->id,//configurar a pessoa da custodia
                            'idPessoaCustodiaOrigem'                => null,
                            'user_id'                               => \Auth::User()->id,
                            'active'                                => 'yes',
                            'naoGeraContraPartida'                  => true,
                            'filial_id'                             => 1,
                        ];
                        $result = CobrancaReceber::saveContasReceber($params);
                        if(! $result){
                            throw new \Exception('Erro ao salvar registro.');
                        }
                    }


                    $params =
                    [
                        'qtd'                   => $dados['qtd'] ?? 1,
                        'servico_id'            => $servico->id,
                        'ordem_servico_id'      => $ordemServico->id,
                        'vrTotal'               => str_replace(['.', ','],['', '.'], $dados['vrTotal'] ?? 200),
                        'vrItem'                => str_replace(['.', ','],['', '.'], ($dados['vrItem'] ?? 200) * ($dados['qtd'] ?? 1)),
                        'user_id'               => \Auth::User()->id,
                        'active'                => 'yes',
                    ];

                    $result = ServicoItem::create($params);
                    if(! $result){
                        throw new \Exception('Erro ao salvar registro.');
                    }
                    
                    

                }
                
            });
            

            if($ordemServico){
                return response()->json(['data'=>$ordemServico, 'class'=>'success'], 201);
            }
           

        } catch (\Exception $e) {
            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }


    public function recibo($id, $tpReferencia)
    {
        try{

            if(!isset($id, $tpReferencia)){
                return response()->json(['errors'=>['error'=>'Parâmetros inválidos']], 400);
            }

            $registro   = null;
            $venda        = null;
            \DB::transaction(function() use (&$id, &$tpReferencia, &$registro, &$venda){
                $obj = CobrancaReceber::where('idReferencia', '=', $id)
                ->where('tpReferencia', '=', $tpReferencia)->get();
                $registro = $obj;
                $classPai = '\App\\'.$tpReferencia.'::where';
                $venda = $classPai('id', '=', $id)->where('active', '=', 'yes')->first()->venda();
                
            });
            //dd($venda);
            if($venda && $registro){
                return view('admin.cobranca_receber.recibo_mensalidade', compact('registro', 'venda'));
                
            }else{
                return response()->json(['errors'=>['error'=>'Registro não encontrado.']], 404);
            }

        }catch(\Exception $e){
            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }


    public function desdobramentoInfo($id)
    {
        try{

            if(!isset($id)){
                return response()->json(['errors'=>['error'=>'Parâmetro inválido']], 400);
            }

            $registro = \DB::transaction(function() use (&$id){
                $obj = CobrancaReceberDesdobramento::where('id', '=', $id)
                ->where('tpReferencia', '=', $tpReferencia)->first();
                $origem     = $obj->origem();
                $destino    = $obj->destino();
                $user       = User::find($obj->user_id);

                return ['origem'=>$origem, 'destino'=>$destino, 'usuario'=>$user];
                
            });
            
            if($registro){
                return view('admin.cobranca_receber.info_desdobramento', compact('registro'));
                
            }else{
                return response()->json(['errors'=>['error'=>'Registro não encontrado.']], 404);
            }

        }catch(\Exception $e){
            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }


    public function acertar($ids)
    {
        try{

            \DB::beginTransaction();

            if( (!isset($ids)) || (strlen(trim($ids)) == 0)){
                return response()->json(['errors'=>['error'=>'Parâmetro inválido']], 400);
            }
            
            $cobrancasArr = CobrancaReceber::where('active', '=', 'yes')->whereIn('id', explode (',', $ids))->get();
            if(! $cobrancasArr){
                throw new CobrancaReceberException('Registro não encontrado');
            }
            
            $result = $this->validaCobrancaReceber($cobrancasArr);
            $totalCobrancas     = $result['totalCobrancas'];
            $totalMultas        = $result['totalMultas'];
            $totalJuros         = $result['totalJuros'];
            $rcas               = $result['rcas'];
            $idPessoa           = $result['idPessoa'];
            $idPessoas          = $result['idPessoas'];
            $idFiliais          = $result['idFiliais'];
            $idFilial           = $result['idFilial'];
            
            $rcas = Pessoa::where('active', '=', 'yes')->whereIn('id', $rcas)->get();
            if(count($idPessoas) > 1){
                throw new CobrancaReceberException('Contas a receber de clientes diferentes');
                
            }elseif(count($idFiliais) > 1){
                throw new CobrancaReceberException('Contas a receber de filiais diferentes');
            }

            $foramasPagamento = FormaPagamento::where('active', '=', 'yes')->get();
            if(! $foramasPagamento){
                throw new CobrancaReceberException('Nenhuma forma de pagamento encontrada.');
            }

            //dd($cobrancasArr);

            //throw new ExceptionApplication('Exceção teste');
            \DB::commit();

            return view('admin.cobranca_receber.acertar', compact('totalCobrancas', 'totalMultas', 'totalJuros', 'rcas', 'idPessoa', 'idPessoas', 'idFiliais', 'idFilial', 'foramasPagamento', 'ids'));
        }catch(CobrancaReceberException $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
       
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }

    private function validaCobrancaReceber($dados)
    {
        
        $totalCobrancas     = 0;
        $totalMultas        = 0;
        $totalJuros         = 0;
        $rcas               = [];
        $idPessoa           = 0;
        $idPessoas          = [];
        $idFiliais          = [];
        $idFilial           = 0;
        $maiorData          = null; 
        $hasCartao          = false; 
        for($i = 0; !($i == count($dados)); $i++){
            $totalCobrancas += $dados[$i]->vrBruto;
            $idPessoas[$dados[$i]->pessoa_id] = true;
            $idFiliais[$dados[$i]->pessoa_id] = true;
            $rcas[$dados[$i]->pessoa_rca_id] =true; 
            $qtdDias = Utilitarios::difDate($dados[$i]->dtVencimentoCobrancaReceber, date('Y-m-d'));

            if(((int) $dados[$i]->hasCobrancaJuros == 1)  && ($qtdDias > 0)){
               // $totalJuros += (Utilitarios::difDate($dados[$i]->dtVencimentoCobrancaReceber, date('Y-m-d') - 1) * (($parametros['vrTaxaJuros'] / 100)/30) * $dados[$i]->vrCobrancaReceber );
               // $totalMultas += ( $parametros['vrMulta'] / 100) * $dados[$i]->vrCobrancaReceber;
            }

            $totalJuros += $dados[$i]->vrJuros + $dados[$i]->vrJurosProrrogacao - $dados[$i]->vrJurosDispensados;
            $totalMultas += $dados[$i]->vrMulta - $dados[$i]->vrMultaDispensada;

            if(($idFilial == 0) && ((int)$dados[$i]->filial_id > 0) ){
                $idFilial = (int)$dados[$i]->filial_id;
            }

            if($maiorData == null){
                $maiorData = $dados[$i]->dtVencimentoCobrancaReceber;
            }else{
                $data_01 = new \DateTime($dados[$i]->dtVencimentoCobrancaReceber);
                $data_02 = new \DateTime($maiorData);

                if($data_01 < $data_02){
                    $maiorData = $data_02;
                }
            }

            if($dados[$i]->statusTransito == 'descontado'){
                throw new CobrancaReceberException('Este título não pode ser desdobrado pois encontra-se descontado.');
            }elseif($dados[$i]->statusTransito == 'Negativado'){
                throw new CobrancaReceberException('Este título não pode ser desdobrado pois encontra-se negativado.');
            }

            if($dados[$i]->statusCobranca != 'aberto'){
                throw new CobrancaReceberException('Este título não pode ser desdobrado pois não encontra-se em aberto.');
            }

            $operadorFinan = OperadorFinanceiro::where('active', '=', 'yes')->where('pessoa_id', '=', $dados[$i]->idPessoaCustodia)->first();

            if(! $operadorFinan){
                throw new CobrancaReceberException('Não encontrada a pessoa responsável pela custódia.');
            }

            if($operadorFinan->tpLocalAtualizacaoBoleto == 'banco'){
                throw new CobrancaReceberException('Este título encontra sob a posse do banco. Para renegociação, entre em contato com o banco.');
            }
        }

        if(count($idPessoas) > 1){
            throw new CobrancaReceberException('Contas a receber de clientes diferentes');
            
        }elseif(count($idFiliais) > 1){
            throw new CobrancaReceberException('Contas a receber de filiais diferentes');
        }

        \DB::commit();

        return[
            'totalCobrancas'        =>$totalCobrancas,
            'totalMultas'           =>$totalMultas,      
            'totalJuros'            =>$totalJuros,         
            'rcas'                  =>$rcas,       
            'idPessoa'              =>$idPessoa,        
            'idPessoas'             =>$idPessoas,       
            'idFiliais'             =>$idFiliais,       
            'idFilial'              =>$idFilial,    
            'maiorData'             =>$maiorData,
            'hasCartao'             =>$hasCartao    
        ];

    }


    private function validarDestnos(Array $dados, $tpAcao):Array
    {
       
        if(! (is_array($dados) && (count($dados) > 0))){
            throw new CobrancaReceberException('Dados inválidos');
        }

        $ultimaDataDestino = Utilitarios::validaData(substr($dados['dtVencimento'], 0, 10)) != false ? $dados['dtVencimento'] : date('Y-m-d');
        $vrCobranca = Utilitarios::removeMaskMoney($dados['vrCobranca']);

        if($vrCobranca === false){
            throw new CobrancaReceberException('Valor da cobrança é inválido');
        }

        if(! (isset($dados['forma_pagamento_id']) && ($dados['forma_pagamento_id'] > 0)) ){
            throw new CobrancaReceberException('Forma de pagamento não identificada');
        }
        

        $dados['ultimaDataDestino'] = $ultimaDataDestino;
        $dados['vrCobrancasDestino'] = (float)$vrCobranca;
        return $dados;

    }


    public function saveAcertar(Request $request, $ids)
    {
        try{
            
            \DB::beginTransaction();

            $dados = $request->all();
            $val = $dados['destinos'];
            if( (!isset($ids)) || (strlen(trim($ids)) == 0)){
                return response()->json(['errors'=>['error'=>'Parâmetro inválido']], 400);
            }

            $cobrancasArr = CobrancaReceber::where('active', '=', 'yes')->whereIn('id', explode (',', $ids))->get();
            if(! $cobrancasArr){
                throw new CobrancaReceberException('Registro não encontrado');
            }
            
            if(! (is_array($dados) && (count($dados) > 0))){
                throw new CobrancaReceberException('Parâmetro inválido');
            }

            //dd($val);

            $result = $this->validaCobrancaReceber($cobrancasArr);
            $resultDestinos['vrCobrancasDestino'] = 0;
            $ultimaDataDestino = null;
            if(is_array($val) && ($val > 0)){
                for($i = 0; !($i == count($val)); $i++){
                   $val[$i]['forma_pagamento_id'] =  $val[$i]['formPgto'];
                   $val[$i]['vrCobranca'] =  $val[$i]['valor'];
                   $val[$i]['dtVencimento'] =  substr($val[$i]['dtVencimento'], 0, 10);
                   
                   $resultado = $this->validarDestnos($val[$i], $dados['tpAcao']);
                   
                   $resultDestinos['vrCobrancasDestino'] +=  (float)  $resultado['vrCobrancasDestino'];

                   if($ultimaDataDestino == null){
                        $ultimaDataDestino = Utilitarios::validaData(substr($resultado['dtVencimento'], 0, 10)) != false ? $resultado['dtVencimento'] : date('Y-m-d');
                    }else{
            
                        $data_01 = new \DateTime(Utilitarios::validaData($resultado['dtVencimento']) != false ? substr($resultado['dtVencimento'], 0, 10) : date('Y-m-d'));
                        $data_02 = new \DateTime($ultimaDataDestino != null ? substr($ultimaDataDestino, 0, 10) : date('Y-m-d'));
            
                        if($data_01 > $data_02){
                            $ultimaDataDestino = $data_01;
                        }
                    }

                    if((new \DateTime($result['maiorData']) < new \DateTime($resultado['ultimaDataDestino']) ) && ($dados['tpAcao'] == 'acertar') && ($result['hasCartao'] == true)){
                        throw new CobrancaReceberException('Ultima data de destino não pode ser maior que a maior data de origem. Por favor, utilize a opção de desdobramento.');
                    }

                }
            }

            if(abs($result['totalCobrancas'] - $resultDestinos['vrCobrancasDestino']) > 0.05){
                throw new CobrancaReceberException('O total das origens: '.$result['totalCobrancas'].' não pode ser diferente do total de destino: '.$resultDestinos['vrCobrancasDestino'].'.');
            }
           

            //----- valida plano de contas para descontos
            if(isset($val['vrDescontos']) && ($val['vrDescontos'] > 0)){
                /*if(isset($parametros['financeiro_planodecontas_descontos']) && (strlen(trim($parametros['financeiro_planodecontas_descontos'])) > 0)){

                }*/

                //----- lançar contas a pagar de desconto
                /**
                 * CobrancaPagar::create(['idReferencia'=> $idDesdobramentoReceber, 'tpReferencia'=>CobrancaReceber::class]);
                 */

                $val['vrDesconto'] = $val['vrDescontos'];
            }

            $totJursoDispensados = 0;
            $totMultaDispensada = 0;

            if($dados['tpAcao'] == 'desdobrar'){
                $totJursoDispensados    = $result['totalJuros'] ?? 0 - $dados['vrJuros'] ?? 0;
                $totMultaDispensada     = $result['totalMultas'] -  Utilitarios::removeMaskMoney($dados['vrMultas'] ?? 0);
            }

            if($totJursoDispensados > 0){
                //----- lançar juros dispensados
            }

            if($totMultaDispensada > 0){
                //----- lançar multas dispensadas
            }

            if(Utilitarios::removeMaskMoney($dados['vrAcrescimos'] ?? 0) > 0){
                //----- Lançar crédito para o cliente
            }

            $desdobramento = CobrancaReceberDesdobramento::create(
                [
                    'vrJurosDispensados'    =>$totJursoDispensados,
                    'vrMultaDispensada'     =>$totJursoDispensados,
                    'qtdParcelas'           =>count($dados['destinos']),
                    'vrDesdobramento'       => 0,
                    'idReferencia'          => 0,
                    'tpReferencia'          => CobrancaReceber::class,
                    'user_id'               => \Auth::User()->id
                ]
            );

            if(! $desdobramento){
                throw new CobrancaReceberException('Algo errado aconteceu al desdobrar.');
            }
            $escutaOrigem = true;
            $referencias = [];
            $idReferencia = null;
            $tpReferencia = null;
            $idPesoa = null;
            $rca = [];
            $dtCompetenciaOrigem = null;
            if($cobrancasArr){
                for($i = 0; !($i == count($cobrancasArr)); $i++){
                    $idPlanoContas = $cobrancasArr[$i]->idPlanoContas;

                    $resultCobReceber = $cobrancasArr[$i]->update([
                        'dtDesdobramento'               => date('Y-m-d H:i:s'), 
                        'statusCobranca'                => 'desdobrado',
                        'idDesdobramentoReceber'        => $desdobramento->id,
                        'user_desdobramento_id'         => \Auth::User()->id,
                        'user_update_id'                => \Auth::User()->id,
                        'isTransitoria'                 => 'no',
                        'isAcertada'                    => 'yes',
                        'idPessoaCustodia'              => 1, // configurar a pesso da custódia
                        'dsJustificativaDesdobramento'  => $dados['dsJustificativaDesdobramento'] ?? '',
                    ]);

                    $rca[$cobrancasArr[$i]->pessoa_id] = $cobrancasArr[$i]->vrCobrancaReceber;
                    $dtCompetenciaOrigem = $cobrancasArr[$i]->dtCompetencia;
                    $idPessoaRca = $cobrancasArr[$i]->idPessoaRca;
                    $nrDuplicata = $cobrancasArr[$i]->nrDuplicata;
                    $idReferencia = $cobrancasArr[$i]->idReferencia;
                    $tpReferencia = $cobrancasArr[$i]->tpReferencia;
                    $dsHistorico = $cobrancasArr[$i]->dsHistorico;
                    $idPesoa = $cobrancasArr[$i]->pessoa_id;

                    $referencias[$cobrancasArr[$i]->idReferencia] = true;

                    //inserir origens
                    CobrancaReceberDesdobramentoOrigen::create(
                        [
                            'c_recebers_id' => $cobrancasArr[$i]->id,
                            'c_rec_des_id' => $desdobramento->id,
                            'user_id'       =>\Auth::User()->id,
                            'active'        =>'yes'
                        ]
                    );

                    // se as origens forem boletos solicitar cancelamento
                }
            }
           
            $dsHistoricoGeral = 'DESD: '.$desdobramento->id;
           
            if(count($referencias) > 1){
                $idReferencia = $desdobramento->id;
                $tpReferencia = CobrancaReceberDesdobramento::class;
            }
           
            $destinosArr = [];
            if(is_array($val) && (count($val) > 0)){
                $count = 1;
                for($i=0; !($i == count($val)); $i++){
                   $cobrancaReceberDest = CobrancaReceber::create(
                                                [
                                                    'idReferencia'                  =>$idReferencia,
                                                    'tpReferencia'                  =>$tpReferencia,
                                                    'pessoa_id'                     =>$idPesoa,
                                                    'dtCompetencia'                 =>$dtCompetenciaOrigem,
                                                    'dtVencimentoCobrancaReceber'   =>$val[$i]['dtVencimento'],
                                                    'dsHistorico'                   =>$dsHistoricoGeral ?? NULL,
                                                    'vrBruto'                       =>$val[$i]['vrCobranca'],
                                                    'vrCobrancaReceber'             =>$val[$i]['vrCobranca'],
                                                    'idCobrancaTipo'                =>$val[$i]['idCobrancaTipo'] ?? $val[$i]['formPgto'],
                                                    'pl_pgto_id'                    =>$val[$i]['pl_pgto_id'] ?? $val[$i]['planoPgto'],
                                                    'op_finan_id'                   =>$val[$i]['op_finan_id'] ?? $val[$i]['operadorFinan'],
                                                    'nrDoc'                         =>$val[$i]['nrDoc'] ?? $val[$i]['cvNsu'] ?? NULL,
                                                    'idPlanoContaSubConta'          =>$val[$i]['idPlanoContaSubConta'] ?? null,
                                                    'vrDesconto'                    =>$val[$i]['vrDesconto'] ?? 0,
                                                    'statusCobranca'                =>'aberto',
                                                    'qtdParcelas'                   =>$val[$i]['qtdParcelas'] ?? null,
                                                    'filial_id'                     =>$val[$i]['filial_id'] ?? null ,
                                                    'user_id'                       => \Auth::User()->id,
                                                    'active'                        =>'yes',
                                                    'pessoa_rca_id'                 =>$dados['rca'],
                                                    'nrDuplicata'                   =>$nrDuplicata ?? NULL,                            
                                                    'nrParcela'                     =>$count,
                                                    'idPessoaCustodia'              =>\Auth::User()->id, //configura a pessoa do usuario
                                                    'filial_id'                     =>1 //configurar a filial
                                                ]);

                    CobrancaReceberDesdobramentoDestino::create([
                        'c_recebers_id' => $cobrancaReceberDest->id,
                        'c_rec_des_id'  => $desdobramento->id,
                        'user_id'       =>\Auth::User()->id,
                        'active'        =>'yes'
                    ]);
                    $destinosArr[] =  $cobrancaReceberDest;
                    $count ++;
                }

                

            }

            //---- deletar boleto

            //throw new ExceptionApplication('Exceção teste');
            \DB::commit();

            return response()->json(['data'=>$destinosArr, 'class'=>'success'], 201);
            //return view('admin.cobranca_receber.acertar');
        }catch(\ExceptionApplication $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
       
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }



    /**
     * Simula como ficará o desdobramento
     */

    public function simularAcertar(Request $request, $ids)
    {
        try{
            
            \DB::beginTransaction();

            $dados = $request->all();
            $erros = [];
          //  dd($dados );
            $val = $dados['destinos'];
            //dd($val );
            if( (!isset($ids)) || (strlen(trim($ids)) == 0)){
                return response()->json(['errors'=>['error'=>'Parâmetro inválido']], 400);
            }

            $cobrancasArr = CobrancaReceber::where('active', '=', 'yes')->whereIn('id', explode (',', $ids))->get();
            if(! $cobrancasArr){
                throw new CobrancaReceberException('Registro não encontrado');
            }
            
            if(! (is_array($dados) && (count($dados) > 0))){
                throw new CobrancaReceberException('Parâmetro inválido');
            }

            $result = $this->validaCobrancaReceber($cobrancasArr);
            $resultDestinos =  $this->validarDestnos($val, $val['tpAcao']);

            if((new \DateTime($result['maiorData']) < new \DateTime($resultDestinos['ultimaDataDestino']) ) && ($val['tpAcao'] == 'acertar') && ($result['hasCartao'] == true)){
               // throw new CobrancaReceberException('Ultima data de destino não pode ser maior que a maior data de origem. Por favor, utilize a opção de desdobramento.');
                $erros[] = 'Ultima data de destino não pode ser maior que a maior data de origem. Por favor, utilize a opção de desdobramento.';
            }
            if(! (isset($val['pl_pgto_id']) && ($val['pl_pgto_id'] > 0)) ){
               // throw new CobrancaReceberException('Plano de Pagamento não identificado.');
                $erros[] = 'Plano de Pagamento não identificado.';
            }
           
            if(! (isset($val['forma_pagamento_id']) && ($val['forma_pagamento_id'] > 0)) ){
                //throw new CobrancaReceberException('Forma de Pagamento não identificada.');
                $erros[] = 'Forma de Pagamento não identificada.';
               
            }

            if(is_array($erros) && (count($erros) > 0)){
                throw new CobrancaReceberException(implode('<br/>', $erros));
            }
            
            $formaPagamento = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $val['forma_pagamento_id'])->first();
           
            if(! ($formaPagamento) ){
                throw new CobrancaReceberException('Forma de Pagamento não identificada.');
            }

            $operadorFinanceiro = null;
            if($formaPagamento->tipo == 'cartao_credito'){
                if(! (isset($val['cvNsu']) && (strlen(trim($val['cvNsu'])) > 0) )){
                    throw new CobrancaReceberException('CV/NSU OU DOC é obrigatório.');
                }

                $operadorFinanceiro = OperadorFinanceiro::where('active', '=', 'yes')->where('id', '=', $val['op_finan_id'])->first();
                if(! $operadorFinanceiro){
                    throw new CobrancaReceberException('Operador financeiro não identificado.');
                }
            }elseif($formaPagamento->tipo == 'boleto'){
                /**
                 * $dados['idReferencia'] = '';
                 * $dados['tpReferencia'] = '';
                 * $dados['idPessoa '] = '';
                 * $dados['nrDoc'] = '';
                 * $dados['operadorFields'] = '';
                 * $dados['planosFields'] = '';
                 * $dados['cobrancasFields'] = '';
                 * 
                 * validarCreditoBoleto($dados);
                 */
            }

            $idPesoa = null;
            if($operadorFinanceiro){
                if($operadorFinanceiro->isAssumeDuplicata == 'yes'){
                    $idPesoa = $operadorFinanceiro->pessoa_id;
                }
            }
            
            $planoPagamento = PlanoPagamento::where('active', '=', 'yes')->where('id', '=', $val['pl_pgto_id'])->first();

            if(! ($planoPagamento) ){
                throw new CobrancaReceberException('Plano de Pagamento não identificado.');
            }

            $prazosPagamento = $planoPagamento->planoPrazo()->where('active', '=', 'yes')->get();
            
            if(! $prazosPagamento){
                throw new CobrancaReceberException('Prazo de Pagamento não identificado.');
            }

            //dd($prazosPagamento );
            $dsHistoricoGeral = 'DESD: ';

            $idReferencia = date('ymdhis');
            $tpReferencia = 'SNF';
          
            $dadosResult = [];
            if(is_array($val) && (count($val) > 0)){
                $count = 1;

                foreach($prazosPagamento as $prazo){

                    $dtVencimento = date('Y-m-d');
                    $dtVencimentoArr = explode('-',$dtVencimento);
                    $mktimeVencimento = mktime(0, 0, 0, $dtVencimentoArr[1], $dtVencimentoArr[2] + $prazo->qtdDias, $dtVencimentoArr[0]);
                    if(strlen($mktimeVencimento) > 0){
                        $dtVencimentoCobrancaReceber = date('Y-m-d H:i:s', $mktimeVencimento);
                    }else{
                        throw new CobrancaReceberException('Prazo de Pagamento não identificado.');
                    }
                            
                    if(isset($val['dtVencimento']) && ( strlen(trim($val['dtVencimento'])) > 0)){
                        if(Utilitarios::validaData($val['dtVencimento'])){

                            $dtVencimentoCobrancaReceber = $val['dtVencimento'];
                        }
                    }
                   // dd(Utilitarios::removeMaskMoney($val['vrCobranca']));
                    $vrParcela = (float)Utilitarios::removeMaskMoney($val['vrCobranca']);
                    $destino = [
                        'idReferencia'                  =>$idReferencia,
                        'tpReferencia'                  =>$tpReferencia,
                        'pessoa_id'                     =>(int)$val['idPessoa'],
                        'dtCompetencia'                 =>$val['dtCompetencia'] ?? date('Y-m-d H:i:s'),
                        'dtVencimentoCobrancaReceber'   =>$dtVencimentoCobrancaReceber,
                        'dsHistorico'                   =>$dsHistoricoGeral ?? NULL,
                        'vrBruto'                       =>number_format( $vrParcela/count($prazosPagamento) , 2, '.', ''),
                        'vrCobrancaReceber'             =>number_format( $vrParcela/ count($prazosPagamento) , 2, '.', ''),
                        'forma_pagamento_id'            =>$val['forma_pagamento_id'],
                        'formPgtoText'                  => trim($formaPagamento->name),
                        'pl_pgto_id'                    =>$val['pl_pgto_id'],
                        'op_finan_id'                   =>$val['op_finan_id'],
                        'nrDoc'                         =>$val['cvNsu'] ?? NULL,
                        //'idPlanoContaSubConta'          =>$val['idPlanoContaSubConta'],
                        'statusCobranca'                =>'aberto',
                        'qtdParcelas'                   =>count($prazosPagamento),
                        'filial_id'                     =>$val['filial_id'],
                        'user_id'                       => \Auth::User()->id,
                        'active'                        =>'yes',
                        //'pessoa_rca_id'                 =>array_search(max($rca), $rca),
                        'nrDuplicata'                   =>NULL,                            
                        'nrParcela'                     =>$count,
                        //'statusCustodia'              =>'Cofirmado';
                   ];
                    //dd(count($prazosPagamento) );
                    $dadosResult[] = $destino;
                    $count ++;
                }


            }

            //dd($dadosResult );

            \DB::commit();
            return response()->json(['data'=>$dadosResult, 'class'=>'success'], 201);

            //return view('admin.cobranca_receber.acertar');
        }catch(\ExceptionApplication $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
       
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }


    public function verificar_dia_fixo($dia,$parcelas,$Financeiro_PlanosDePagamentos_id){
		
		//Financeiro_PlanosDePagamentos_Prazos_dias
		//Financeiro_PlanosDePagamentos_id
		//verificar qndo é o proximo dia 05
	    	$data_inicial = date("Y-m-d");
	    	if(date('d') > $dia){
		    //vai para o proximo mes				
		    $data_final = date('Y-m', strtotime('+1 months', strtotime(date('Y-m-d'))))."-".$dia;
		}else{
			//ainda é esse mes
			$data_final = date('Y-m')."-".$dia;
		}
		// Calcula a diferença em segundos entre as datas
		$diferenca = strtotime($data_final) - strtotime($data_inicial);
		//Calcula a diferença em dias
		$dias = floor($diferenca / (60 * 60 * 24));			
		$prazosFields['Financeiro_PlanosDePagamentos_Prazos_dias'] = $dias;
		$prazosFields['Financeiro_PlanosDePagamentos_id'] = $Financeiro_PlanosDePagamentos_id;			
		$prazosArr[] = $prazosFields;
		if($parcelas > 1 ){	
			for ($i = 1; $i < $parcelas; $i++) {					
				$data_final = date('Y-m', strtotime('+1 months', strtotime($data_final)))."-".$dia;
				$diferenca = strtotime($data_final) - strtotime($data_inicial);
				//Calcula a diferença em dias
				$dias = floor($diferenca / (60 * 60 * 24));	

				$prazosFields['Financeiro_PlanosDePagamentos_Prazos_dias'] = $dias;
				$prazosFields['Financeiro_PlanosDePagamentos_id'] = $Financeiro_PlanosDePagamentos_id;			
				$prazosArr[] = $prazosFields;
			}
		}
		return $prazosArr;
			
	}
}
