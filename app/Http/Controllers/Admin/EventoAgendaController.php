<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\EventoAgendaExcepton;
use App\EventoAgenda;

class EventoAgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function json(Request $request)
    {

        try {
            \DB::beginTransaction();
            
            $consulta = $request->all();

            $campos =  null;

            $registro = EventoAgenda::where('active', '=', 'yes');

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
            
            \DB::commit();
            
            return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);

        }catch(EventoAgendaExcepton $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
    
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


            $validator = $this->validaRequest($request);

            $registro = null;
            \DB::beginTransaction();

            $dados = $request->all();
            $user_id = \Auth::User()->id;

            $dadosEvento                = $request->only('name');
            $dadosEvento['user_id']     = $user_id;
            $dadosEvento['active']      = 'yes';
            $result = EventoAgenda::create($dadosEvento);

            if(! $result){

                throw new EventoAgendaExcepton('Não foi possível concluir a operação. Tente novamente ou entre em contato com o supote.');

            }

            \DB::commit();

            return response()->json(['mensagem'=>$result, 'class'=>'sucess'], 200);


        }catch (EventoAgendaExcepton $th) {

            \DB::rollback();

            return response()->json(['mensagem'=>$th->getMessage(), 'class'=>'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor: '.$th->getMessage(), 'class'=>'warning'], 500);
            //throw $th;
        }
    }

    

    public function info(Request $request, $id)
    {
        
        try{

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            \DB::beginTransaction();
            
            if($id <= 0){

                throw new EventoAgendaExcepton('Parâmetro inválido. Entre em contato com o supote.');
            }

            $registro = null;

            $registro = EventoAgenda::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            if($registro == null){

                throw new EventoAgendaExcepton('Registro não encontrado.');
            }

            \DB::commit();

            return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);

        }catch(EventoAgendaExcepton $e){
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

        try {
            $dadosRequest = $request->all();

            if($id <= 0){
                throw new EventoAgendaExcepton('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = EventoAgenda::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            if(! $registro){
                throw new EventoAgendaExcepton('Registro não encontrado');
                
            }

            \DB::commit();

            return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);


        }catch(EventoAgendaExcepton $e){

            \DB::rollback();
            
             return response()->json(['errors'=>['error'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 400);

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



            $user_id    = \Auth::User()->id;
            $erros      = [];
            
            $dados = $request->all();

            $dadosEvento                        = $request->only('name');   
            //$dadosEvento['user_update_id']      = $user_id;
            
            $eventoAgenda = EventoAgenda::where('id', '=', $id)->where('active', '=', 'yes')->first();
            if(! $eventoAgenda){
                throw new EventoAgendaExcepton('Evento não identificado');
            }

            $eventoAgenda->update($dadosEvento);

            \DB::commit();
            return response()->json(['mensagem'=>$eventoAgenda, 'class' => 'success'], 200);

        }catch(EventoAgendaExcepton $e){
            \DB::rollback();

            return response()->json(['mensagem'=>$e->getMessage(), 'class'=>'warning'], 400);

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

                //return redirect()->route('pessoa.index');
                return response()->json(['mensagem'=>'Erro ao deletar registro', 'class'=>'warning'], 400);

            }

            \DB::beginTransaction();

            $eventoAgenda = EventoAgenda::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();
            if(! $eventoAgenda){
                throw new EventoAgendaExcepton('Registro não encontrado');
            }

            $eventoAgenda->update(['active'=>'no']);
            $eventoAgenda->delete();

            \DB::commit();
            return response()->json(['mensagem'=>'Registro atulizado com sucesso', 'class'=>'success']);

        }catch(EventoAgendaExcepton $e){
            \DB::rollback();

            return response()->json(['mensagem'=>$e->getMessage(), 'class'=>'warning'], 400);

           // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
    
        }catch(\Exception $e){
            \DB::rollback();

            return response()->json(['mensagem'=>$e->getMessage(), 'class'=>'warning'], 500);

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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
            
            throw new EventoAgendaExcepton($msg);
        }

        return true;
    }
}
