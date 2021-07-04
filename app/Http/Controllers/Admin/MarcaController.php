<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Http\Requests\MarcaRequest;
use \App\Produto;
use \App\Marca;
use \App\Categoria;


class MarcaController extends Controller
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

    			$registro = Marca::where('active', '=', 'yes')->get();

    		});

            return view('admin.marca.index', compact('registro'));
    		
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
        return view('admin.marca.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarcaRequest $request)
    {

        try{


            $validator = $request->validated();

            $registro = null;
            \DB::transaction(function() use (&$request, &$registro){

                $dados = $request->all();

                $dadosRequest = [];

                $dadosRequest['name']               = $dados['name'];
                $dadosRequest['user_id']            = \Auth::User()->id;//trocar pelo id do usuario logado
                $dadosRequest['active']             = 'yes';

                $registro      = $marca = Marca::create($dadosRequest);

                
                

            });

            if($registro){

                //\Session::flash('mensagem', ['msg'=>'Registro salvo com sucesso', 'class'=>'alert alert-success']);
                //return redirect()->route('marca.head');

                return response()->json(['mensagem'=>$registro, 'class' => 'success'], 200);

            }else{

                //\Session::flash('mensagem', ['msg'=>'Erro ao salvar o registro', 'class'=>'alert alert-warning']);

                //return redirect()->back();
                return response()->json(['mensagem'=>'Erro ao salvar o registro', 'class'=>'warning'], 400);
            }

        }catch(\Exception $e){

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);

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

                //return redirect()->route('marca.index');

                 return  response()->json(['mensagem'=>'Erro, parâmetro inválido', 'class'=>'warning'], 400);

            }

            $registro = null;

            \DB::transaction(function() use (&$id, &$registro){

                $registro = Marca::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();
        
            } );

            if($registro == null){

                //\Session::flash('mensagem', ['msg'=>'Marca não encontrada', 'class'=>'alert alert-danger']);
                //return redirect()->back();

                return response()->json(['mensagem'=>'Erro, registro não encontrado', 'class'=>'warning'], 400);
            }


            //return view('admin.produto.info', compact('registro'));
            return view('admin.marca.info', compact('registro'));

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
    public function edit(Request $request, $id, $id_assistente)
    {


        $registro = null;

    	try {
            $dadosRequest = $request->all();
            if(! isset($id)){
                $id = isset($dadosRequest['id']) ? $dadosRequest['id'] : 0;
            }
            

    		if($id <= 0){

	             //\Session::flash('mensagem', ['msg'=>'Parâmetro ínválido', 'class'=>'alert alert-danger']);

	            //return redirect()->route('marca.index');

                return response()->json(['mensagem'=>'Erro, parâmetro inválido', 'class'=>'warning'], 400);

       		 }
    		
       		 \DB::transaction(function() use (&$id, &$registro){

	            $registro = Marca::where('active', '=', 'yes')
	                ->where('id', '=', $id)->first();

	        } );


	        if($registro == null){

	            //\Session::flash('mensagem', ['msg'=>'Marca não encontrada', 'class'=>'alert alert-danger']);
	            //return redirect()->back();
                return response()->json(['mensagem'=>'Erro, registro não encontrado', 'class'=>'warning', '$id_assistente'=>$$id_assistente], 400);
	        }


	        return view('admin.marca.edit', compact('registro', 'id_assistente'));


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
    public function update(MarcaRequest $request, $id)
    {
        try{

            $validator = $request->validated();

            $dados = $request->all();
            $registro = null;

            \DB::transaction(function() use (&$dados, &$id, &$registro){

                $dadosRequest = [];

                $dadosRequest['name']               = $dados['name'];
                $dadosRequest['user_id']            = \Auth::user()->id;//trocar pelo id do usuario logado
                $dadosRequest['active']             = 'yes';

                $marca = Marca::find($id);
                
                $response = $marca->update($dadosRequest);
                
                if($response == true){
                    $registro = $marca;
                }
            });

            if($registro != null){

                //\Session::flash('mensagem', ['msg'=>'Registro atualizado com sucesso', 'class'=>'alert alert-success']);

                //return redirect()->route('marca.head');
                return response()->json(['data'=>$registro, 'class'=>'success'], 200);
            }

            //\Session::flash('mensagem', ['msg'=>'Erroa ao atualizar registro', 'class'=>'alert alert-warning']);

                //return redirect()->route('marca.index');

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

                //return redirect()->route('marca.index');
                return response()->json(['mensagem'=>'Erro ao deletar registro', 'class'=>'warning'], 400);

            }

            $registro = null;

            \DB::transaction(function() use (&$id, &$registro){

                $marca = Marca::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();
                if($marca){

                    $registro = $marca->update(['active'=>'no']);                    

                }
        
            } );

            if($registro == null){

                //\Session::flash('mensagem', ['msg'=>'Marca não encontrada', 'class'=>'alert alert-danger']);
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

    public function head(Request $request)
    {
        $dados = $request->all();
        
        $isReload = isset($dados['isReload']) && $dados['isReload'] == true ? $dados['isReload']: false;
        if($isReload){
           
            return view('admin.marca.head_refresh', compact('isReload'));
        }else{
            return view('admin.marca.head', compact('isReload'));
        }
        
    }
}
