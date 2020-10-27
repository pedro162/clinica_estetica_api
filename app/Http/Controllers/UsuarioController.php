<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests\UsuarioRequest;
use \Auth;
use App\User;
//aula 4 api_restful ok //instalar o postman
class UsuarioController extends Controller
{
    public function login(Request $request)
    {
        try {

            $dados = $request->only('email', 'password');
            $autenticado =false;
            \DB::transaction(function() use (&$dados){
                if(Auth::attempt(['email'=>$dados['email'], 'password'=>$dados['password']])){
                    $autenticado = true;
                }


            });
            return redirect()->route('produto.head');

             \Session::flash('mensagem', ['msg'=>'Usuario ou senha inválidos', 'class'=>'alert alert-warning']);
                return redirect()->route('admin.login');
            
        } catch (\Exception $e) {
            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);
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

            \DB::transaction(function() use (&$registos){
                if(auth()->user()->can('usuario_listar')){
                    $registos = User::All();
                }         
            });
            
            return view('admin.usuarios.index', compact('registos'));
            
        } catch (\Exception $e) {
            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);
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

            \DB::transaction(function() use (&$dados, &$registro){
                $registro = User::create($dados);
                
            });

            if($registro){
                return response()->json(['mensagem'=>$registro, 'class' =>'success'], 201);
            }else{
                return response()->json(['mensagem'=>'Erro ao criar registro', 'class' => 'warning'], 400);
            }
            
        } catch (\Exception $e) {
            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);
        }
    }


    public function editar($id)
    {
        try {
            $usuario = null;
            \DB::transaction(function() use (&$id, &$usuario){
                $usuario = User::find($id);

            });

            return view('admin.usuarios.editar', compact('usuario'));

        } catch (\Exception $e) {
            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);
        }
    }


    public function atualizar($request, $id)
    {
        $usuario = User::find($id);
        $dados = $request->all();

        if(isset($dados['password']) && strlen('password') > 5){
            $dados['password'] = bcrypt($dados['password']);
        }else{
            unset($dados['password']);
        }

        $usuario->update($dados);
    }

    public function deletar($id)
    {
        User::find($id)->delete();
        \Session::flash('mensagem', ['msg'=>'Registro atualizado com sucesso!', 'class'=>'success']);
        return redirect('admin.usurarios');
    }

}
