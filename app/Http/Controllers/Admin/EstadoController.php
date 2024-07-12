<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Estado;
use App\Pais;
use App\Exceptions\EstadoException;
use Illuminate\Support\Facades\Validator;
use \App\Helpers\EstadoHelper;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            \DB::beginTransaction();

            $consulta = $request->all();

            $objEstadoHelper = new EstadoHelper();
            $registro = $objEstadoHelper->json($consulta);

            \DB::commit();

            //dd( $registro);

            return view('admin.estado.index', compact('registro', 'consulta'));

        }catch(EstadoException $e){
            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));

           // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
    
        }catch(\Exception $e){
            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {
        try{
            \DB::beginTransaction();

            $consulta = $request->all();
            $objEstadoHelper = new EstadoHelper();
            $registro       = $objEstadoHelper->json($consulta);

            \DB::commit();

            //dd( $registro);

            return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);

        }catch(EstadoException $e){
            \DB::rollback();
             return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage()]], 404);
    
        }catch(\Exception $e){
            \DB::rollback();

            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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
        $paises = Pais::where('active', '=', 'yes')->get();

        return view('admin.estado.create', compact('callBack','idAssistente', 'paises'));
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

            $objEstadoHelper = new EstadoHelper();
            $registro       = $objEstadoHelper->store($dados);

            \DB::commit();
 
            if($registro){
                return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);
            }else{
                throw new EstadoException('Erro ao cadastrar');
            }
 
         }catch(EstadoException $e){
             \DB::rollback();
             return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 400);
 
         }catch(\Exception $e){
             \DB::rollback();
             return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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




    public function info(Request $request, $id)
    {

        try {


            $dados = $request->all();
            $id = $id ?? $dados['id'];

            \DB::beginTransaction();

            $objEstadoHelper = new EstadoHelper();
            $registro       = $objEstadoHelper->info($dados, $id);

            if ($registro == null) {
                throw new EstadoException(' não encontrado');
            }

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (EstadoException $e) {
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
        try{
            
            $dadosRequest = $request->all();

            $callBack = $dadosRequest['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';
            if(! isset($id)){
                $id = isset($dadosRequest['id']) ? $dadosRequest['id'] : 0;
            }

            if($id <= 0){
                throw new EstadoException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Estado::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if($registro == null){
                throw new EstadoException('Registro não encontrado');
                
            }

            $paises = Pais::where('active', '=', 'yes')->get();

            \DB::commit();

            return view('admin.estado.edit', compact('registro', 'idAssistente', 'callBack', 'paises'));

         }catch(EstadoException $e){

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

            $pais = Pais::where('active', '=' ,'yes')->where('id', '=', $dados['pais_id'])->first();
            
            if(! $pais){
                throw new EstadoException('País não identificado. Tente novamente ou entre em contato com o suporte.');
            }
            $dadosRequest = [];            

            $dadosRequest['user_update_id']    = \Auth::User()->id;
            $dadosRequest['nmEStado']          = $dados['nmEStado'];
            $dadosRequest['codEstado']         = $dados['codEstado'];
            $dadosRequest['sigla']             = $dados['sigla'];
            $dadosRequest['pais_id']           = $pais->id;
            $dadosRequest['padrao']            = $dados['padrao'];
           
            $estado = Estado::where('active', '=', 'yes')->where('id', '=', $id)->first();
            $estado->update($dadosRequest);

            \DB::commit();

            return response()->json(['mensagem'=>$estado, 'class'=>'sucess'], 200);


        }catch (EstadoException $th) {

            \DB::rollback();

            return response()->json(['mensagem'=>$th->getMessage(), 'class'=>'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor - '.$th->getMessage(), 'class'=>'warning'], 500);
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
            $piscofins = Estado::where('active', '=', 'yes')->where('id', '=', $id)->first();
            $piscofins->update($dadosRequest);
            $piscofins->delete();

            \DB::commit();

            return response()->json(['mensagem'=>[], 'class'=>'sucess'], 200);

        }catch (EstadoException $th) {

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
        
        $isReload = isset($dados['isReload']) && $dados['isReload'] == true ? $dados['isReload']: false;
        if($isReload){
           
            return view('admin.estado.head_refresh', compact('isReload'));
        }else{
            return view('admin.estado.head', compact('isReload'));
        }
        
    }

    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nmEStado'=> 'required|max:255|min:2',
            'codEstado'=> 'required',
            'sigla'=> 'required|max:2|min:2',
            'padrao'=> 'required',
        ], [
            'nmEStado.required' => 'O campo "DESCRIÇÃO" é obrigatório.',
            'nmEStado.max' => 'O "DESCRIÇÃO" suporta até :max caracteres.',
            'nmEStado.min' => 'O "DESCRIÇÃO" deve conter pelo menos :min caracteres.',
            'codEstado.required' => 'O campo "CÓDIGO DO ESTADO" é obrigatório.',
            'padrao.required' => 'O campo "PADRÃO" é obrigatório.',
            'sigla.required' => 'O campo "SIGLA" é obrigatório.',
            'sigla.max' => 'O "SIGLA" suporta até :max caracteres.',
            'sigla.min' => 'O "SIGLA" deve conter pelo menos :min caracteres.',
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
