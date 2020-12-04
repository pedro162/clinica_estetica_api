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
use \App\Http\Requests\CobrancaReceberRequest;
use Illuminate\Support\Facades\Validator;

class CobrancaReceberController extends Controller
{

    protected function requestProduto(Request $request)
    {
        $validador = Validator::make($request->all(),[
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

            $registro = null;

            \DB::transaction(function() use (&$request, &$registro){
                $dados = $request->all();
                $registro = CobrancaReceber::where('active', '=', 'yes');

                if(isset($dados['id']) && ($dados['id'] > 0)){
                    $registro = $registro->where('pessoa_id','=',$dados['id']);
                }

                $registro = $registro->get();
            });
            
            return view('admin.cobranca_receber.index', compact('registro'));

        }catch(\Exception $e){

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
                        'pl_pgto_id'      => '',
                        'op_finan_id'   => '',
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
                return response()->json(['error'=>['params'=>'Parametro inválido']], 400);
            }

            $registro           = null;
            $formaPagamento     = null;
            $planoPagamento     = null;
            $operadorFinanceiro = null;
            \DB::transaction(function() use (&$id, &$registro, &$formaPagamento, &$planoPagamento, &$operadorFinanceiro){
                $registro = Pessoa::where('active', '=', 'yes')->where('id', '=', $id)->first();

                $formaPagamento = FormaPagamento::where('active', '=', 'yes')->get();
                $planoPagamento = PlanoPagamento::where('active', '=', 'yes')->get();
                $operadorFinanceiro = OperadorFinanceiro::where('active', '=', 'yes')->get();
            });
            
            if(($registro == null) || ($formaPagamento == null)){
                 return response()->json(['errors'=>['erro'=>'Erro ao carregar o registro'], 'class'=>'warning'], 400);
            }
          

            return view('admin.cobranca_receber.mensalidade', compact('registro', 'formaPagamento', 'planoPagamento', 'operadorFinanceiro'));

        } catch (\Exception $e) {
            return response()->json(['error'=>['Algo errado aconteceu no servidor']], 500);
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
            
            if(isset($dados['fields']) && is_array($dados['fields']) && (count($dados['fields']) > 0)){
               
               $result = Utilitarios::getFormTable($dados['fields']);
               $dados['fields'] = $result;

            }

            if(! (is_array($dados) && (count($dados) > 0)) ){
                return response()->json(['errors'=>['params'=>'Dados inválidos']], 400);
            }
            \DB::transaction(function() use (&$id, &$dados){
                $pessoa = Pessoa::where('active', '=', 'yes')->where('id', '=', $id)->first();

                
                 dd($dados);
                $formaPagamento = FormaPagamento::where('active', '=', 'yes')->get();
            });
            

        } catch (\Exception $e) {
            return response()->json(['error'=>['Algo errado aconteceu no servidor']], 500);
        }
    }

}
