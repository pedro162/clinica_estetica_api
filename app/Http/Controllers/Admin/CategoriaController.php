<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Http\Requests\CategoriaRequest;
use \App\Produto;
use \App\Marca;
use \App\Categoria;

class CategoriaController extends Controller
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

    			$registro = Categoria::where('active', '=', 'yes')->get();

    		});
    		
    	} catch (\Exception $e) {
    		 
    		\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            return redirect()->back();
    	}

        return view('admin.categoria.index', compact('registro'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaRequest $request)
    {

        try{


            $validator = $request->validated();

            $sentinela = null;
            \DB::transaction(function() use (&$request, &$sentinela){

                $dados = $request->all();

                $dadosRequest = [];

                $dadosRequest['name']               = $dados['name'];
                $dadosRequest['user_id']            = 1;//trocar pelo id do usuario logado
                $dadosRequest['active']             = 'yes';

                $sentinela      = $categoria = Categoria::create($dadosRequest);

                
                

            });

            if($sentinela){

                \Session::flash('mensagem', ['msg'=>'Registro salvo com sucesso', 'class'=>'alert alert-success']);
                return redirect()->route('categoria.head');

            }else{

                \Session::flash('mensagem', ['msg'=>'Erro ao salvar o registro', 'class'=>'alert alert-warning']);

                return redirect()->back();
            }

        }catch(\Exception $e){

            \Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            return redirect()->back();

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

                return redirect()->route('categoria.index');

            }

            $registro = null;

            \DB::transaction(function() use (&$id, &$registro){

                $registro = Categoria::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();
        
            } );

            if($registro == null){

                \Session::flash('mensagem', ['msg'=>'Categoria não encontrada', 'class'=>'alert alert-danger']);
                return redirect()->back();
            }


            //return view('admin.produto.info', compact('registro'));
            return view('admin.categoria.info', compact('registro'));

        }catch(\Exception $e){

            \Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            return redirect()->back();

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


        $registro = null;

    	try {

    		if($id <= 0){

	             \Session::flash('mensagem', ['msg'=>'Parâmetro ínválido', 'class'=>'alert alert-danger']);

	            return redirect()->route('categoria.index');

       		 }
    		
       		 \DB::transaction(function() use (&$id, &$registro){

	            $registro = Categoria::where('active', '=', 'yes')
	                ->where('id', '=', $id)->first();

	        } );


	        if($registro == null){

	            \Session::flash('mensagem', ['msg'=>'Categoria não encontrada', 'class'=>'alert alert-danger']);
	            return redirect()->back();
	        }


	        return view('admin.categoria.edit', compact('registro'));


    	} catch (\Exception $e) {

    		 \Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            return redirect()->back();
    	}

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriaRequest $request, $id)
    {
        $validator = $request->validated();

        $dados = $request->all();
        $registro = null;

        \DB::transaction(function() use (&$dados, &$id, &$registro){

            $dadosRequest = [];

            $dadosRequest['name']               = $dados['name'];
            $dadosRequest['user_id']            = 1;//trocar pelo id do usuario logado
            $dadosRequest['active']             = 'yes';

            $categoria = Categoria::find($id);
            
            $registro = $categoria->update($dadosRequest);

        });

        if($registro != null){

            \Session::flash('mensagem', ['msg'=>'Registro atualizado com sucesso', 'class'=>'alert alert-success']);

            return redirect()->route('categoria.index');
        }

        \Session::flash('mensagem', ['msg'=>'Erroa ao atualizar registro', 'class'=>'alert alert-warning']);

            return redirect()->route('categoria.index');

        return redirect()->back();

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

                 \Session::flash('mensagem', ['msg'=>'Parâmetro ínválido', 'class'=>'alert alert-danger']);

                return redirect()->route('categoria.index');

            }

            $registro = null;

            \DB::transaction(function() use (&$id, &$registro){

                $registro = Categoria::where('active', '=', 'yes')
                ->where('id', '=', $id)->first()->update(['active'=>'no']);

        
            } );

            if($registro == null){

                \Session::flash('mensagem', ['msg'=>'Categoria não encontrada', 'class'=>'alert alert-danger']);
                return redirect()->back();
            }


            return 'Registro atulizado com sucesso';

        }catch(\Exception $e){

            \Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            return redirect()->back();

        }
    }

    public function head()
    {

        return view('admin.categoria.head');
    }
}
