<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogradouroRequest;
use App\Logradouro;
use App\Pessoa;
use App\Utilitarios;
use Illuminate\Http\Request;

class LogradouroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {

            $registro = null;
            \DB::transaction(function () use (&$registro) {

                $registro = Logradouro::where('active', '=', 'yes')->get();

            });

            //dd($registro[0]->name);

            return view('admin.logradouro.index', compact('registro'));

        } catch (\Exception $e) {

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if ($id <= 0) {
            return response()->json(['errors' => ['params' => 'Parâmetro inválido']], 400);
        }

        $registro = null;
        \DB::transaction(function () use (&$registro, &$id) {
            $pessoa = Pessoa::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if ($pessoa) {
                $registro = $pessoa;
            }
        });

        if (! $registro) {
            return response()->json(['errors' => ['erro' => 'Pessoa não didentificada']], 404);
        }
        return view('admin.logradouro.create', compact('registro'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LogradouroRequest $request, $id)
    {

        try {

            if ((!isset($id)) || ($id <= 0)) {
                return response()->json(['errors' => ['param' => 'Parâmetro inválido']], 400);
            }

            $validator = $request->validated();

            $pessoa 	= Pessoa::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if (! $pessoa) {
                return response()->json(['errors' => ['param' => 'Parâmetro inválido']], 400);
            }

            $registro   = null;
            $erros      = [];

            \DB::transaction(function () use (&$request, &$registro, &$erros, &$pessoa) {

                $dados = $request->all();
                $user_id = \Auth::User()->id;

                $dadosLogradoruo = $request->only(
                    'cep',
                    'logradouro',
                    'numero',
                    'tipo',
                    'complemento',
                    'bairro',
                    'cidade',
                    'estado',
                    'bloco'
                );
                $dadosLogradoruo['user_id']  = $user_id;
                $dadosLogradoruo['active']   = 'yes';
                $dadosLogradoruo['importancia']   = 'principal';

                $cpf = preg_replace('/[^0-9]/', '', trim($dadosLogradoruo['cep']));
                if (strlen($cpf) < 8) {
                    $erros['cep'] = 'Cep inválido';
                } else {

                    $logradouro         = Logradouro::create($dadosLogradoruo);
                    $resultLogradouro   = $pessoa->adicionarLogradouro($logradouro, ['active' => 'yes','user_id' => $user_id]);

                    if ($logradouro) {
                        $registro = $pessoa;
                    }

                }

            });

            if ($registro) {

                //\Session::flash('mensagem', ['msg'=>'Registro salvo com sucesso', 'class'=>'alert alert-success']);
                //return redirect()->route('pessoa.head');

                return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);

            } elseif ($erros) {

                //\Session::flash('mensagem', ['msg'=>'Erro ao salvar o registro', 'class'=>'alert alert-warning']);

                //return redirect()->back();
                return response()->json(['errors' => $erros, 'class' => 'warning'], 400);

            } else {

                //\Session::flash('mensagem', ['msg'=>'Erro ao salvar o registro', 'class'=>'alert alert-warning']);

                //return redirect()->back();
                return response()->json(['errors' => ['erro' => 'Erro ao salvar o registro'], 'class' => 'warning'], 400);
            }

        } catch (\Exception $e) {

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

            return response()->json(['errors' => ['erro' => $e->getMessage()], 'class' => 'warning'], 500);

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
        try {

            if ($id <= 0) {

                \Session::flash('mensagem', ['msg' => 'Parâmetro ínválido', 'class' => 'alert alert-danger']);

                //return redirect()->route('pessoa.index');

                return  response()->json(['mensagem' => 'Erro, parâmetro inválido', 'class' => 'warning'], 400);

            }

            $registro = null;

            \DB::transaction(function () use (&$id, &$registro) {

                $registro = Pessoa::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            });

            //dd($registro);

            if ($registro == null) {

                //\Session::flash('mensagem', ['msg'=>'Marca não encontrada', 'class'=>'alert alert-danger']);
                //return redirect()->back();

                return response()->json(['mensagem' => 'Erro, registro não encontrado', 'class' => 'warning'], 400);
            }


            //return view('admin.produto.info', compact('registro'));
            return view('admin.pessoa.show', compact('registro'));

        } catch (\Exception $e) {

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);

        }
    }


    public function info($id, $idPessoa)
    {

        try {

            if (($id <= 0) || ($idPessoa <= 0)) {

                \Session::flash('mensagem', ['msg' => 'Parâmetro ínválido', 'class' => 'alert alert-danger']);

                //return redirect()->route('pessoa.index');

                return  response()->json(['mensagem' => 'Erro, parâmetro inválido', 'class' => 'warning'], 400);

            }

            $registro = null;
            $pessoa   = null;

            \DB::transaction(function () use (&$id, &$idPessoa, &$registro, &$pessoa) {

                $pessoa = Pessoa::where('active', '=', 'yes')
                ->where('id', '=', $idPessoa)->first();
                $registro = $pessoa->logradouro->where('active', '=', 'yes')->where('id', '=', $id)->first();

            });

            if ((! $registro) || (! $pessoa)) {

                //\Session::flash('mensagem', ['msg'=>'Marca não encontrada', 'class'=>'alert alert-danger']);
                //return redirect()->back();

                return response()->json(['errors' => ['params' => 'Erro, registro não encontrado'], 'class' => 'warning'], 400);
            }


            //return view('admin.produto.info', compact('registro'));
            return view('admin.logradouro.info', compact('registro', 'pessoa'));

        } catch (\Exception $e) {

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $idPessoa)
    {

        try {

            $registro   = null;
            $pessoa 	= null;
            $erros 		= [];

            if (($idPessoa <= 0) || ($id <= 0)) {
                return response()->json(['errors' => ['params' => 'Parâmetro inválido']], 400);
            }

            \DB::transaction(function () use (&$id, &$idPessoa, &$registro, &$grupos, &$erros, &$pessoa) {

                $pessoa = Pessoa::where('active', '=', 'yes')->where('id', '=', $idPessoa)->first();
                if (! $pessoa) {
                    $erros['pessoa'] = 'Pessoa não reconhecida';
                }

                $registro = $pessoa->logradouro->where('id', '=', $id)->where('active', '=', 'yes')->first();
                if (! $registro) {
                    $erros['logradouro'] = 'Logradouro não reconhecido';
                }

            });


            if (count($erros) > 0) {

                //\Session::flash('mensagem', ['msg'=>'Marca não encontrada', 'class'=>'alert alert-danger']);
                //return redirect()->back();
                return response()->json(['errors' => $erros, 'class' => 'warning'], 400);
            }


            return view('admin.logradouro.edit', compact('registro', 'pessoa'));


        } catch (\Exception $e) {

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LogradouroRequest $request, $id, $idPessoa)
    {
        try {

            if (($id <= 0) || ($idPessoa <= 0)) {

                return response()->json(['errors' => ['params' => 'Parâmetro inválido']], 400);
            }

            $validator = $request->validated();

            $registro   = null;
            $user_id    = \Auth::User()->id;
            $erros      = [];
            \DB::transaction(function () use (&$request, &$registro, &$erros, &$id, &$user_id, &$idPessoa) {

                $dados = $request->all();
                $pessoa = Pessoa::where('id', '=', $idPessoa)->where('active', '=', 'yes')->first();
                if ($pessoa) {

                    $logradouro = $pessoa->logradouro->where('active', '=', 'yes')->where('id', '=', $id)->first();
                    if ($logradouro) {

                        $dadosLogradoruo = $request->only(
                            'cep',
                            'logradouro',
                            'numero',
                            'tipo',
                            'complemento',
                            'bairro',
                            'cidade',
                            'estado',
                            'bloco'
                        );
                        $dadosLogradoruo['user_update_id']  = $user_id;

                        $resultUpdate = $logradouro->update($dadosLogradoruo);
                        if ($resultUpdate) {
                            $registro = $resultUpdate;
                        }

                    } else {
                        $erros[] = 'Logradouro não identificado';
                    }

                } else {

                    $erros[] = 'Pessoa não identificada';

                }


            });

            if ($registro) {

                //\Session::flash('mensagem', ['msg'=>'Registro salvo com sucesso', 'class'=>'alert alert-success']);
                //return redirect()->route('pessoa.head');

                return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);

            } elseif ($erros) {

                //\Session::flash('mensagem', ['msg'=>'Erro ao salvar o registro', 'class'=>'alert alert-warning']);

                //return redirect()->back();
                return response()->json(['errors' => $erros, 'class' => 'warning'], 400);

            } else {

                //\Session::flash('mensagem', ['msg'=>'Erro ao salvar o registro', 'class'=>'alert alert-warning']);

                //return redirect()->back();
                return response()->json(['errors' => ['erro' => 'Erro ao atualizar o registro'], 'class' => 'warning'], 400);
            }

        } catch (\Exception $e) {

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

            return response()->json(['errors' => ['erro' => $e->getMessage()], 'class' => 'warning'], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $idPessoa)
    {
        try {

            if (($id <= 0) || ($idPessoa <= 0)) {

                // \Session::flash('mensagem', ['msg'=>'Parâmetro ínválido', 'class'=>'alert alert-danger']);

                //return redirect()->route('pessoa.index');
                return response()->json(['errors' => ['params' => 'Parâmetro inválido'], 'class' => 'warning'], 400);

            } else {

                $registro = null;

                \DB::transaction(function () use (&$id, &$idPessoa, &$registro) {

                    $pessoa = Pessoa::where('active', '=', 'yes')
                    ->where('id', '=', $idPessoa)->first();
                    if ($pessoa) {

                        $logradouro = $pessoa->logradouro->where('active', '=', 'yes')->where('id', '=', $id)->first();
                        if ($logradouro) {
                            $registro = $logradouro;
                            $logradouro->update(['active' => 'no']);
                        }

                    }

                });

                if ($registro == null) {

                    //\Session::flash('mensagem', ['msg'=>'Registro não encontrado', 'class'=>'alert alert-danger']);
                    //return redirect()->back();
                    return response()->json(['errors' => ['erro' => 'Erro ao deletar registro afaf'], 'class' => 'warning'], 400);
                } else {
                    return response()->json(['mensagem' => 'Registro deletado com sucesso', 'class' => 'success'], 200);
                }

            }

        } catch (\Exception $e) {

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

            return response()->json(['errors' => ['erro' => 'Algo errado aconteceu no servidor'], 'class' => 'warning'], 500);

        }
    }

    public function head()
    {

        //return view('admin.pessoa.head');
    }

    public function loadLogradouroApi(Request $request)
    {
        try {

            $dados = $request->only('cep');
            if ($dados) {

                $logradouro = Utilitarios::loadEnderecoApi($dados['cep']);
                if ($logradouro == false) {

                    return response()->json(['mensagem' => 'Cep inválido', 'class' => 'success'], 400);
                }
                return response()->json(['mensagem' => $logradouro, 'class' => 'success'], 200);
            }

            return response()->json(['mensagem' => 'Cep inválido', 'class' => 'success'], 400);

        } catch (\Exception $e) {
            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 500);
        }

    }


}
