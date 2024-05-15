<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\ContaReceber as CobrancaReceber;
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
use Illuminate\Support\Facades\Validator;
use App\Helpers\ContaReceberHelper;



class CobrancaReceberController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            
            \DB::beginTransaction();
            
            $data = $request->all();
            $objCobReceberHelper = new ContaReceberHelper();

            $registro = $objCobReceberHelper->json($data);

            \DB::commit();

            //dd( $registro);

            return view('admin.cobranca_receber.index', compact('registro', 'consulta'));
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));

            // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {
        try {
            \DB::beginTransaction();

            $data = $request->all();

            $objCobReceberHelper = new ContaReceberHelper();

            $registro = $objCobReceberHelper->json($data);

            \DB::commit();


            return response()->json(['mensagem' => $registro, 'class' => 'success'], 201);
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            $msg = $e->getMessage();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $idAssistente)
    {
        $dadosRequest = $request->all();

        $callBack = $dadosRequest['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';
        return view('admin.cobranca_receber.create', compact('callBack', 'idAssistente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $this->validaRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();

            $pessoa = Pessoa::where('active', '=', 'yes')->where('id', '=', $dados['pessoa_id'])->first();
            if (!$pessoa) {
                throw new CobrancaReceberException('Pessoa não identificada. Tente novamente ou entre em contato com o suporte.');
            }

            $vrCobranca   = Utilitarios::removeMaskMoney($dados['vrLiquido']);

            $cobRecebHelper = new ContaReceberHelper();
            $erros = $cobRecebHelper->validaGerCobranca($pessoa->id, $vrCobranca, $dados['forma_pagamento_id'], $dados['plano_pagamento_id'], $dados['operador_financeiro_id'] ?? 0, []);
        
            if( (is_array($erros) && count($erros) > 0) ){
                throw new CobrancaReceberException(implode('<br/>', $erros));
            }

            $cobRecebHelper = new ContaReceberHelper();
            
            $dadosRequest=[
                'filial_id'=>$dados['filial_id'],
                'referencia'=>'sem_refe',
                'referencia_id'=>date('ymdhms'),
                'documento'=>$dados['documento'],
                'descricao'=>$dados['descricao'],
                'responsavel_id'=>\Auth::User()->pessoa->id,
        
            ];
            $registro = $cobRecebHelper->gerarCobranca($pessoa->id, $vrCobranca, $dados['forma_pagamento_id'], $dados['plano_pagamento_id'], $dados['operador_financeiro_id'] ?? 0, $dadosRequest);


            \DB::commit();

            if ($registro) {
                return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
            } else {
                throw new CobrancaReceberException('Erro ao cadastrar');
            }
        } catch (CobrancaReceberException $e) {
            \DB::rollback();
            return response()->json(['mensagem' =>$e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 400);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage(). ' ' . $e->getLine() . ' ' . $e->getFile(), 'class' => 'warning'], 500);
        }

    }

    public function baixar(Request $request, $id, $idAssistente=0){

        
        try {


            //$this->validaRequest($request);

            \DB::beginTransaction();

            $objCobReceberHelper = new ContaReceberHelper();

            $data       = $request->all();
            $registro   = $objCobReceberHelper->baixar($data, $id);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (CobrancaReceberException $th) {

            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor: '.$th->getMessage().' - '.$th->getLine().' - '.$th->getFile(), 'class' => 'warning'], 500);
            //throw $th;
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

    public function info(Request $request, $id, $idAssistente = 0)
    {

        try {

            \DB::beginTransaction();
            $objCobReceberHelper = new ContaReceberHelper();

            $data = $request->all();
            $registro = $objCobReceberHelper->info($data, $id, $idAssistente);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 201);
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            $msg = $e->getMessage();
            return response()->json(['errors' => ['error' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id, $idAssistente)
    {
        try {

            $dadosRequest = $request->all();

            $callBack = $dadosRequest['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';
            if (!isset($id)) {
                $id = isset($dadosRequest['id']) ? $dadosRequest['id'] : 0;
            }

            if ($id <= 0) {
                throw new CobrancaReceberException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = CobrancaReceber::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if ($registro == null) {
                throw new CobrancaReceberException('Registro não encontrado');
            }

            \DB::commit();

            return view('admin.cobranca_receber.edit', compact('registro', 'idAssistente', 'callBack'));
        } catch (CobrancaReceberException $e) {

            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

        } catch (\Exception $e) {
            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));
            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

        }
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
        try {


            //$this->validaRequest($request);

            \DB::beginTransaction();

            $objCobReceberHelper = new ContaReceberHelper();

            $data       = $request->all();
            $registro   = $objCobReceberHelper->update($data, $id);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (CobrancaReceberException $th) {

            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            \DB::beginTransaction();

            $dadosRequest = [];

            $dadosRequest['user_update_id']     = \Auth::User()->id; //trocar pelo id do usuario logado
            $dadosRequest['active']             = 'no';
            $registro = CobrancaReceber::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if (!$registro) {
                throw new CobrancaReceberException('Registro não identificado');
            }

            $registro->update($dadosRequest);
            $registro->delete();

            \DB::commit();

            return response()->json(['mensagem' => [], 'class' => 'sucess'], 200);
        } catch (CobrancaReceberException $th) {

            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
            //throw $th;
        }
    }

    public function head(Request $request)
    {
        $dados = $request->all();

        $isReload = isset($dados['isReload']) && $dados['isReload'] == true ? $dados['isReload'] : false;
        if ($isReload) {

            return view('admin.cobranca_receber.head_refresh', compact('isReload'));
        } else {
            return view('admin.cobranca_receber.head', compact('isReload'));
        }
    }

    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descricao' => 'required|max:255|min:2',
            'pessoa_id' => 'required|min:1',
            'vrBruto'   => 'required',
        ], [
            'descricao.required' => 'Informe uma descrição para o contas a receber.',
            'descricao.max' => 'A descrição deve ter até :max caracteres.',
            'descricao.min' => 'A descrição deve conter pelo menos :min caracteres.',
            'pessoa_id.required' => 'Informe o código da pessoa titular do conta a receber.',
            'pessoa_id.min' => 'O código da pessoa deve ter pelo menos  :min caracteres.',
            'vrBruto.required' => 'Informe o valor bruto do contas a receber.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new CobrancaReceberException($msg);
        }

        return true;
    }
}
