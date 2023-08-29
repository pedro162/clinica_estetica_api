<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\ContaReceber as CobrancaReceber;
use \App\Pessoa;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\Utilitarios;
use \App\OperadorFinanceiro;
use \App\OrdemServico;
use \App\Filial;
use \App\VendaItem;
use \App\Venda;
use \App\ServicoItem;
use \App\Servico;
use \App\User;
use \App\Rca;
use \App\Exceptions\CobrancaReceberException;
use \App\ExceptionApplication;
use Illuminate\Support\Facades\Validator;



class CobrancaReceberController extends Controller
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
               
            ];

            $registro = \DB::table('conta_recebers');
            $registro->join('pessoas', function($join){                
                $join->on('pessoas.id', '=', 'conta_recebers.pessoa_id');

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
                                
                                $registro->whereIn('conta_recebers.id', $val);
                            }
                            break;
                        case 'nmPessoa':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                
                                $registro->where('pessoas.name', 'like' , '%'.$val.'%');
                            }
                            break;
                        case 'pessoa_id':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                $val = explode(',', $val);
                                
                                $registro->whereIn('pessoas.id', $val);
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
                $registro->select('conta_recebers.*', 'pessoas.name');

            }
           
            $registro = $registro->where('conta_recebers.active', '=', 'yes')
            ->where('pessoas.active', '=', 'yes')->get();

            \DB::commit();

            //dd( $registro);

            return view('admin.cobranca_receber.index', compact('registro', 'consulta'));

        }catch(CobrancaReceberException $e){
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
            $campos =  null;
            $parse = [
               
            ];

            $registro = \DB::table('conta_recebers as cr');
            $registro->join('pessoas', function($join){                
                $join->on('pessoas.id', '=', 'cr.pessoa_id');

            })->join('filials as fl', function($join){
                
                $join->on('cr.filial_id', '=', 'fl.id');

            })->join('pessoas as pesfl', function($join){
                
                $join->on('fl.pessoa_id', '=', 'pesfl.id');

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
                                
                                $registro->whereIn('cr.id', $val);
                            }
                            break;
                        case 'nmPessoa':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                
                                $registro->where('pessoas.name', 'like' , '%'.$val.'%');
                            }
                            break;
                        case 'pessoa_id':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                $val = explode(',', $val);
                                
                                $registro->whereIn('pessoas.id', $val);
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
                $registro->select('cr.*', 'pessoas.name', 'pesfl.name as name_filial');

            }
           
            $registro = $registro->where('cr.active', '=', 'yes')
            ->where('pessoas.active', '=', 'yes')->get();

            \DB::commit();
            
            if(isset($consulta['to_require']) && $consulta['to_require'] == true){
                $dataToRequest = [];
                foreach($registro as $reg){
                    $dataToRequest[] = ['label'=>$reg->name, 'value'=>$reg->id];
                }

                $registro = $dataToRequest;
            }

            return response()->json(['mensagem'=>$registro, 'class'=>'success'], 201);


        }catch(CobrancaReceberException $e){
            \DB::rollback();

            $msg = $e->getMessage();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
    
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
        return view('admin.cobranca_receber.create', compact('callBack','idAssistente'));
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

            $pessoa = Pessoa::where('active', '=' ,'yes')->where('id', '=', $dados['pessoa_id'])->first();
            if(! $pessoa){
                throw new CobrancaReceberException('Pessoa não identificada. Tente novamente ou entre em contato com o suporte.');
            }
 
            $dadosRequest = [];
             
            $dadosRequest['referencia_id']              = $dados['referencia_id']           ?? null;
            $dadosRequest['referencia']                 = $dados['referencia']              ?? null;
            $dadosRequest['pessoa_id']                  = $pessoa->id;
            $dadosRequest['descricao']                  = $dados['descricao'];
            $dadosRequest['documento']                  = $dados['documento']               ?? null;
            $dadosRequest['dtVencimentoOriginal']       = $dados['dtVencimentoOriginal'];
            $dadosRequest['dtVencimento']               = $dados['dtVencimento']            ?? null;
            $dadosRequest['vrBruto']                    = $dados['vrBruto'];
            $dadosRequest['vrLiquido']                  = $dados['vrLiquido'];
            $dadosRequest['vrDevolvido']                = $dados['vrDevolvido']             ?? 0;
            $dadosRequest['vrPago']                     = $dados['vrPago']                  ?? 0;
            $dadosRequest['vrTaxa']                     = $dados['vrTaxa']                  ?? 0;
            $dadosRequest['vrDesconto']                 = $dados['vrDesconto']              ?? 0;
            $dadosRequest['vrJuros']                    = $dados['vrJuros']                 ?? 0;
            $dadosRequest['user_id']                    = \Auth::User()->id;
            $dadosRequest['user_update_id']             = null;
            $dadosRequest['active']                     =  'yes';

             
            $registro = CobrancaReceber::create($dadosRequest);
            \DB::commit();
 
            if($registro){
                return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);
            }else{
                throw new CobrancaReceberException('Erro ao cadastrar');
            }
 
         }catch(CobrancaReceberException $e){
             \DB::rollback();
             return response()->json(['errors'=>['error'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 400);
 
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
                throw new CobrancaReceberException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = CobrancaReceber::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            if($registro == null){
                throw new CobrancaReceberException('Registro não encontrado');
            }

            \DB::commit();

            //return view('admin.produto.info', compact('registro'));
            return view('admin.cobranca_receber.info', compact('registro', 'idAssistente', 'callBack'));

        }catch(CobrancaReceberException $e){
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
                throw new CobrancaReceberException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = CobrancaReceber::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if($registro == null){
                throw new CobrancaReceberException('Registro não encontrado');
                
            }

            \DB::commit();

            return view('admin.cobranca_receber.edit', compact('registro', 'idAssistente', 'callBack'));

         }catch(CobrancaReceberException $e){

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

            $dadosRequest = [];         
             
            $dadosRequest['referencia_id']              = $dados['referencia_id']           ?? null;
            $dadosRequest['referencia']                 = $dados['referencia']              ?? null;
            $dadosRequest['pessoa_id']                  = $pessoa->id;
            $dadosRequest['descricao']                  = $dados['descricao'];
            $dadosRequest['documento']                  = $dados['documento']               ?? null;
            $dadosRequest['dtVencimentoOriginal']       = $dados['dtVencimentoOriginal'];
            $dadosRequest['dtVencimento']               = $dados['dtVencimento']            ?? null;
            $dadosRequest['vrBruto']                    = $dados['vrBruto'];
            $dadosRequest['vrLiquido']                  = $dados['vrLiquido'];
            $dadosRequest['vrDevolvido']                = $dados['vrDevolvido']             ?? 0;
            $dadosRequest['vrPago']                     = $dados['vrPago']                  ?? 0;
            $dadosRequest['vrTaxa']                     = $dados['vrTaxa']                  ?? 0;
            $dadosRequest['vrDesconto']                 = $dados['vrDesconto']              ?? 0;
            $dadosRequest['vrJuros']                    = $dados['vrJuros']                 ?? 0;
            $dadosRequest['user_update_id']             = \Auth::User()->id;
            $dadosRequest['active']                     =  'yes';
           
            $registro = CobrancaReceber::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if(! $registro){
                throw new CobrancaReceberException('Registro não identificado');
            }

            $registro->update($dadosRequest);

            \DB::commit();

            return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);


        }catch (CobrancaReceberException $th) {

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
            $registro = CobrancaReceber::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if(! $registro){
                throw new CobrancaReceberException('Registro não identificado');
            }

            $registro->update($dadosRequest);
            $registro->delete();

            \DB::commit();

            return response()->json(['mensagem'=>[], 'class'=>'sucess'], 200);

        }catch (CobrancaReceberException $th) {

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
           
            return view('admin.cobranca_receber.head_refresh', compact('isReload'));
        }else{
            return view('admin.cobranca_receber.head', compact('isReload'));
        }
        
    }

    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'descricao'=> 'required|max:255|min:2',
            'pessoa_id'=> 'required|min:1',
            'vrBruto'   => 'required',
        ], [
            'descricao.required' => 'Informe uma descrição para o contas a receber.',
            'descricao.max' => 'A descrição deve ter até :max caracteres.',
            'descricao.min' => 'A descrição deve conter pelo menos :min caracteres.',
            'pessoa_id.required' => 'Informe o código da pessoa titular do conta a receber.',
            'pessoa_id.min' => 'O código da pessoa deve ter pelo menos  :min caracteres.',
            'vrBruto.required' => 'Informe o valor bruto do contas a receber.',
        ]);
        
        if($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach($errors->all() as $mensagem){
                $msg .= $mensagem.'<br/>';
            }
            
            throw new CobrancaReceberException($msg);
        }

        return true;
    }

}
