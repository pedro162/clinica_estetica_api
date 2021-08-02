<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\NcmException;
use Illuminate\Validation\Rule;
use App\Ncm;

class NcmController extends Controller
{

    protected function ncmRequest(Request $request)
    {
        return Validator::make($request->all(),[
            'name'=>'required'

        ],[]);
    }
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
                'nome_ncm'=>'ncm.name'

            ];

            $registro = \DB::table('ncms');
            
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
                                
                                $registro->whereIn('ncms.id', $val);
                            }
                            break;
                        case 'ncm':
                            if(is_string($val)){
                                    
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                $val = explode(',', $val);
                                    
                                $registro->whereIn('ncms.ncm', $val);
                            }
                        break;
                        case 'nome_ncm':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                
                                $registro->where('ncms.nmNcm', 'like' , '%'.$val.'%');
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
                $registro->select('ncms.*');

            }
           
            $registro = $registro->where('ncms.active', '=', 'yes')->get();

            
            \DB::commit();

            return view('admin.ncm.index', compact('registro', 'consulta'));

        }catch(NcmException $e){
            \DB::rollback();
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

        return view('admin.ncm.create', compact('callBack','idAssistente'));
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

            \DB::beginTransaction();
            $dados = $request->all();

            $dadosRequest = [];

            $dadosRequest['user_id']            = \Auth::User()->id;//trocar pelo id do usuario logado
            $dadosRequest['active']             = 'yes';
            $dadosRequest['codNcm']             = $dados['codNcm'];
            $dadosRequest['nmNcm']              = $dados['nmNcm'];
            $dadosRequest['excecaoNcm']         = $dados['excecaoNcm'] ?? null;
            $dadosRequest['tpCodigo']           = $dados['tpCodigo'] ?? 'NCM';
            $dadosRequest['exTipi']             = $dados['exTipi'] ?? null;
            $dadosRequest['nmTabela']           = $dados['nmTabela'] ?? null;
            $dadosRequest['vrAliqNacional']     = $dados['vrAliqNacional'] ?? 0;
            $dadosRequest['vrAliqImportada']    = $dados['vrAliqImportada'] ?? 0;
            $dadosRequest['vrAliqEstadual']     = $dados['vrAliqEstadual'] ?? 0;
            $dadosRequest['vrAliqMunicipal']    = $dados['vrAliqMunicipal'] ?? 0;
           
            $registro = Ncm::create($dadosRequest);
            \DB::commit();

            if($registro){
                return response()->json(['mensagem'=>$registro, 'class'=>'sucess'], 200);
            }else{
                throw new NcmException('Erro ao cadastrar NCM');
            }

        }catch(NcmException $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 400);

        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }

    public function info(Request $request, $id, $idAssistente)
    {
        
        try{

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            $callBack = $dados['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';


            if($id <= 0){

                throw new NcmException('Parâmetro ínválido');

            }

            \DB::beginTransaction();

            $registro = Ncm::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            if($registro == null){

                throw new NcmException('Ncm não encontrado');
            }

            \DB::commit();

            //return view('admin.produto.info', compact('registro'));
            return view('admin.ncm.info', compact('registro', 'idAssistente', 'callBack'));

        }catch(NcmException $e){
            
            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));
            //return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 400);

        }catch(\Exception $e){

            $msg = 'Ocorreum um erro no servidor: '.$e->getMessage();
            return view('layouts._admin._error', compact('msg'));
           // \Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
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
                throw new NcmException('Parâmetro ínválido');
            }

            $registro = null;
            $marcas = null;
            $categorias = null;

            \DB::beginTransaction();

            $registro = Ncm::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if($registro == null){
                throw new NcmException('Registro não encontrado');
                
            }

            \DB::commit();

            return view('admin.ncm.edit', compact('registro', 'marcas', 'categorias', 'idAssistente', 'callBack'));

         }catch(\NcmException $e){
            \DB::rollback();
            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

             return response()->json(['mensagem'=>$e->getMessage(), 'class'=>'warning'], 400);

        }catch(\Exception $e){
            \DB::rollback();
            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

             return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);

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
            //code...
            \DB::beginTransaction();

            $dados = $request->all();

            $dadosRequest = [];

            $dadosRequest['user_id']            = \Auth::User()->id;//trocar pelo id do usuario logado
            $dadosRequest['active']             = 'yes';
            $dadosRequest['codNcm']             = $dados['codNcm'];
            $dadosRequest['nmNcm']              = $dados['nmNcm'];
            $dadosRequest['excecaoNcm']         = $dados['excecaoNcm'] ?? null;
            $dadosRequest['tpCodigo']           = $dados['tpCodigo'] ?? 'NCM';
            $dadosRequest['exTipi']             = $dados['exTipi'] ?? null;
            $dadosRequest['nmTabela']           = $dados['nmTabela'] ?? null;
            $dadosRequest['vrAliqNacional']     = $dados['vrAliqNacional'] ?? 0;
            $dadosRequest['vrAliqImportada']    = $dados['vrAliqImportada'] ?? 0;
            $dadosRequest['vrAliqEstadual']     = $dados['vrAliqEstadual'] ?? 0;
            $dadosRequest['vrAliqMunicipal']    = $dados['vrAliqMunicipal'] ?? 0;
           
            $ncm = Ncm::where('active', '=', 'yes')->where('id', '=', $id)->first();
            $ncm->update($dadosRequest);

            \DB::commit();

            return response()->json(['mensagem'=>$ncm, 'class'=>'sucess'], 200);


        }catch (NcmException $th) {

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
            $ncm = Ncm::where('active', '=', 'yes')->where('id', '=', $id)->first();
            $ncm->update($dadosRequest);
            $ncm->delete();

            \DB::commit();

            return response()->json(['mensagem'=>[], 'class'=>'sucess'], 200);

        }catch (NcmException $th) {

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
           
            return view('admin.ncm.head_refresh', compact('isReload'));
        }else{
            return view('admin.ncm.head', compact('isReload'));
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tributar(Request $request, $id, $idAssistente)
    {
        try{

            $dados = $request->all();

            $id = $id ?? $dados['id'];
            $callBack = $dados['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if( (!isset($id)) || ($id <= 0)){
               // return response()->json(['errors'=>['error'=>'Parâmetro inválido']], 400);
            }

            if( (!isset($id)) || ($id <= 0)){
               // return response()->json(['errors'=>['error'=>'Parâmetro inválido']], 400);
            }

            \DB::beginTransaction();
            $registro = '';

            \DB::commit();

            return view('admin.ncm.tributar', compact('registro', 'idAssistente', 'callBack'));
        
        }catch(NcmException $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 400);
       
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }
}
