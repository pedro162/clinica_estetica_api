<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\OrdemServicoException;
use App\Helpers\OrdemServicoHelper;
use App\Http\Controllers\Controller;
use App\OrdemServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdemServicoController extends Controller
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

            $objOrdemHelper = new OrdemServicoHelper();

            $form = $objOrdemHelper->store($dados);

            \DB::commit();

            return response()->json(['mensagem' => $form, 'class' => 'success'], 200);
        } catch (OrdemServicoException $e) {
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function concluir(Request $request, $id)
    {

        try {


            $this->validaRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();
            $objOrdemHelper = new OrdemServicoHelper();
            $registro       = $objOrdemHelper->concluir($dados, $id);

            if (!$registro) {
                throw new OrdemServicoException('Não foi possível gerar o financeiro da ordem de serviço. Tente novamente ou entre em contato com o suporte.');
            }

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (OrdemServicoException $e) {
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancelar(Request $request, $id)
    {

        try {


            $this->validaCancelarRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();

            $objOrdemHelper         = new OrdemServicoHelper();
            $registro = $objOrdemHelper->cancelar($dados, $id);

            \DB::commit();
            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (OrdemServicoException $e) {
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

            $objOrdemHelper = new OrdemServicoHelper();
            $registro       = $objOrdemHelper->info($dados, $id);

            if ($registro == null) {
                throw new OrdemServicoException(' não encontrado');
            }

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (OrdemServicoException $e) {
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

            $objOrdemHelper = new OrdemServicoHelper();
            $registro       = $objOrdemHelper->update($dados, $id);

            if (!$registro) {
                throw new OrdemServicoException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte');
            }


            \DB::commit();
            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (OrdemServicoException $e) {
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function finalizar(Request $request, $id)
    {
        try {

            $this->validaRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();

            $id             = $id ?? $dados['id'];

            $objOrdemHelper = new OrdemServicoHelper();
            $registro       = $objOrdemHelper->finalizar($dados, $id);

            if (!$registro) {
                throw new OrdemServicoException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte');
            }


            \DB::commit();
            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (OrdemServicoException $e) {
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function finalizarProcedimento(Request $request, $id)
    {
        try {

            //$this->validaRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();

            $id             = $id ?? $dados['id'];
            $callBack       = $dados['callBack'] ?? '';
            $idAssistente   =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if ((!isset($id)) || ($id <= 0)) {
                throw new OrdemServicoException('Parâmetro inválido');
            }

            $registro = OrdemServico::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if (!$registro) {
                throw new OrdemServicoException('Registro não encontrado');
            }

            $objOrdemHelper = new OrdemServicoHelper();
            $objOrdemHelper->marcarFinalizada($registro);
            //td_conclusao
            if (!$registro) {
                throw new OrdemServicoException('Registro não encontrado');
            }


            \DB::commit();
            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (OrdemServicoException $e) {
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adicionarItem(Request $request, $id)
    {
        try {

            $this->validaAddItemRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();

            $id             = $id ?? $dados['id'];


            $objOrdemHelper = new OrdemServicoHelper();
            $registro = $objOrdemHelper->adicionarItem($dados, $id);
            //td_conclusao
            if (!$registro) {
                throw new OrdemServicoException('Registro não encontrado');
            }


            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (OrdemServicoException $e) {
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
    public function removerItem($id)
    {
        try {

            \DB::beginTransaction();

            if ($id <= 0) {
                throw new OrdemServicoException('Parâmetro inválido.');
            }

            $objOrdemHelper = new OrdemServicoHelper();
            $registro       = $objOrdemHelper->removerItem($id);

            if (!$registro) {
                throw new OrdemServicoException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte');
            }

            \DB::commit();

            return response()->json(['mensagem' => 'Registro deletado com sucesso', 'class' => 'success'], 200);
        } catch (OrdemServicoException $e) {
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function recalcularOrdemServico($id)
    {


        if ((!isset($id)) || ($id <= 0)) {
            throw new OrdemServicoException('Parâmetro inválido');
        }

        $registro = OrdemServico::where('active', '=', 'yes')->where('id', '=', $id)->first();
        if (!$registro) {
            throw new OrdemServicoException('Ordem de serviço não identificada. Tente novamente ou entre em contato com o suporte.');
        }

        $servicosArr = $registro->item()->where('active', '=', 'yes')->get();
        if (!$servicosArr) {
            throw new OrdemServicoException('Servições não identificados. Tente novamente ou entre em contato com o suporte.');
        }
        $vrTotSevicos       = 0;
        $vrTotDesconto      = 0;
        $vrTotServicoFinal  = 0;

        foreach ($servicosArr as $item) {

            $vrTotSevicos       += $item->vrTotal;
            $vrTotDesconto      += $item->vr_desconto;
            $vrTotServicoFinal  += $item->vr_final;
        }


        $dadosRequest = [];
        $dadosRequest['vrTotal']          = $vrTotSevicos;
        $dadosRequest['vr_final']         = $vrTotServicoFinal;
        $dadosRequest['vr_desconto']      = $vrTotDesconto;
        $dadosRequest['pct_desconto']     = ($vrTotDesconto / $vrTotSevicos) * 100;
        $dadosRequest['pct_acrescimo']    = 0;
        $dadosRequest['vr_acrescimo']     = 0;
        $dadosRequest['user_update_id']         = \Auth::User()->id;
        $registro->update($dadosRequest);


        if (!$registro) {
            throw new OrdemServicoException('Registro não encontrado');
        }

        return $registro;
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


            $objOrdemHelper = new OrdemServicoHelper();
            $registro       = $objOrdemHelper->destroy($id);

            if (!$registro) {
                throw new OrdemServicoException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte');
            }

            \DB::commit();

            return response()->json(['mensagem' => 'Registro deletado com sucesso', 'class' => 'success'], 200);
        } catch (OrdemServicoException $e) {
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
            $objOrdemHelper = new OrdemServicoHelper();
            $registro       = $objOrdemHelper->json($consulta);


            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 201);
        } catch (OrdemServicoException $e) {
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
            'filial_id' => 'required|min:1',
            'pessoa_id' => 'required|min:1',
            'rca_id' => 'required|min:1',
        ], [
            'filial_id.required' => 'O campo "Filial" é obrigatório.',
            'filial_id.min' => 'O "Filial" deve conter pelo menos :min caracteres.',
            'pessoa_id.required' => 'O campo "Pessoa" é obrigatório.',
            'pessoa_id.min' => 'O "Pessoa" deve conter pelo menos :min caracteres.',
            'rca_id.required' => 'O campo "Vendedor" é obrigatório.',
            'rca_id.min' => 'O "Vendedor" deve conter pelo menos :min caracteres.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new OrdemServicoException($msg);
        }

        return true;
    }

    protected function validaAddItemRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'servico_id' => 'required|min:1',
            'qtd' => 'required|min:1',
            'vrItem' => 'required|min:0.01',
            'pct_desconto' => 'max:100',
        ], [
            'servico_id.required' => 'O campo "Serviço" é obrigatório.',
            'servico_id.min' => 'O "Serviço" deve conter pelo menos :min caracteres.',
            'qtd.required' => 'O campo "Quantidade" é obrigatório.',
            'qtd.min' => 'O "Quantidade" deve conter pelo menos :min caracteres.',
            'vrItem.required' => 'O campo "Valor" é obrigatório.',
            'vrItem.min' => 'O "Valor" deve conter pelo menos :min caracteres.',
            'pct_desconto.max' => 'O campo "Desconto" permite até :max %.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new OrdemServicoException($msg);
        }

        return true;
    }

    protected function validaCancelarRequest(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'motivo_cancel_id' => 'required|min:',
        ], [
            'motivo_cancel_id.required' => 'O campo "Motivo de cancelamento" é obrigatório.',
            'motivo_cancel_id.min' => 'O "Motivo de cancelamento" deve ser maior ou igual a :min.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new OrdemServicoException($msg);
        }

        return true;
    }
}
