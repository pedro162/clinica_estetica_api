<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Http\Requests\MarcaRequest;
use \App\Produto;
use \App\Marca;
use \App\Categoria;
use \App\Exceptions\MarcaException;


class MarcaController extends Controller
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

            $registro = Marca::where('active', '=', 'yes');

            if(is_array($consulta) && count($consulta) > 0){
                foreach($consulta as $key=>$val){
                    
                    switch(trim($key)){
                        case 'codigo_marca':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                $val = explode(',', $val);
                                
                                $registro->whereIn('id', $val);
                            }
                            break;
                        case 'nome_marca':
                            if($val[0] == ','){
                                $val = substr($val, 1);
                            } 
                            if($val[strlen($val) - 1] == ','){
                                $val = substr($val, 0, -1);
                            }
                            
                            $registro->where('name', 'like' , '%'.$val.'%');
                            break;
                    }
                }
            }

    		$registro = $registro->get();

            return view('admin.marca.index', compact('registro', 'consulta'));
    		
            \DB::commit();

    	} catch (\Exception $e) {
    		 \DB::rollback();
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
    public function create(Request $request, $idAssistente)
    {
        $dadosRequest = $request->all();

        $callBack = $dadosRequest['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';

        return view('admin.marca.create', compact('callBack','idAssistente'));
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


    public function info(Request $request, $id, $idAssistente)
    {
        
        try{

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            $callBack = $dados['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';


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
            return view('admin.marca.info', compact('registro', 'idAssistente', 'callBack'));

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
    public function edit(Request $request, $id, $idAssistente)
    {


        $registro = null;

    	try {
            $dadosRequest = $request->all();

            $callBack = $dadosRequest['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';
            if(! isset($id)){
                $id = isset($dadosRequest['id']) ? $dadosRequest['id'] : 0;
            }

            if($id <= 0){
                throw new MarcaException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Marca::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            if($registro == null){
                throw new MarcaException('Registro não encontrado');
                
            }

            \DB::commit();

	        return view('admin.marca.edit', compact('registro',  'idAssistente', 'callBack'));


    	} catch(MarcaException $e){

            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));
            
            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

        }catch(\Exception $e){
            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));
            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();
        }

    }

    public function update(Request $request, $id)
    {
        try {
           
            
            $this->validaRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();

            $dadosRequest = [];

            $dadosRequest['name']               = $dados['name'];
            $dadosRequest['user_id']            = \Auth::user()->id;//trocar pelo id do usuario logado
            $dadosRequest['active']             = 'yes';

            $marca = Marca::find($id);
           
            $marca->update($dadosRequest);

            \DB::commit();

            return response()->json(['mensagem'=>$marca, 'class'=>'sucess'], 200);


        }catch (MarcaException $th) {

            \DB::rollback();

            return response()->json(['mensagem'=>$th->getMessage(), 'class'=>'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor: '.$th->getMessage(), 'class'=>'warning'], 500);
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

    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=> 'required|max:255|min:2',
        ], [
            'name.required' => 'O campo "DESCRIÇÃO" é obrigatório.',
            'name.max' => 'O "DESCRIÇÃO" suporta até :max caracteres.',
            'name.min' => 'O "DESCRIÇÃO" deve conter pelo menos :min caracteres.',
        ]);
        
        if($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach($errors->all() as $mensagem){
                $msg .= $mensagem.'<br/>';
            }
            
            throw new EstadoException($msg);
        }

        return true;
    }
}
