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
use \App\Exceptions\CobrancaReceberException;
use \App\ExceptionApplication;
use \App\CobrancaReceberDesdobramento;
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
                            'idCobrancaTipo'                        => $value['formPgto'],
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
                            'idPessoaCustodia'                      => null,
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
        $maiorData    = null; 
        for($i = 0; !($i == count($dados)); $i++){
            $totalCobrancas += $dados[$i]->vrBruto;
            $idPessoas[$dados[$i]->pessoa_id] = true;
            $idFiliais[$dados[$i]->pessoa_id] = true;

            $qtdDias = Utilitarios::difDate($dados[$i]->dtVencimentoCobrancaReceber, date('Y-m-d'));

            if(((int) $dados[$i]->hasCobrancaJuros == 1)  && ($qtdDias > 0)){
                $totalJuros += (Utilitarios::difDate($dados[$i]->dtVencimentoCobrancaReceber, date('Y-m-d') - 1) * (($parametros['vrTaxaJuros'] / 100)/30) * $dados[$i]->vrCobrancaReceber );
                $totalMultas += ($parametros['vrMulta'] / 100) * $dados[$i]->vrCobrancaReceber;
            }

            $totalJuros += $dados[$i]->vrJuros + $dados[$i]->vrJurosProrrogacao - $dados[$i]->vrJurosDispensados;
            $totalMultas += $dados[$i]->vrMulta - $dados[$i]->vrMultaDispensada;

            if(($idFilial == 0) && ((int)$dados[$i]->filial_id > 0) ){
                $idFilial = (int)$dados[$i]->filial_id;
            }

            if($maiorData == null){
                $maiorData = $dados[$i]->dtVencimentoCobrancaReceber;
            }else{
                $data_01 = new DateTime($dados[$i]->dtVencimentoCobrancaReceber);
                $data_02 = new DateTime($maiorData);

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
            'maiorData'             =>$maiorData    
        ];

    }


    public function saveAcertar(Request $request, $ids)
    {
        try{
            
            \DB::beginTransaction();

            $dados = $request->all();
            if( (!isset($ids)) || (strlen(trim($ids)) == 0)){
                return response()->json(['errors'=>['error'=>'Parâmetro inválido']], 400);
            }

            $cobrancasArr = CobrancaReceber::where('active', '=', 'yes')->whereIn('id', explode (',', $ids))->get();
            if(! $cobrancasArr){
                throw new CobrancaReceberException('Registro não encontrado');
            }
            
            $result = $this->validaCobrancaReceber($cobrancasArr);

            if(! (is_array($dados) && (count($dados) > 0))){
                throw new CobrancaReceberException('Parâmetro inválido');
            }

            $maiorDataDesdobra = null;
            foreach($dados as $val){

                if($maiorData == null){
                    $maiorData = $val['dtVencimentoCobrancaReceber'];
                }else{

                    $data_01 = new DateTime($maiorData);
                    $data_02 = new DateTime($dtVencimentoCobrancaReceber);

                    if($data_01 < $data_02){
                        $maiorData = $dtVencimentoCobrancaReceber;
                    }
                }
            }

            if(new DateTime($maiorDataDesdobra)  > new DateTime($result['maiorData']) ){
                throw new CobrancaReceberException('Ultima data de destino é maior que a ultima data de origem, opte por desdobrar.');
            }

            //throw new ExceptionApplication('Exceção teste');
            \DB::commit();

            dd($dados);

            //return view('admin.cobranca_receber.acertar');
        }catch(\ExceptionApplication $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
       
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }
}
