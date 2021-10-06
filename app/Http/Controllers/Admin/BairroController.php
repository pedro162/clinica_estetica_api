<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bairro;
use App\Exceptions\BairroException;
use App\Cidade;

class BairroController extends Controller
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
                'name_bairro'=>'bairros.name'

            ];

            $registro = \DB::table('bairros');
            $registro->join('estadoss', function($join){
                
                $join->on('cidades.id', '=', 'bairros.cidade_id');

            });
            
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
                                
                                $registro->whereIn('cidades.id', $val);
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
                                
                                $registro->where('bairros.name', 'like' , '%'.$val.'%');
                            }
                            break;
                        case 'cidade_id':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                
                                $registro->where('bairros.cidade_id', '=' , ''.$val.'');
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
                $registro->select('bairros.*', 'cidades.nmCidade');

            }
           
            $registro = $registro->where('cidades.active', '=', 'yes')
            ->where('bairros.active', '=', 'yes')->get();

            \DB::commit();

            //dd( $registro);

            return view('admin.bairros.index', compact('registro', 'consulta'));

        }catch(BairroException $e){
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
    public function create(Request $request, $idAssistente)
    {
        $dadosRequest = $request->all();

        $callBack = $dadosRequest['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';
        return view('admin.bairros.create', compact('callBack','idAssistente'));
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

            $cidade = Cidade::where('active', '=' ,'yes')->where('id', '=', $dados['cidade_id'])->first();
            if(! $cidade){
                throw new BairroException('Cidade não identificada. Tente novamente ou entre em contato com o suporte.');
            }
 
            $dadosRequest = [];
             
            $dadosRequest['user_id']            = \Auth::User()->id;
            $dadosRequest['user_update_id']     = \Auth::User()->id;
            $dadosRequest['nmCidade']           = $dados['nmCidade'];
            $dadosRequest['cdCidade']           = $dados['cdCidade'];
            $dadosRequest['sigla']              = $dados['sigla'] ?? null;
            $dadosRequest['cidade_id']          = $cidade->id;
            $dadosRequest['active']             = 'yes';
             
            $registro = Bairro::create($dadosRequest);
            \DB::commit();
 
            if($registro){
                return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);
            }else{
                throw new BairroException('Erro ao cadastrar');
            }
 
         }catch(BairroException $e){
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
                throw new BairroException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Bairro::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            if($registro == null){
                throw new BairroException('Registro não encontrado');
            }

            \DB::commit();

            //return view('admin.produto.info', compact('registro'));
            return view('admin.bairro.info', compact('registro', 'idAssistente', 'callBack'));

        }catch(BairroException $e){
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
                throw new BairroException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Bairro::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if($registro == null){
                throw new BairroException('Registro não encontrado');
                
            }

            $estados = Estado::where('active', '=', 'yes')->get();

            \DB::commit();

            return view('admin.cidade.edit', compact('registro', 'idAssistente', 'callBack', 'estados'));

         }catch(BairroException $e){

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

            $cidade = Cidade::where('active', '=' ,'yes')->where('id', '=', $dados['cidade_id'])->first();
            
            if(! $estado){
                throw new BairroException('Cidade não identificada. Tente novamente ou entre em contato com o suporte.');
            }
            $dadosRequest = [];         
             
            $dadosRequest['user_update_id']     = \Auth::User()->id;
            $dadosRequest['nmCidade']           = $dados['nmCidade'];
            $dadosRequest['cdCidade']           = $dados['cdCidade'];
            $dadosRequest['sigla']              = $dados['sigla'] ?? null ;
            $dadosRequest['cidade_id']          = $cidade->id;
            $dadosRequest['active']             = 'yes';
           
            $bairro = Bairro::where('active', '=', 'yes')->where('id', '=', $id)->first();
            $bairro->update($dadosRequest);

            \DB::commit();

            return response()->json(['mensagem'=>$bairro, 'class'=>'sucess'], 200);


        }catch (BairroException $th) {

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
            $bairro = Bairro::where('active', '=', 'yes')->where('id', '=', $id)->first();
            $bairro->update($dadosRequest);
            $bairro->delete();

            \DB::commit();

            return response()->json(['mensagem'=>[], 'class'=>'sucess'], 200);

        }catch (BairroException $th) {

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
           
            return view('admin.bairro.head_refresh', compact('isReload'));
        }else{
            return view('admin.bairro.head', compact('isReload'));
        }
        
    }

    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=> 'required|max:255|min:2',
            'cep'=> 'required|max:9|min:9',
            'cidade_id'=>'required|min:1',
            'codIbge'=>'required'
        ], [
            'name.required' => 'O campo "DESCRIÇÃO" é obrigatório.',
            'name.max' => 'O "DESCRIÇÃO" suporta até :max caracteres.',
            'name.min' => 'O "DESCRIÇÃO" deve conter pelo menos :min caracteres.',
            'cep.required' => 'O campo "CEP" é obrigatório.',
            'cep.max' => 'O "CEP" suporta até :max caracteres.',
            'cep.min' => 'O "CEP" deve conter pelo menos :min caracteres.',
            'cidade_id.required' => 'O campo "CÓDIGO DA CIDADE" é obrigatório.',
            'cidade_id.min' => 'O campo "CÓDIGO DA CIDADE" deve ser um número positivo.',
            'codIbge.required' => 'O campo "CÓDIGO IBGE" é obrigatório.',
        ]);
        
        if($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach($errors->all() as $mensagem){
                $msg .= $mensagem.'<br/>';
            }
            
            throw new BairroException($msg);
        }

        return true;
    }
}
