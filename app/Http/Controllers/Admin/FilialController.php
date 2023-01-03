<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\FilialException;
use \App\Filial;
use \App\Pessoa;

class FilialController extends Controller
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

            $registro = Filial::where('active', '=', 'yes');

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
                                
                                $registro->whereIn('id', $val);
                            }
                            break;
                        case 'name':
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

            return view('admin.filial.index', compact('registro', 'consulta'));
    		
            \DB::commit();

    	}catch(FilialException $e){
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

        try {
            \DB::beginTransaction();
            
            $consulta = $request->all();

            $campos =  null;

            $registro = \DB::table('filials as fl')
            ->join('pessoas as p', function($join){
                $join->on('p.id', '=', 'fl.pessoa_id');
            });


            /*$registro->join('cidades', function($join){
                
                $join->on('cidades.id', '=', 'bairros.cidade_id');

            });
            
             */

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
                                
                                $registro->whereIn('id', $val);
                            }
                            break;
                        case 'name':
                            if($val[0] == ','){
                                $val = substr($val, 1);
                            } 
                            if($val[strlen($val) - 1] == ','){
                                $val = substr($val, 0, -1);
                            }
                            
                            $registro->where('name', 'like' , '%'.$val.'%');
                            break;
                        
                        case 'description_to_search':
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
            }//


            if($campos){
                $registro->select($campos);
            }else{
                $registro->select('fl.*', 'p.name as name_filial');

            }
           
            $registro = $registro->where('fl.active', '=', 'yes')
            ->where('p.active', '=', 'yes')->get();

            if(isset($consulta['to_require']) && $consulta['to_require'] == true){
                $dataToRequest = [];
                foreach($registro as $reg){
                    $dataToRequest[] = ['label'=>$reg->name, 'value'=>$reg->id];
                }

                $registro = $dataToRequest;
            }
            
            \DB::commit();
            
            return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);

        }catch(FilialException $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 500);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create(Request $request, $idAssistente)
    {
        try{

            $dadosRequest = $request->all();

            $callBack = $dadosRequest['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';

            return view('admin.filial.create', compact('callBack','idAssistente', 'dadosRequest'));

        }catch(FilialException $e){
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{


            $validator = $this->validaRequest($request);

            $registro = null;
            \DB::beginTransaction();

            $dados = $request->all();
            $user_id = \Auth::User()->id;
            $pessoa = Pessoa::where('active', '=', 'yes')->where('id', '=', $dados['pessoa_id'])->fist();

            if(! $pessoa){
                throw new FilialException('Pessoa não identificada'); 
            }

            if(Filial::where('pessoa_id', '=', $pessoa->id)->first()){                
                throw new FilialException('Já existe uma filial para a pessoa informada.'); 
            }

            $dadosFilial                        = [];
            $dadosFilial['user_id']             = \Auth::User()->id;
            $dadosFilial['pessoa_id']           = $pessoa->id;
            $dadosFilial['dsAtividade']         = $dados['dsAtividade'] ?? null;
            $dadosFilial['dsTextoContrato']     = $dados['dsTextoContrato'] ?? null;
            $dadosFilial['active']              = 'yes';
            
            $registro             = Filial::create($dadosFilial);
            
            if(! $registro){
                throw new FilialException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o supote.');
            }

            \DB::commit();

            return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);


        }catch (FilialException $th) {

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{

            
            if($id <= 0){

                throw new FilialException('Parâmetro inválido. Entre em contato com o supote.');
            }

            \DB::beginTransaction();

            $registro = Filial::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            //dd($registro);

            if(! $registro){

                throw new FilialException('Registro não encontrado.');
            }

            \DB::commit();

            //return view('admin.produto.info', compact('registro'));
            return view('admin.filial.show', compact('registro'));

        }catch(FilialException $e){
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


    public function info(Request $request, $id)
    {
        
        try{

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            \DB::beginTransaction();
            
            if($id <= 0){

                throw new FilialException('Parâmetro inválido. Entre em contato com o supote.');
            }

            $registro = null;

            $registro = Filial::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            if($registro == null){

                throw new FilialException('Registro não encontrado.');
            }

            $registro->logradouro = $registro->logradouro->where('importancia', '=', 'principal')->first()->estado_logradouro->pais;
            $registro->grupo;
            $registro->telefone;
            //dd($registro);

            \DB::commit();

            return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);

        }catch(FilialException $e){
            \DB::rollback();

            //$msg = $e->getMessage();
            //return view('layouts._admin._error', compact('msg'));

            return response()->json(['mensagem'=>$th->getMessage(), 'class'=>'warning'], 400);
    
        }catch(\Exception $e){
            \DB::rollback();

            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }
    /*
        {"mensagem":{"id":1,"name":"Jos\u00e9 Pedro","name_opcional":"Ferreira","documento":"61224450370","documento_complementar":"123456","email":"phedroclooney@gmail.com","nascimento_fundacao":null,"sexo":"m","tipo":"fisica","user_id":1,"user_update_id":1,"active":"yes","created_at":"2022-07-19T02:12:31.000000Z","updated_at":"2022-10-08T23:46:26.000000Z","logradouro":[{"id":1,"cep":"65061-220","cidade":"S\u00e3o luis","logradouro":"Rua S\u00e3o Sebasti\u00e3o","bairro":"Ipase","estado":"1","complemento":"teste","numero":"123","bloco":null,"tipo":"casa","importancia":"principal","user_id":1,"user_update_id":null,"active":"yes","deleted_at":null,"created_at":"2022-07-19T02:12:31.000000Z","updated_at":"2022-07-19T02:12:31.000000Z","pivot":{"pessoa_id":1,"logradouro_id":1},"estado_logradouro":{"id":1,"nmEStado":"Maranh\u00e3o","codEstado":"98","sigla":"MA","padrao":"yes","pais_id":1,"user_id":1,"user_update_id":1,"active":"yes","deleted_at":null,"created_at":"2022-07-19T02:08:36.000000Z","updated_at":"2022-07-19T02:08:36.000000Z","pais":{"id":1,"nmPais":"BRASIL","cdPais":"55","padrao":"yes","user_id":1,"user_update_id":1,"active":"yes","deleted_at":null,"created_at":"2022-07-19T02:07:34.000000Z","updated_at":"2022-07-19T02:07:34.000000Z"}}}],"grupo":[{"id":1,"name":"Cliente","descricao":"Cliente","user_id":1,"user_update_id":null,"active":"yes","deleted_at":null,"created_at":"2022-07-19T02:11:11.000000Z","updated_at":"2022-07-19T02:11:11.000000Z","pivot":{"pessoa_id":1,"groupo_id":1}}],"telefone":[{"id":1,"numero":"(98) 98425-7623","tipo":"celular","whatsapp":"nao","importancia":"principal","pessoa_id":1,"user_id":1,"user_update_id":null,"active":"yes","deleted_at":null,"created_at":"2022-07-19T02:12:31.000000Z","updated_at":"2022-07-19T02:12:31.000000Z"},{"id":2,"numero":"(98) 98425-7623","tipo":"celular","whatsapp":"nao","importancia":"principal","pessoa_id":1,"user_id":1,"user_update_id":null,"active":"yes","deleted_at":null,"created_at":"2022-07-19T02:12:31.000000Z","updated_at":"2022-07-19T02:12:31.000000Z"},{"id":3,"numero":"9894239891","tipo":"fixo","whatsapp":"nao","importancia":"principal","pessoa_id":1,"user_id":1,"user_update_id":null,"active":"yes","deleted_at":null,"created_at":"2022-07-19T02:12:31.000000Z","updated_at":"2022-07-19T02:12:31.000000Z"}]},"class":"sucess"}
    */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function edit(Request $request, $id, $idAssistente)
    {

    	try {
            $dadosRequest = $request->all();

            if($id <= 0){
                throw new FilialException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Filial::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            if(! $registro){
                throw new FilialException('Registro não encontrado');
                
            }

            \DB::commit();

	        return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);


    	}catch(FilialException $e){

            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));

            // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        }catch(\Exception $e){
            \DB::rollback();

            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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
        try{
                        
            $this->validaRequest($request);

            \DB::beginTransaction();



            $registro   = null;
            $user_id    = \Auth::User()->id;
            $erros      = [];
            
            $dados = $request->all();

            $user_id        = \Auth::User()->id;
            $pessoa         = Pessoa::where('active', '=', 'yes')->where('id', '=', $dados['pessoa_id'])->fist();
            $registro       = Filial::where('id', '=', $id)->where('active', '=', 'yes')->first();
            $pessoaFilial   = Filial::where('pessoa_id', '=', $dados['pessoa_id'])->where('active', '=', 'yes')->first();

            if(! $registro){
                $erros[] = "Registro não identificado";
            }

            if(! $pessoa){
                $erros[] = "Pessoa não identificada";
            }

            if($registro && $pessoaFilial && $registro->id != $pessoaFilial->id){
                $erros[] = "Já existe uma pessoa para esta filial";
            }

            if($erros) {

                throw new FilialException(implode("<br/><br/>",$erros));

            }

            $dadosFilial                        = [];
            $dadosFilial['user_id']             = \Auth::User()->id;
            $dadosFilial['pessoa_id']           = $pessoa->id;
            $dadosFilial['dsAtividade']         = $dados['dsAtividade'] ?? null;
            $dadosFilial['dsTextoContrato']     = $dados['dsTextoContrato'] ?? null;
            $dadosFilial['active']              = 'yes';
            
            $registro             = Filial::create($dadosFilial);
            
            if(! $registro){
                throw new FilialException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o supote.');
            }

            \DB::commit();
            return response()->json(['mensagem'=>$registro, 'class' => 'success'], 200);

        }catch(FilialException $e){
            \DB::rollback();

            return response()->json(['mensagem'=>$e->getMessage(), 'class'=>'warning'], 500);

           // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
    
        }catch(\Exception $e){
            \DB::rollback();

            return response()->json(['mensagem'=>$e->getMessage(), 'class'=>'warning'], 500);

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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

                //return redirect()->route('filial.index');
                return response()->json(['mensagem'=>'Erro ao deletar registro', 'class'=>'warning'], 400);

            }

            \DB::beginTransaction();

            $pessoa = Filial::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();
            if(! $pessoa){
                throw new FilialException('Registro não encontrado');
            }

            $pessoa->update(['active'=>'no']);
            $pessoa->delete();

            \DB::commit();
            return response()->json(['mensagem'=>'Registro atulizado com sucesso', 'class'=>'success']);

        }catch(FilialException $e){
            \DB::rollback();

            return response()->json(['mensagem'=>$e->getMessage(), 'class'=>'warning'], 500);

           // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
    
        }catch(\Exception $e){
            \DB::rollback();

            return response()->json(['mensagem'=>$e->getMessage(), 'class'=>'warning'], 500);

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }

    public function head(Request $request)
    {
        $dados = $request->all();
        
        $isReload = isset($dados['isReload']) && $dados['isReload'] == true ? $dados['isReload']: false;
        if($isReload){
           
            return view('admin.filial.head_refresh', compact('isReload'));
        }else{
            return view('admin.filial.head', compact('isReload'));
        }
        
    }


    public function validarCpf($cpf)
    {
        $result = Utilitarios::validaCpf($cpf);

        if($result == true){
            return response()->json(['mensagem'=>'Cpf ok', 'class'=>'success'], 200);
        }

        return response()->json(['mensagem'=>'Cpf inválido', 'class'=>'warning'], 400); 
    }


    public function adicionarPlano($id)
    {
        try{

            if((! isset($id)) || ($id <= 0)){
                return response()->json(['errors'=>['params'=>'Parametro inválido']], 400);
            }

            $registro           = null;
            $formaPagamento     = null;
            $planoPagamento     = null;
            $operadorFinanceiro = null;
            $plano              = null;
            \DB::transaction(function() use (&$id, &$registro, &$formaPagamento, &$planoPagamento, &$operadorFinanceiro, &$plano){
                $registro = Filial::where('active', '=', 'yes')->where('id', '=', $id)->first();

                $formaPagamento         = FormaPagamento::where('active', '=', 'yes')->get();
                $planoPagamento         = PlanoPagamento::where('active', '=', 'yes')->get();
                $operadorFinanceiro     = OperadorFinanceiro::where('active', '=', 'yes')->get();
                $plano                  = Plano::where('active', '=', 'yes')->get();
            });
            
            if(($registro == null) || ($formaPagamento == null) || ($plano == null)){
                 return response()->json(['errors'=>['erro'=>'Erro ao carregar o registro'], 'class'=>'warning'], 400);
            }
            return view('admin.plano.painelVenda', compact('registro', 'formaPagamento', 'planoPagamento', 'operadorFinanceiro', 'plano'));

        }catch(\Exception $e){
            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor '.$e->getMessage().' > '.$e->getFile().' > '.$e->getLine(), 'class'=>'warning'], 500);
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
            
            throw new FilialException($msg);
        }

        return true;
    }

}
