<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Formulario;
use \App\Marca;
use \App\Categoria;
use \App\Exceptions\FinanceiroMovimentacoeException;
use \App\FormularioGrupo;
use \App\Servico;
use \App\FinanceiroMovimentacoe;
use \App\ServicoItem;
use \App\Pessoa;
use \App\Filial;
use \App\Profissional;
use \App\Rca;
use \App\Utilitarios;
use \App\MotivoCancelamentoFinanceiroMovimentacoe;
use \App\Helpers\FinanceiroMovimentacoeHelper;
use Illuminate\Support\Facades\Auth;

class MovimentacoesFinanceirasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $idAssistente)
    {
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


            set_time_limit(9000000);

            \DB::beginTransaction();

            $this->validaRequest($request);

            $dados = $request->all();

            $objOrdemHelper = new FinanceiroMovimentacoeHelper();

            $form = $objOrdemHelper->store($dados);

            \DB::commit();

            return response()->json(['mensagem' => $form, 'class' => 'success'], 200);
        } catch (FinanceiroMovimentacoeException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Error $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $idAssistente)
    {
    }


    public function info(Request $request, $id)
    {

        try {


            $dados = $request->all();
            $id = $id ?? $dados['id'];

            \DB::beginTransaction();

            $objOrdemHelper = new FinanceiroMovimentacoeHelper();
            $registro       = $objOrdemHelper->info($dados, $id);

            if ($registro == null) {
                throw new FinanceiroMovimentacoeException(' não encontrado');
            }

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (FinanceiroMovimentacoeException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Error $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 500);
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
            }
        } catch (\Exception $e) {

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

            $dados = $request->all();

            $objOrdemHelper = new FinanceiroMovimentacoeHelper();
            $registro       = $objOrdemHelper->update($dados, $id);

            if (!$registro) {
                throw new FinanceiroMovimentacoeException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte');
            }


            \DB::commit();
            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (FinanceiroMovimentacoeException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Error $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 500);
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

            if ($id <= 0) {
                return response()->json([['mensagem' => 'Parâmetro inválido', 'class' => 'warning'], 400]);
            }

           
            $objOrdemHelper = new FinanceiroMovimentacoeHelper();
            $registro       = $objOrdemHelper->destroy($id);

            if (!$registro) {
                throw new FinanceiroMovimentacoeException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte');
            }

            \DB::commit();

            return response()->json(['mensagem' => 'Registro deletado com sucesso', 'class' => 'success'], 200);


        } catch (FinanceiroMovimentacoeException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Error $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 500);
        }
    }

    public function head(Request $request)
    {
    }


    /**
     * Return a listing of the resource in json.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {
        try {

            //$this->validaRequest($request);

            \DB::beginTransaction();

            $consulta = $request->all();
            //dd($consulta);
            $objOrdemHelper = new FinanceiroMovimentacoeHelper();
            $registro       = $objOrdemHelper->json($consulta);


            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 201);
        } catch (FinanceiroMovimentacoeException $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
    }



    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'referencia_id' => 'required|min:1',
            'referencia' => 'required|min:1',
            'caixa_id' => 'required|min:1',
            'vr_movimentacao' => 'required|min:1',
        ], [
            'referencia_id.required' => 'O código de referência é obrigatório.',
            'referencia_id.min' => 'O código de referência deve conter pelo menos :min caracteres.',
            'referencia.required' => 'A referência é obrigatória.',
            'referencia.min' => 'A referência deve conter pelo menos :min caracteres.',
            'caixa_id.required' => 'O código do caixa é obrigatório.',
            'caixa_id.min' => 'O código do caixa deve conter pelo menos :min caracteres.',
            'vr_movimentacao.required' => 'O valor da movimentação é obrigatório.',
            'vr_movimentacao.min' => 'O valor da movimentação deve conter pelo menos :min caracteres.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new FinanceiroMovimentacoeException($msg);
        }

        return true;
    }

}
