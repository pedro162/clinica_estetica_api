<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\FilialException;
use \App\Filial;
use \App\Pessoa;
use \App\Helpers\FilialHelper;

class FilialController extends Controller
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

            $consulta = $request->all();

            $campos =  null;

            $registro = Filial::where('active', '=', 'yes')
            ->join('pessoas', function ($join) {
                $join->on('pessoas.id', '=', 'filials.pessoa_id');
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

                                $registro->whereIn('id', $val);
                            }
                            break;
                        case 'name':
                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('name', 'like', '%' . $val . '%');
                            break;
                    }
                }
            }

            $registro = $registro->get();

            return view('admin.filial.index', compact('registro', 'consulta'));

            \DB::commit();
        } catch (FilialException $e) {
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

    public function json(Request $request)
    {

        try {
            \DB::beginTransaction();

            $consulta = $request->all();
            

            $objFilialHelper    = new FilialHelper();
            $registro           = $objFilialHelper->json($consulta);
            if (!$registro) {
                throw new PaisException('Registro não identifiado');
            }            

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (FilialException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 500);
        }
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


            $validator = $this->validaRequest($request);

            $registro = null;
            \DB::beginTransaction();

            $dados = $request->all();

            $objFilialHelper = new FilialHelper();
            $registro       = $objFilialHelper->store($dados);

            if (!$registro) {
                throw new FilialException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o supote.');
            }


            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (FilialException $th) {

            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor: ' . $th->getMessage(), 'class' => 'warning'], 500);
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
        
    }


    public function info(Request $request, $id)
    {

        try {

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            \DB::beginTransaction();

            $objFilialHelper = new FilialHelper();
            $registro       = $objFilialHelper->info($dados, $id);

            if ($registro == null) {
                throw new PaisException('Registro não encontrado');
            }
            //dd($registro);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (FilialException $e) {
            \DB::rollback();

            //$msg = $e->getMessage();
            //return view('layouts._admin._error', compact('msg'));

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);
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

            if ($id <= 0) {
                throw new FilialException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Filial::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if (!$registro) {
                throw new FilialException('Registro não encontrado');
            }

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (FilialException $e) {

            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));

            // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
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

            $this->validaRequest($request);

            \DB::beginTransaction();



            $registro   = null;
            $user_id    = \Auth::User()->id;
            $erros      = [];

            $dados = $request->all();

            $user_id        = \Auth::User()->id;
            $pessoa         = Pessoa::where('active', '=', 'yes')->where('id', '=', $dados['pessoa_id'])->first();
            $registro       = Filial::where('id', '=', $id)->where('active', '=', 'yes')->first();
            $pessoaFilial   = Filial::where('pessoa_id', '=', $dados['pessoa_id'])->where('active', '=', 'yes')->first();

            if (!$registro) {
                $erros[] = "Registro não identificado";
            }

            if (!$pessoa) {
                $erros[] = "Pessoa não identificada";
            }

            if ($registro && $pessoaFilial && $registro->id != $pessoaFilial->id) {
                $erros[] = "Já existe uma pessoa para esta filial";
            }

            if ($erros) {

                throw new FilialException(implode("<br/><br/>", $erros));
            }

            $dadosFilial                        = [];
            $dadosFilial['user_update_id']      = \Auth::User()->id;
            $dadosFilial['pessoa_id']           = $pessoa->id;
            $dadosFilial['dsAtividade']         = $dados['dsAtividade'] ?? 'comercio';
            $dadosFilial['dsTextoContrato']     = $dados['dsTextoContrato'] ?? null;
            $dadosFilial['active']              = 'yes';

            $registro->update($dadosFilial);

            if (!$registro) {
                throw new FilialException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o supote.');
            }

            \DB::commit();
            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (FilialException $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 500);

            // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 500);

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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

            if ($id <= 0) {

                // \Session::flash('mensagem', ['msg'=>'Parâmetro ínválido', 'class'=>'alert alert-danger']);

                //return redirect()->route('filial.index');
                return response()->json(['mensagem' => 'Erro ao deletar registro', 'class' => 'warning'], 400);
            }

            \DB::beginTransaction();

            $pessoa = Filial::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();
            if (!$pessoa) {
                throw new FilialException('Registro não encontrado');
            }

            $pessoa->update(['active' => 'no']);
            $pessoa->delete();

            \DB::commit();
            return response()->json(['mensagem' => 'Registro atulizado com sucesso', 'class' => 'success']);
        } catch (FilialException $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 500);

            // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 500);

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }

    public function head(Request $request)
    {
        $dados = $request->all();

        $isReload = isset($dados['isReload']) && $dados['isReload'] == true ? $dados['isReload'] : false;
        if ($isReload) {

            return view('admin.filial.head_refresh', compact('isReload'));
        } else {
            return view('admin.filial.head', compact('isReload'));
        }
    }


    public function validarCpf($cpf)
    {
        $result = Utilitarios::validaCpf($cpf);

        if ($result == true) {
            return response()->json(['mensagem' => 'Cpf ok', 'class' => 'success'], 200);
        }

        return response()->json(['mensagem' => 'Cpf inválido', 'class' => 'warning'], 400);
    }


    public function adicionarPlano($id)
    {
        try {

            if ((!isset($id)) || ($id <= 0)) {
                return response()->json(['errors' => ['params' => 'Parametro inválido']], 400);
            }

            $registro           = null;
            $formaPagamento     = null;
            $planoPagamento     = null;
            $operadorFinanceiro = null;
            $plano              = null;
            \DB::transaction(function () use (&$id, &$registro, &$formaPagamento, &$planoPagamento, &$operadorFinanceiro, &$plano) {
                $registro = Filial::where('active', '=', 'yes')->where('id', '=', $id)->first();

                $formaPagamento         = FormaPagamento::where('active', '=', 'yes')->get();
                $planoPagamento         = PlanoPagamento::where('active', '=', 'yes')->get();
                $operadorFinanceiro     = OperadorFinanceiro::where('active', '=', 'yes')->get();
                $plano                  = Plano::where('active', '=', 'yes')->get();
            });

            if (($registro == null) || ($formaPagamento == null) || ($plano == null)) {
                return response()->json(['errors' => ['erro' => 'Erro ao carregar o registro'], 'class' => 'warning'], 400);
            }
            return view('admin.plano.painelVenda', compact('registro', 'formaPagamento', 'planoPagamento', 'operadorFinanceiro', 'plano'));
        } catch (\Exception $e) {
            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor ' . $e->getMessage() . ' > ' . $e->getFile() . ' > ' . $e->getLine(), 'class' => 'warning'], 500);
        }
    }


    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pessoa_id' => 'required|min:1',
        ], [
            'pessoa_id.required' => 'O campo "Pessoa" é obrigatório.',
            'pessoa_id.min' => 'O "Pessoa" deve ser maior ou igua a :min caracteres.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new FilialException($msg);
        }

        return true;
    }
}
