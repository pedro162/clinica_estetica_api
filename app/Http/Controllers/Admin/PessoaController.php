<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Http\Requests\PessoaRequest;
use \App\Pessoa;
use \App\Grupo;
use \App\Telefone;
use \App\Logradouro;

class PessoaController extends Controller
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
    		\DB::transaction(function() use (&$registro){

    			$registro = Pessoa::where('active', '=', 'yes')->get();

    		});

            //dd($registro[0]->name);

            return view('admin.pessoa.index', compact('registro'));
    		
    	} catch (\Exception $e) {
    		 
    		//\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

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
    	$grupos = Grupo::where('active', '=', 'yes')->get();        
        return view('admin.pessoa.create', compact('grupos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PessoaRequest $request)
    {

        try{


            $validator = $request->validated();

            $registro = null;
            \DB::transaction(function() use (&$request, &$registro){

                $dados = $request->all();
                $user_id = \Auth::User()->id;

                $dadosPessoa     = $request->only(
                    'name','name_opcional','documento',
                    'documento_complementar','nascimento_fundacao',
                    'sexo', 'email');
                $dadosPessoa['user_id']     = \Auth::User()->id;
                $dadosPessoa['tipo']        = 'fisica';
                $dadosPessoa['active']      = 'yes';

                $grupo = Grupo::where('id', '=', $dados['groupo_id'])
                ->where('active', '=', 'yes')->first();


                $dadosLogradoruo = $request->only(
                    'cep','logradouro',
                    'numero','tipo',
                    'complemento','bairro',
                    'cidade','estado', 'bloco');
                $dadosLogradoruo['user_id']  = $user_id;
                $dadosLogradoruo['active']   = 'yes';
                $dadosLogradoruo['importancia']   = 'principal';


                $dadosContato       = $request->only('celular_1','celular_2','telefone');
               
                $pessoa             = Pessoa::create($dadosPessoa);
                $logradouro         = Logradouro::create($dadosLogradoruo);
                $resultLogradouro   = $pessoa->adicionarLogradouro($logradouro,['active'=>'yes','user_id'=>$user_id]);
                $resultGrupoPessoa  = $pessoa->adicionarGrupo($grupo,['active'=>'yes', 'user_id'=>$user_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);

                foreach ($dadosContato as $key => $value) {
                    $tipo = $key == 'telefone' ? 'fixo' : 'celular';
                    $contato        = Telefone::create([
                        'numero'=>$value ?? '00000000000', 'tipo'=>$tipo, 'user_id'=> $user_id,
                        'active' => 'yes', 'pessoa_id' => $pessoa->id
                    ]);
                }

                if( 
                    $pessoa
                    && $logradouro 
                    && $contato
                ){
                    $registro = $pessoa;
                }
                
                

            });

            if($registro){

                //\Session::flash('mensagem', ['msg'=>'Registro salvo com sucesso', 'class'=>'alert alert-success']);
                //return redirect()->route('pessoa.head');

                return response()->json(['mensagem'=>$registro, 'class' => 'success'], 200);

            }else{

                //\Session::flash('mensagem', ['msg'=>'Erro ao salvar o registro', 'class'=>'alert alert-warning']);

                //return redirect()->back();
                return response()->json(['mensagem'=>'Erro ao salvar o registro', 'class'=>'warning'], 400);
            }

        }catch(\Exception $e){

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

            return response()->json(['mensagem'=>$e->getMessage(), 'class'=>'warning'], 500);

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


    public function info($id)
    {
        
        try{

            if($id <= 0){

                 \Session::flash('mensagem', ['msg'=>'Parâmetro ínválido', 'class'=>'alert alert-danger']);

                //return redirect()->route('pessoa.index');

                 return  response()->json(['mensagem'=>'Erro, parâmetro inválido', 'class'=>'warning'], 400);

            }

            $registro = null;

            \DB::transaction(function() use (&$id, &$registro){

                $registro = Pessoa::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();
        
            } );

            if($registro == null){

                //\Session::flash('mensagem', ['msg'=>'Marca não encontrada', 'class'=>'alert alert-danger']);
                //return redirect()->back();

                return response()->json(['mensagem'=>'Erro, registro não encontrado', 'class'=>'warning'], 400);
            }


            //return view('admin.produto.info', compact('registro'));
            return view('admin.pessoa.info', compact('registro'));

        }catch(\Exception $e){

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $registro   = null;
        $grupos     = null;

    	try {

    		if($id <= 0){

	             //\Session::flash('mensagem', ['msg'=>'Parâmetro ínválido', 'class'=>'alert alert-danger']);

	            //return redirect()->route('pessoa.index');

                return response()->json(['mensagem'=>'Erro, parâmetro inválido', 'class'=>'warning'], 400);

       		 }
    		
       		 \DB::transaction(function() use (&$id, &$registro, &$grupos){

	            $registro = Pessoa::where('active', '=', 'yes')
	                ->where('id', '=', $id)->first();

                $grupos = Grupo::where('active', '=', 'yes')->get();

	        } );


	        if(($registro == null) || ($grupos == null)){

	            //\Session::flash('mensagem', ['msg'=>'Marca não encontrada', 'class'=>'alert alert-danger']);
	            //return redirect()->back();
                return response()->json(['mensagem'=>'Erro, registro não encontrado', 'class'=>'warning'], 400);
	        }


	        return view('admin.pessoa.edit', compact('registro', 'grupos'));


    	} catch (\Exception $e) {

    		 //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);
    	}

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PessoaRequest $request, $id)
    {
        try{

            $validator = $request->validated();

            $dados      = $request->all();
            $registro   = null;
            $user_id    = \Auth::User()->id;

            \DB::transaction(function() use (&$dados, &$id, &$registro){

                $dadosRequest = [];

                $dadosRequest['name']               = $dados['name'];
                $dadosRequest['user_id']            = $user_id;//trocar pelo id do usuario logado
                $dadosRequest['active']             = 'yes';

                $pessoa = Pessoa::find($id);
                
                $registro = $pessoa->update($dadosRequest);

            });

            if($registro != null){

                //\Session::flash('mensagem', ['msg'=>'Registro atualizado com sucesso', 'class'=>'alert alert-success']);

                //return redirect()->route('pessoa.head');
                return response()->json(['mensagem'=>$registro, 'class'=>'success'], 200);
            }

            //\Session::flash('mensagem', ['msg'=>'Erroa ao atualizar registro', 'class'=>'alert alert-warning']);

                //return redirect()->route('pessoa.index');

            //return redirect()->back();

            return response()->json(['mensagem'=>'Erro ao atualizar registro', 'class'=>'warning'], 400);


        } catch (\Exception $e) {

             //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);
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
        try{

            if($id <= 0){

                // \Session::flash('mensagem', ['msg'=>'Parâmetro ínválido', 'class'=>'alert alert-danger']);

                //return redirect()->route('pessoa.index');
                return response()->json(['mensagem'=>'Erro ao deletar registro', 'class'=>'warning'], 400);

            }

            $registro = null;

            \DB::transaction(function() use (&$id, &$registro){

                $pessoa = Pessoa::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();
                if($pessoa){

                    $registro = $pessoa->update(['active'=>'no']);                    

                }
        
            } );

            if($registro == null){

                //\Session::flash('mensagem', ['msg'=>'Registro não encontrado', 'class'=>'alert alert-danger']);
                //return redirect()->back();
                return response()->json(['mensagem'=>'Erro ao deletar registro', 'class'=>'warning'], 400);
            }


            return response()->json(['mensagem'=>'Registro atulizado com sucesso', 'class'=>'success']);

        }catch(\Exception $e){

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);

        }
    }

    public function head()
    {

        return view('admin.pessoa.head');
    }

}
