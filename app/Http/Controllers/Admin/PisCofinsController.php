<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PisCofins;
use App\Exceptions\PisCofinsException;
use Illuminate\Support\Facades\Validator;

class PisCofinsController extends Controller
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
            $campos =  null;
            $parse = [
                'name_pis_cofins'=>'pis_cofins.dsPisCofins'

            ];

            $registro = \DB::table('pis_cofins');
            
            if(is_array($consulta) && count($consulta) > 0){
                foreach($consulta as $key=>$val){
                    
                    switch(trim($key)){
                        case 'id':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                $val = explode(',', $val);
                                
                                $registro->whereIn('pis_cofins.id', $val);
                            }
                            break;
                        case 'tipo':
                            if(is_string($val)){
                                    
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                $val = explode(',', $val);
                                    
                                $registro->whereIn('pis_cofins.tpRegistro', $val);
                            }
                        break;
                        case 'name_pis_cofins':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                
                                $registro->where('pis_cofins.dsPisCofins', 'like' , '%'.$val.'%');
                            }
                            break;
                        case 'limite':
                                $val = (int) $val;
                                if(is_integer($val) && $val > 0){
                                        
                                   $registro->limit($val);
                                }
                            break;
                        case 'ordem':

                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }

                                $val = explode(',', $val);
                                for($i= 0; !($i == count($val)); $i++) {
                                    $atual = explode('-', $val[$i]);
                                    if(array_key_exists(trim($atual[0]), $parse)){

                                        $parsed = $parse[trim($atual[0])];
                                        
                                        if($parsed){
                                           
                                            $registro->orderBy($parsed,$atual[1]);
                                        }
                                    }
                                    
                                    
                                }

                                break;

                        case'campos':
                                if(is_array($val) && count($val) > 0){
                                    //$campos = $this->montaCamposConsulta($registro, $val);
                                    
                                }
                            break;

                    }
                }
            }
            if($campos){
                $registro->select($campos);
            }else{
                $registro->select('pis_cofins.*');

            }
           
            $registro = $registro->where('pis_cofins.active', '=', 'yes')->get();

            
            \DB::commit();

            return view('admin.pis_cofins.index', compact('registro', 'consulta'));

        }catch(PisCofinsException $e){
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPis(Request $request, $idAssistente)
    {
        $dadosRequest = $request->all();

        $callBack = $dadosRequest['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';

        return view('admin.pis_cofins.create', compact('callBack','idAssistente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPisSt(Request $request, $idAssistente)
    {
        $dadosRequest = $request->all();

        $callBack = $dadosRequest['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';

        return view('admin.pis_cofins.create_st', compact('callBack','idAssistente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCofins(Request $request, $idAssistente)
    {
        $dadosRequest = $request->all();

        $callBack = $dadosRequest['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';
        $formCofins = true;

        return view('admin.pis_cofins.create', compact('callBack','idAssistente', 'formCofins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCofinsSt(Request $request, $idAssistente)
    {
        $dadosRequest = $request->all();

        $callBack = $dadosRequest['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';
        $formCofins = true;

        return view('admin.pis_cofins.create_st', compact('callBack','idAssistente', 'formCofins'));
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

            $dadosRequest['user_id']            = \Auth::User()->id;//trocar pelo id do usuario logado
            $dadosRequest['active']             = 'yes';
            $dadosRequest['dsPisCofins']        = $dados['dsPisCofins'] ?? 'teste';
            $dadosRequest['tpCalculo']          = $dados['tpCalculo'] ?? 'pc';
            $dadosRequest['tpRegistro']         = $dados['tpRegistro'] ?? 'pis';
            $dadosRequest['vrPisCofins']        = $dados['vrPisCofins'] ?? 0;
            $dadosRequest['pcPisCofins']        = $dados['pcPisCofins'] ?? 0;
           
            $registro = PisCofins::create($dadosRequest);
            \DB::commit();

            if($registro){
                return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);
            }else{
                throw new PisCofinsException('Erro ao cadastrar');
            }

        }catch(PisCofinsException $e){
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

    public function info(Request $request, $id, $idAssistente)
    {
        
        try{

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            $callBack = $dados['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if($id <= 0){
                throw new PisCofinsException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = PisCofins::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            if($registro == null){
                throw new PisCofinsException('Registro não encontrado');
            }

            \DB::commit();

            //return view('admin.produto.info', compact('registro'));
            return view('admin.pis_cofins.info', compact('registro', 'idAssistente', 'callBack'));

        }catch(PisCofinsException $e){
            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));
            //return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
    
        }catch(\Exception $e){

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));
            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

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
                throw new PisCofinsException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = PisCofins::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if($registro == null){
                throw new PisCofinsException('Registro não encontrado');
                
            }

            $formCofins = false;
            if(trim($registro->tpRegistro == 'cofins') || trim($registro->tpRegistro) == 'cofinsst'){
                $formCofins = false;
            }
            
            $sufixo = '';
            if(trim($registro->tpRegistro == 'pis') || trim($registro->tpRegistro) == 'cofinsst'){
                $sufixo = 'st';
            }

            \DB::commit();

            return view('admin.pis_cofins.edit', compact('registro', 'idAssistente', 'callBack', 'formCofins', 'sufixo'));

         }catch(PisCofinsException $e){

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

            $dadosRequest['user_update_id']     = \Auth::User()->id;
            $dadosRequest['dsPisCofins']        = $dados['dsPisCofins'];
            $dadosRequest['tpCalculo']          = $dados['tpCalculo'];
            $dadosRequest['tpRegistro']         = $dados['tpRegistro'];
            $dadosRequest['vrPisCofins']        = $dados['vrPisCofins'] ?? 0;
            $dadosRequest['pcPisCofins']        = $dados['pcPisCofins'] ?? 0;
           
            $pisCofins = PisCofins::where('active', '=', 'yes')->where('id', '=', $id)->first();
            $pisCofins->update($dadosRequest);

            \DB::commit();

            return response()->json(['mensagem'=>$pisCofins, 'class'=>'sucess'], 200);


        }catch (PisCofinsException $th) {

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
            $piscofins = PisCofins::where('active', '=', 'yes')->where('id', '=', $id)->first();
            $piscofins->update($dadosRequest);
            $piscofins->delete();

            \DB::commit();

            return response()->json(['mensagem'=>[], 'class'=>'sucess'], 200);

        }catch (PisCofinsException $th) {

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
           
            return view('admin.pis_cofins.head_refresh', compact('isReload'));
        }else{
            return view('admin.pis_cofins.head', compact('isReload'));
        }
        
    }

    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'dsPisCofins'=> 'required|max:255|min:2',
            'tpCalculo'=> 'required',
            'tpRegistro'=> 'required',
        ], [
            'dsPisCofins.required' => 'O campo "DESCRIÇÃO" é obrigatório.',
            'tpCalculo.required' => 'O campo "TIP. CALCULO" é obrigatório.',
            'tpRegistro.required' => 'O "Tipo de registro" é obrigatório. Ente em contato com o suporte.',
            'dsPisCofins.max' => 'O "DESCRIÇÃO" suporta até :max caracteres.',
            'dsPisCofins.min' => 'O "DESCRIÇÃO" deve conter pelo menos :min caracteres.',
        ]);
        
        if($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach($errors->all() as $mensagem){
                $msg .= $mensagem.'<br/>';
            }
            
            throw new PisCofinsException($msg);
        }

        return true;
    }
}
