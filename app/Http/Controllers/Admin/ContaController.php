<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Conta;
use Illuminate\Support\Facades\Validator;
use App\Exception\ContaException;

class ContaController extends Controller
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
                'conta_name'=>'contas.name'

            ];

            $registro = \DB::table('contas');
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
                                
                                $registro->whereIn('contas.id', $val);
                            }
                            break;
                        case 'name':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                
                                $registro->where('contas.name', 'like' , '%'.$val.'%');
                            }
                            break;
                        case 'conta_id':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                
                                $registro->where('contas.id', '=' , ''.$val.'');
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
                $registro->select('contas.*');

            }
           
            $registro = $registro->where('contas.active', '=', 'yes')->get();

            \DB::commit();

            //dd( $registro);

            return view('admin.conta.index', compact('registro', 'consulta'));

        }catch(ContaException $e){
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

    public function json(Request $request)
    {
        try{
            \DB::beginTransaction();

            $consulta = $request->all();
            $campos =  null;
            $parse = [
                'conta_name'=>'contas.name'

            ];

            $registro = \DB::table('contas');
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
                                
                                $registro->whereIn('contas.id', $val);
                            }
                            break;
                        case 'name':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                
                                $registro->where('contas.name', 'like' , '%'.$val.'%');
                            }
                            break;
                        case 'caixa_id':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                
                                $registro->where('contas.id', '=' , ''.$val.'');
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
                $registro->select('contas.*');

            }
           
            $registro = $registro->where('contas.active', '=', 'yes')->get();

            \DB::commit();

            //dd( $registro);

            return response()->json(['registro'=>$registro, 'class'=>'sucess'], 201);

        }catch(ContaException $e){
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
        return view('admin.conta.create', compact('callBack','idAssistente'));
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
            $dadosRequest['type']                   = $dados['type'];
            $dadosRequest['vrMin']                  = $dados['vrMin'];
            $dadosRequest['vrMax']                  = $dados['vrMax'];
            $dadosRequest['status_abertura']        = $dados['status_abertura'] ?? 'close';
            $dadosRequest['status_bloqueio']        = $dados['status_bloqueio'];
            $dadosRequest['aceita_transferencia']   = $dados['aceita_transferencia'];
            $dadosRequest['user_id']                = \Auth::User()->id;
            $dadosRequest['active']                 = 'yes';             
            $registro = Conta::create($dadosRequest);
            \DB::commit();
 
            if($registro){
                return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);
            }else{
                throw new ContaException('Erro ao cadastrar');
            }
 
         }catch(ContaException $e){
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
                throw new ContaException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Conta::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            if($registro == null){
                throw new ContaException('Registro não encontrado');
            }

            \DB::commit();

            //return view('admin.produto.info', compact('registro'));
            return view('admin.conta.info', compact('registro', 'idAssistente', 'callBack'));

        }catch(ContaException $e){
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
                throw new ContaException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Conta::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if($registro == null){
                throw new ContaException('Registro não encontrado');
                
            }

            \DB::commit();

            return view('admin.conta.edit', compact('registro', 'idAssistente', 'callBack'));

         }catch(ContaException $e){

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
            $dadosRequest['type']                   = $dados['type'];
            $dadosRequest['vrMin']                  = $dados['vrMin'];
            $dadosRequest['vrMax']                  = $dados['vrMax'];
           // $dadosRequest['status_abertura']        = $dados['status_abertura'];
            $dadosRequest['status_bloqueio']        = $dados['status_bloqueio'];
            $dadosRequest['aceita_transferencia']   = $dados['aceita_transferencia'];
           
            $caixa = Conta::where('active', '=', 'yes')->where('id', '=', $id)->first();
            $caixa->update($dadosRequest);

            \DB::commit();

            return response()->json(['mensagem'=>$caixa, 'class'=>'sucess'], 200);


        }catch (ContaException $th) {

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
            $bairro = Conta::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if($bairro->vrSaldo == 0){
                 throw new ContaException('Este caixa ainda possui saldo.');
            }
            $bairro->update($dadosRequest);
            $bairro->delete();

            \DB::commit();

            return response()->json(['mensagem'=>[], 'class'=>'sucess'], 200);

        }catch (ContaException $th) {

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
           
            return view('admin.conta.head_refresh', compact('isReload', 'pesquisar', 'calback_selected', 'url_pesquisa'));
        }else{
            return view('admin.conta.head', compact('isReload', 'calback_selected', 'pesquisar', 'url_pesquisa'));
        }
        
    }

    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=> 'required|max:255|min:2',
            'type'=> 'required',
            'vrMin'=>'required|min:0',
            'vrMax'=>'required|min:0',
        ], [
            'name.required' => 'O campo "DESCRIÇÃO" é obrigatório.',
            'name.max' => 'O "DESCRIÇÃO" suporta até :max caracteres.',
            'name.min' => 'O "DESCRIÇÃO" deve conter pelo menos :min caracteres.',
            'type.required' => 'O campo "TIPO" é obrigatório.',
            'vrMin.min' => 'O "VALOR MÍNIMO" deve conter pelo meno :min caracteres.',
            'vrMax.min' => 'O "VALOR MÁXIMO" deve conter pelo meno :min caracteres.',
        ]);
        
        if($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach($errors->all() as $mensagem){
                $msg .= $mensagem.'<br/>';
            }
            
            throw new ContaException($msg);
        }

        return true;
    }
}
