<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\GrupoException;
use App\Grupo;
use Illuminate\Support\Facades\Validator;
use App\Helpers\GrupoHelper;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
    }

    public function json(Request $request)
    {
        try{
            
            \DB::beginTransaction();

            $consulta = $request->all();
            $grupoHelper = new GrupoHelper();
           
            $registro = $grupoHelper->json($consulta);

            \DB::commit();

            //dd( $registro);

            return response()->json(['registro'=>$registro, 'class'=>'sucess'], 201);

        }catch(GrupoException $e){
            \DB::rollback();

            return response()->json(['mensagem'=>$th->getMessage(), 'class'=>'warning'], 400);
    
        }catch(\Exception $e){
            \DB::rollback();

            return response()->json(['mensagem'=>$th->getMessage(), 'class'=>'warning'], 400);

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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
        return view('admin.grupo.create', compact('callBack','idAssistente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            $this->validaRequest($request);
             
            \DB::beginTransaction();

            $dados = $request->all();

            $dadosRequest = [];
             
            $dadosRequest['name']                   = $dados['name'];
            $dadosRequest['descricao']              = $dados['descricao'];
            $dadosRequest['user_id']                = \Auth::User()->id;
            $dadosRequest['active']                 = 'yes';             
            $registro = Grupo::create($dadosRequest);
            \DB::commit();
 
            if($registro){
                return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);
            }else{
                throw new GrupoException('Erro ao cadastrar');
            }
 
         }catch(GrupoException $e){
             \DB::rollback();
             return response()->json(['mensagem'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 400);
 
         }catch(\Exception $e){
             \DB::rollback();
             return response()->json(['mensagem'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 500);
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

    public function info(Request $request, $id, $idAssistente=0)
    {
        
        try{

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            $callBack = $dados['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if($id <= 0){
                throw new GrupoException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Grupo::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            if($registro == null){
                throw new GrupoException('Registro não encontrado');
            }

            \DB::commit();

            //return view('admin.produto.info', compact('registro'));
            //return view('admin.grupo.info', compact('registro', 'idAssistente', 'callBack'));
            return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);
        
        }catch(GrupoException $e){
            \DB::rollback();

            //$msg = $e->getMessage();
            //return view('layouts._admin._error', compact('msg'));

            return response()->json(['mensagem'=>$th->getMessage(), 'class'=>'warning'], 400);
    
        }catch(\Exception $e){
            \DB::rollback();

            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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
        try{
            
            $dadosRequest = $request->all();

            $callBack = $dadosRequest['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';
            if(! isset($id)){
                $id = isset($dadosRequest['id']) ? $dadosRequest['id'] : 0;
            }

            if($id <= 0){
                throw new GrupoException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Grupo::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if($registro == null){
                throw new GrupoException('Registro não encontrado');
                
            }

            \DB::commit();

            return view('admin.grupo.edit', compact('registro', 'idAssistente', 'callBack'));

         }catch(GrupoException $e){

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

            $dados = $request->all();

            $dadosRequest = [];            
            $dadosRequest['user_update_id']         = \Auth::User()->id;
            $dadosRequest['name']                   = $dados['name'];
            $dadosRequest['descricao']              = $dados['descricao'];
           
            $grupo = Grupo::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if(! $grupo){
                 throw new GrupoException('Registro não identificado.');
            }

            $grupo->update($dadosRequest);

            \DB::commit();

            return response()->json(['mensagem'=>$grupo, 'class'=>'sucess'], 200);


        }catch (GrupoException $th) {

            \DB::rollback();

            return response()->json(['mensagem'=>$th->getMessage(), 'class'=>'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);
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

            \DB::beginTransaction();

            $dadosRequest = [];

            $dadosRequest['user_update_id']     = \Auth::User()->id;//trocar pelo id do usuario logado
            $dadosRequest['active']             = 'no';
            $grupo = Grupo::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if(! $grupo){
                 throw new GrupoException('Registro não identificado.');
            }
            $grupo->update($dadosRequest);
            $grupo->delete();

            \DB::commit();

            return response()->json(['mensagem'=>[], 'class'=>'sucess'], 200);

        }catch (GrupoException $th) {

            \DB::rollback();

            return response()->json(['mensagem'=>$th->getMessage(), 'class'=>'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);
            //throw $th;
        }
    }

    public function head(Request $request)
    {
        $dados = $request->all();
        
        $isReload           = isset($dados['isReload']) && $dados['isReload'] == true ? $dados['isReload']: false;
        $pesquisar          = $dados['pesquisar'] ?? null;
        $calback_selected   = $dados['calback_selected'] ?? null;
        $url_pesquisa       = $dados['url_pesquisa'] ?? null;

        if($isReload){
           
            return view('admin.grupo.head_refresh', compact('isReload', 'pesquisar', 'calback_selected', 'url_pesquisa'));
        }else{
            return view('admin.grupo.head', compact('isReload', 'calback_selected', 'pesquisar', 'url_pesquisa'));
        }
        
    }

    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=> 'required|max:255|min:2',
            'descricao'=> 'max:255',
        ], [
            'name.required' => 'O campo "NOME" é obrigatório.',
            'name.max' => 'O "NOME" suporta até :max caracteres.',
            'name.min' => 'O "NOME" deve conter pelo menos :min caracteres.',
            'descricao.max' => 'O "DESCRIÇÃO" suporta até :max caracteres.',
        ]);
        
        if($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach($errors->all() as $mensagem){
                $msg .= $mensagem.'<br/>';
            }
            
            throw new GrupoException($msg);
        }

        return true;
    }
}
