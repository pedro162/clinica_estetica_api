<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Atendimento;
use App\Pessoa;
use App\Profissional;
use App\Filial;
use App\Agenda;
use App\Exceptions\AtendimentoException;
use Illuminate\Support\Facades\Validator;

class AtendimentoController extends Controller
{
   


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
                'name_atendimento'=>'atendimentos.name',
                'name_pessoa'=>'pessoas.name'

            ];

            $registro = \DB::table('atendimentos');
            $registro->join('pessoas', function($join){
                
                $join->on('pessoas.id', '=', 'atendimentos.pessoa_id');

            })->join("profissionals as p", function($join){
                $join->on('p.id', '=', 'atendimentos.profissional_id');
            })->join("pessoas as ppf", function($join){
                $join->on("ppf.id", '=', 'p.pessoa_id');
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
                                
                                $registro->whereIn('atendimentos.id', $val);
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
                                
                                $registro->where('atendimentos.name', 'like' , '%'.$val.'%');
                            }
                        case 'name_pessoa':
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
                        case 'atendimento_id':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                
                                $registro->where('atendimentos.id', '=' , ''.$val.'');
                            }
                            break;
                            case 'sigla':
                                if(is_string($val)){
                                    
                                    if($val[0] == ','){
                                        $val = substr($val, 1);
                                    } 
                                    if($val[strlen($val) - 1] == ','){
                                        $val = substr($val, 0, -1);
                                    }
                                    
                                    $registro->where('atendimentos.sigla', '=' , ''.$val.'');
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
                $registro->select('atendimentos.*', 'pessoas.name as name_pessoa', 'ppf.name as name_profissional');

            }
           
            $registro = $registro->where('atendimentos.active', '=', 'yes')
            ->whereNull('atendimentos.deleted_at')
            ->where('pessoas.active', '=', 'yes')->get();
            
            \DB::commit();

            //dd( $registro);

            return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);

        }catch(AtendimentoException $e){
            \DB::rollback();
             return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage()]], 404);
    
        }catch(\Exception $e){
            \DB::rollback();

            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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

            $this->validaRequest($request);
             
            \DB::beginTransaction();

            $dados = $request->all();

            $pessoas = Pessoa::where('active', '=' ,'yes')->where('id', '=', $dados['pessoa_id'])->first();
            if(! $pessoas){
                throw new AtendimentoException('País não identificado. Tente novamente ou entre em contato com o suporte.');
            }

            $profissional = Profissional::where('id', '=', $dados['profissional_id'])->where('active', '=', 'yes')->first();
            if(! $profissional){
                throw new AtendimentoException('Profissional não identificado');
            }

            $filial = Filial::where('id', '=', $dados['filial_id'])->where('active', '=', 'yes')->first();
            if(! $filial){
                throw new AtendimentoException('Filial não identificada');
            }
 
            $dadosRequest = [];
             
            $dadosRequest['user_id']            = \Auth::User()->id;
            $dadosRequest['name']               = $dados['name'];
            $dadosRequest['historico']          = $dados['historico'];
            $dadosRequest['pessoa_id']          = $pessoas->id;
            $dadosRequest['dt_inicio']          = $dados['dt_inicio'] ?? $dados['dt_marcado'];
            $dadosRequest['hr_inicio']          = $dados['hr_inicio'] ?? $dados['hr_marcado'];
            $dadosRequest['prioridade']         = $dados['prioridade'];
            $dadosRequest['status']             = $dados['status'] ?? 'pendente';
            $dadosRequest['dt_fim']             = $dados['dt_fim'];
            $dadosRequest['hr_fim']             = $dados['hr_fim'];
            $dadosRequest['name_atendido']      = $dados['name_atendido'];
            $dadosRequest['tipo']               = $dados['tipo'] ?? 'consulta';

            $dadosRequest['profissional_id']    = $profissional->id;
            $dadosRequest['filial_id']          = $filial->id;
            
            $dadosRequest['active']             = 'yes';
            
            $registro = Atendimento::create($dadosRequest);
            if(!$registroAgenda){
                throw new AtendimentoException('Erro ao registrar atendimento');
            }

            $dadosRequest = [];
             
            $dadosRequest['user_id']            = \Auth::User()->id;
            $dadosRequest['descricao']          = ucfirst($dados['tipo'] ?? 'consulta');
            $dadosRequest['data']               = $dados['dt_inicio'];
            $dadosRequest['hora']               = $dados['hr_inicio'];
            $dadosRequest['name_atendido']      = $dados['name_atendido'];
            $dadosRequest['status']             = 'pendente';
            $dadosRequest['pessoa_id']          = $profissional->pessoa_id;            
            $dadosRequest['referencia']         = 'atendimentos';
            $dadosRequest['referencia_id']      = $registro->id;            
            $dadosRequest['active']             = 'yes';

            $registroAgenda = Agenda::create($dadosRequest);
            if(!$registroAgenda){
                throw new AtendimentoException('Erro ao registrar agenda');
            }
            \DB::commit();
 
            return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);
 
         }catch(AtendimentoException $e){
             \DB::rollback();
             return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile()], 400);
 
         }catch(\Exception $e){
             \DB::rollback();
             return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile()], 500);
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
        
        try{

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            $callBack = $dados['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if($id <= 0){
                throw new AtendimentoException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Atendimento::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            if($registro == null){
                throw new AtendimentoException('Registro não encontrado');
            }

            $registro->profissional;
            $registro->pessoa;

            \DB::commit();
            return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);

        }catch(AtendimentoException $e){
            \DB::rollback();

            return response()->json(['mensagem'=>$e->getMessage(), 'class'=>'warning'], 400);
            //return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
    
        }catch(\Exception $e){

            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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
                throw new AtendimentoException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Atendimento::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if($registro == null){
                throw new AtendimentoException('Registro não encontrado');
                
            }

            $pessoases = Pessoa::where('active', '=', 'yes')->get();

            \DB::commit();

            return view('admin.estado.edit', compact('registro', 'idAssistente', 'callBack', 'pessoases'));

         }catch(AtendimentoException $e){

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

            $atendimento = Atendimento::where('active', '=', 'yes')->where('id', '=', $id)->first();

            if(! $atendimento){
                throw new AtendimentoException('Atendimento não identificado');
            }

            $pessoas = Pessoa::where('active', '=' ,'yes')->where('id', '=', $dados['pessoa_id'])->first();
            if(! $pessoas){
                throw new AtendimentoException('País não identificado. Tente novamente ou entre em contato com o suporte.');
            }

            $profissional = Profissional::where('id', '=', $dados['profissional_id'])->where('active', '=', 'yes')->first();
            if(! $profissional){
                throw new AtendimentoException('Evento não identificado');
            }

            $filial = Filial::where('id', '=', $dados['filial_id'])->where('active', '=', 'yes')->first();
            if(! $filial){
                throw new AtendimentoException('Filial não identificada');
            }
            //filial_id
            $dadosRequest = [];
             
            $dadosRequest['user_update_id']     = \Auth::User()->id;
            $dadosRequest['name']               = $dados['name'];
            $dadosRequest['historico']          = $dados['historico'];
            $dadosRequest['pessoa_id']          = $pessoas->id;
            $dadosRequest['dt_inicio']          = $dados['dt_inicio'] ?? $dados['dt_marcado'];
            $dadosRequest['hr_inicio']          = $dados['hr_inicio'] ?? $dados['hr_marcado'];
            $dadosRequest['prioridade']         = $dados['prioridade'];
            $dadosRequest['status']             = $dados['status'];
            $dadosRequest['dt_fim']             = $dados['dt_fim'];
            $dadosRequest['hr_fim']             = $dados['hr_fim'];
            $dadosRequest['name_atendido']      = $dados['name_atendido'];
            $dadosRequest['tipo']               = $dados['tipo'] ?? 'consulta';
            $dadosRequest['profissional_id']    = $profissional->id;
            $dadosRequest['filial_id']          = $filial->id;
            
            $atendimento->update($dadosRequest);

            \DB::commit();

            return response()->json(['mensagem'=>$atendimento, 'class'=>'sucess'], 200);


        }catch (AtendimentoException $th) {

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

            \DB::beginTransaction();

            $dadosRequest = [];

            $dadosRequest['user_update_id']     = \Auth::User()->id;//trocar pelo id do usuario logado
            $dadosRequest['active']             = 'no';
            $piscofins = Atendimento::where('active', '=', 'yes')->where('id', '=', $id)->first();
            $piscofins->update($dadosRequest);
            $piscofins->delete();

            \DB::commit();

            return response()->json(['mensagem'=>[], 'class'=>'sucess'], 200);

        }catch (AtendimentoException $th) {

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
            'historico'=> 'required|max:255|min:2',
            'profissional_id'=> 'required|min:1',
            'pessoa_id'=> 'required|min:1',
            'prioridade'=> 'required',
            'dt_marcado'=> 'required',
            'hr_marcado'=> 'required',
        ], [
            'historico.required' => 'O campo "Descrição" é obrigatório.',
            'historico.max' => 'O "Descrição" suporta até :max caracteres.',
            'historico.min' => 'O "Descrição" deve conter pelo menos :min caracteres.',
            'profissional_id.required' => 'O campo "Profissional" é obrigatório.',
            'profissional_id.min' => 'O campo "Profissional" deve ter um valor maior ou igual a :min.',
            'pessoa_id.required' => 'O campo "Pessoa" é obrigatório.',
            'pessoa_id.min' => 'O campo "Pessoa" deve ter um valor maior ou igual a :min.',
            'prioridade.required' => 'O campo "Prioridade" é obrigatório.',
            'dt_marcado.required' => 'O campo "Data" é obrigatório.',
            'hr_marcado.required' => 'O campo "Horário" é obrigatório.',
        ]);
        
        if($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach($errors->all() as $mensagem){
                $msg .= $mensagem.'<br/>';
            }
            
            throw new AtendimentoException($msg);
        }

        return true;
    }

}
