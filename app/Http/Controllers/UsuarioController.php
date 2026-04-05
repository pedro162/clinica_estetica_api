<?php

namespace App\Http\Controllers;

use App\Exceptions\ContaException;
use App\Http\Requests\UsuarioRequest;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

//aula 4 api_restful ok //instalar o postman
class UsuarioController extends Controller
{
    public function login(Request $request)
    {
        try {
            $dados = $request->only('email', 'password');
            $autenticado = false;

            DB::transaction(function () use (&$dados) {
                if (Auth::attempt(['email' => $dados['email'], 'password' => $dados['password']])) {
                    $autenticado = true;
                }
            });

            return redirect()->route('produto.head');

            Session::flash('mensagem', [
                'msg' => 'Usuario ou senha inválidos',
                'class' => 'alert alert-warning'
            ]);

            return redirect()->route('admin.login');
        } catch (\Exception $e) {
            return response()->json([
                'mensagem' => 'Algo errado aconteceu no servidor',
                'class' => 'warning'
            ], 500);
        }
    }

    public function logarApi(Request $request)
    {
        try {
            set_time_limit(9000000);

            DB::beginTransaction();

            $dados = $request->only('email', 'password');
            $autenticado = false;

            if (Auth::attempt(['email' => $dados['email'], 'password' => $dados['password']])) {
                $autenticado = true;
            } else {
                throw new Exception('Não autorizado');
            }

            $user = User::where('email', '=', $dados['email'])->first();

            DB::commit();

            return response()->json([
                'mensagem' => $user,
                'class' => 'success'
            ], 200);
        } catch (\Error $e) {
            DB::rollback();
            return response()->json([
                'mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()
            ], 404);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()
            ], 500);
        }
    }

    public function sair()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function index()
    {
        try {
            $registos = null;

            DB::transaction(function () use (&$registos) {
                if (auth()->user()->can('usuario_listar')) {
                    $registos = User::All();
                }
            });

            return view('admin.usuarios.index', compact('registos'));
        } catch (\Exception $e) {
            return response()->json([
                'mensagem' => 'Algo errado aconteceu no servidor',
                'class' => 'warning'
            ], 500);
        }
    }

    public function adicionar()
    {
        return view('admin.usurarios.adicionar');
    }

    public function salvar(UsuarioRequest $request)
    {
        try {
            $dados      = $request->only('name', 'email', 'password');
            $registro   = null;

            DB::transaction(function () use (&$dados, &$registro) {
                $registro = User::create($dados);
            });

            if ($registro) {
                return response()->json([
                    'mensagem' => $registro,
                    'class' => 'success'
                ], 201);
            } else {
                return response()->json([
                    'mensagem' => 'Erro ao criar registro',
                    'class' => 'warning'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'mensagem' => 'Algo errado aconteceu no servidor',
                'class' => 'warning'
            ], 500);
        }
    }

    public function editar($id)
    {
        try {
            $usuario = null;

            DB::transaction(function () use (&$id, &$usuario) {
                $usuario = User::find($id);
            });

            return view('admin.usuarios.editar', compact('usuario'));
        } catch (\Exception $e) {
            return response()->json([
                'mensagem' => 'Algo errado aconteceu no servidor',
                'class' => 'warning'
            ], 500);
        }
    }

    public function json(Request $request)
    {
        try {
            DB::beginTransaction();

            $consulta = $request->all();
            $campos =  null;
            $parse = [
                'user_name' => 'users.name'
            ];

            $registro = DB::table('users');

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
                                $registro->whereIn('users.id', $val);
                            }
                            break;
                        case 'name':
                            if (is_string($val)) {
                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }

                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('users.name', 'like', '%' . $val . '%');
                            }
                            break;
                        case 'user.id':
                            if (is_string($val)) {
                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }

                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('users.id', '=', '' . $val . '');
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
                            }
                            break;
                    }
                }
            }

            if ($campos) {
                $registro->select($campos);
            } else {
                $registro->select('users.*');
            }

            $registro = $registro->where('users.active', '=', 'yes')->get();

            DB::commit();

            return response()->json([
                'registro' => $registro,
                'class' => 'sucess'
            ], 201);
        } catch (ContaException $e) {
            DB::rollback();

            return response()->json([
                'mensagem' => $e->getMessage(),
                'class' => 'warning'
            ], 400);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'mensagem' => $e->getMessage(),
                'class' => 'warning'
            ], 400);
        }
    }

    public function atualizar($request, $id)
    {
        $usuario = User::find($id);
        $dados = $request->all();

        if (isset($dados['password']) && strlen('password') > 5) {
            $dados['password'] = bcrypt($dados['password']);
        } else {
            unset($dados['password']);
        }

        $usuario->update($dados);
    }

    public function deletar($id)
    {
        User::find($id)->delete();
        Session::flash('mensagem', ['msg' => 'Registro atualizado com sucesso!', 'class' => 'success']);
        return redirect('admin.usurarios');
    }
}
