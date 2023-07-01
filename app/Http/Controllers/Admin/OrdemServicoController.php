<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Formulario;
use \App\Marca;
use \App\Categoria;
use \App\Exceptions\OrdemServicoException;
use \App\FormularioGrupo;
use \App\Servico;
use \App\OrdemServico;
use \App\ServicoItem;
use \App\Pessoa;
use \App\Filial;
use \App\Profissional;
use \App\Rca;
use \App\Utilitarios;
use Illuminate\Support\Facades\Auth;

class OrdemServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $idAssistente)
    {
        
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


            set_time_limit(9000000);

            \DB::beginTransaction();

            $this->validaRequest($request);

            $dados = $request->all();

            $pessoas = Pessoa::where('active', '=' ,'yes')->where('id', '=', $dados['pessoa_id'])->first();
            if(! $pessoas){
                throw new OrdemServicoException('Pessoa não identificada. Tente novamente ou entre em contato com o suporte.');
            }

            $profissional = Profissional::where('id', '=', $dados['profissional_id'])->where('active', '=', 'yes')->first();
            if(! $profissional){
                throw new OrdemServicoException('Profissional não identificado');
            }

            $filial = Filial::where('id', '=', $dados['filial_id'])->where('active', '=', 'yes')->first();
            if(! $filial){
                throw new OrdemServicoException('Filial não identificada');
            }

            $pessoaRca = Rca::where('active', '=' ,'yes')->where('id', '=', $dados['rca_id'])->first();
            if(! $pessoaRca){
                throw new OrdemServicoException('Vendedor não identificado. Tente novamente ou entre em contato com o suporte.');
            }
            
            $dadosRequest = [];

            $dadosRequest['status']           = $dados['status'] ?? 'aberto';
            $dadosRequest['pessoa_id']        = $pessoas->id;
            $dadosRequest['pessoa_rca_id']    = $pessoaRca->pessoa_id;
            $dadosRequest['filial_id']        = $filial->id;
            $dadosRequest['vrTotal']          = 0;
            $dadosRequest['vr_final']         = 0;
            $dadosRequest['vr_desconto']      = 0;
            $dadosRequest['pct_acrescimo']    = 0;
            $dadosRequest['vr_acrescimo']     = 0;        
            $dadosRequest['user_id']          = \Auth::User()->id;//trocar pelo id do usuario logado
            $dadosRequest['active']           = 'yes';
            
            $form = OrdemServico::create($dadosRequest);

            \DB::commit();
            
            if(! $form){
                throw new OrdemServicoException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte.');
            }

            return response()->json(['mensagem'=>$form, 'class'=>'success'], 200);

        }catch(OrdemServicoException $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Error $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function concluir(Request $request, $id)
    {

        try{


            $this->validaRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();

            $id             = $id ?? $dados['id'];
            $callBack       = $dados['callBack'] ?? '';
            $idAssistente   =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if( (!isset($id)) || ($id <= 0)){
                throw new OrdemServicoException('Parâmetro inválido');
            }

            $registro = OrdemServico::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if(! $registro){
                throw new OrdemServicoException('Ordem de serviço não identificada. Tente novamente ou entre em contato com o suporte.');
            }

            $servicosArr = $registro->servico()->where('active', '=', 'yes')->get();
            if(! $servicosArr){
                throw new OrdemServicoException('Servições não identificados. Tente novamente ou entre em contato com o suporte.');
            }
            $vrTotSevicos       = 0;
            $vrTotDesconto      = 0;
            $vrTotServicoFinal  = 0;

            foreach($servicosArr as $item){
                
                $vrTotSevicos       += $item->vrTotal;
                $vrTotDesconto      += $item->vr_desconto;
                $vrTotServicoFinal  += $item->vr_final;
            }
            

            $dadosRequest = [];
            $dadosRequest['vrTotal']          = $vrTotSevicos;
            $dadosRequest['vr_final']         = $vrTotServicoFinal;
            $dadosRequest['vr_desconto']      = $vrTotDesconto;
            $dadosRequest['pct_desconto']     = ($vrTotDesconto / $vrTotSevicos ) * 100;
            $dadosRequest['status']           = 'aberto';
            $dadosRequest['pct_acrescimo']    = 0;
            $dadosRequest['vr_acrescimo']     = 0;
            $dadosRequest['user_update_id']         = \Auth::User()->id;
            $registro->update($dadosRequest);


            if(! $registro){
                throw new OrdemServicoException('Registro não encontrado');
            }
            
            
            \DB::commit();
            return response()->json(['mensagem'=>$registro, 'class'=>'success'], 200);
        
        }catch(OrdemServicoException $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Error $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $idAssistente)
    {
        
    }


    public function info(Request $request, $id)
    {
        
        try{


            $dados = $request->all();
            $id = $id ?? $dados['id'];
            $callBack = $dados['callBack'] ?? '';
            if($id <= 0){
                throw new OrdemServicoException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = OrdemServico::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();
            $registro->pessoa;
            $dataItens = [];
            if( $registro->item){
                foreach( $registro->item as $key=>$item){
                    $dataItens[] = $item->servico;
                }
            }
            /* $dataCobrancas = [];
            if( $registro->cobranca){
                foreach( $registro->cobranca as $key=>$cobranca){
                    $dataCobrancas[] = $cobranca;//->servico;
                }
            } */

            $registro->cobranca;// = $dataCobrancas;
            $registro->item = $dataItens;
            //$registro->item;
            $registro->rca;
            $registro->filial;
            




            if($registro == null){
                throw new OrdemServicoException(' não encontrado');
            }
           
            \DB::commit();

            return response()->json(['mensagem'=>$registro, 'class'=>'success'], 200);

        }catch(OrdemServicoException $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Error $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 500);
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

                

            }

            

         }catch(\Exception $e){

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
        try{

            $this->validaRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();

            $id             = $id ?? $dados['id'];
            $callBack       = $dados['callBack'] ?? '';
            $idAssistente   =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if( (!isset($id)) || ($id <= 0)){
                return response()->json(['errors'=>['error'=>'Parâmetro inválido']], 400);
            }

            $registro = OrdemServico::where('active', '=', 'yes')->where('id', '=', $id)->first();

            $dadosRequest = [];
            $dadosRequest['name']                   = $dados['name'];
            $dadosRequest['descricao']              = $dados['descricao']       ?? null;
            $dadosRequest['vrServico']              = $dados['vrServico']       ?? null;
            $dadosRequest['user_update_id']         = \Auth::User()->id;
            $registro->update($dadosRequest);


            if(! $registro){
                throw new OrdemServicoException('Registro não encontrado');
            }
            
            
            \DB::commit();
            return response()->json(['mensagem'=>$registro, 'class'=>'success'], 200);
        
        }catch(OrdemServicoException $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Error $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 500);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adicionarItem(Request $request, $id)
    {
        try{

            $this->validaAddItemRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();

            $id             = $id ?? $dados['id'];
            $callBack       = $dados['callBack'] ?? '';
            $idAssistente   = $idAssistente ?? $dados['idAssistente'] ?? '';
            $idServico      = $dados['servico_id'] ?? 0;
            $erros          = [];
            $vrItem         = $dados['vrItem']          ?? 0;
            $vrItemBruto    = $dados['vrItemBruto']     ?? 0;
            $qtd            = $dados['qtd']             ?? 0;
            $pct_desconto   = $dados['pct_desconto']    ?? 0;
            $vrDesconto     = 0;
            $vrAcrecimos    = 0;
            $pctAcrecimos   = 0;

            if( (!isset($id)) || ($id <= 0)){
                throw new OrdemServicoException('Parâmetro para ordem de serviço inválido. Tente novamente ou entre em contato com o suporte');
            }

            $registro = OrdemServico::where('active', '=', 'yes')->where('id', '=', $id)->first();

            /* $dadosRequest = [];
            $dadosRequest['name']                   = $dados['name'];
            $dadosRequest['descricao']              = $dados['descricao']       ?? null;
            $dadosRequest['vrServico']              = $dados['vrServico']       ?? null;
            $dadosRequest['user_update_id']         = \Auth::User()->id;
            $registro->update($dadosRequest); */


            if(! $registro){
                throw new OrdemServicoException('Registro não encontrado');
            }

            $servico = Servico::where('active', '=', 'yes')->where('id', '=', $idServico)->first();
            if(! $servico){
                throw new OrdemServicoException('Serviço não encontrado');
            }

            if(! ($servico->vrServico > 0) ){
                throw new OrdemServicoException('O serviço de código nº '.$servico->id.' está sem preço de venda válido. Entre em contato com o gerente ou administrador.');
            }
            $servicoItem = null;
            if(isset($dados['os_item_id']) && $dados['os_item_id'] > 0){ 
                
                $servicoItem = ServicoItem::where('id', '=', $dados['os_item_id'])->first();
                if(! $servicoItem){
                    throw new OrdemServicoException('Registro não encontrado para atualizar.');
                }
            }

            //---pegar todas as configurações da tela do usuário
            //--- O valor do item e odesconto devem vir da tela do vendedor
            //--- Se o valor do item for maior que o valor de tabela, fazer o valor do item como valor de tabela

           /*  if($vrItem  < $servico->vrServico){
                $vrDesconto = $servico->vrServico - $vrItem;
                if(! ($vrDesconto > 0.01)){
                    $vrDesconto     = 0;
                    $pct_desconto   = 0;
                    $vrItem         = $servico->vrServico;
                }
            }

            if($servico->vrServico < $vrItem){

                $vrAcres        = $vrItem - $servico->vrServico;
                if(! ($vrAcres > 0.01)){
                    $vrAcrecimos    = 0;                
                    $pctAcrecimos   = 0;
                }else{

                    $pctAcrecimos   = ($vrAcres / $servico->vrServico);
                    $vrAcrecimos    = $servico->vrServico * $pctAcrecimos;                
                    $pctAcrecimos   = $pctAcrecimos * 100;
                }
                
            }
             */
            
            $vrItem         = Utilitarios::removeMaskMoney($vrItem);
            $vrItemBruto    = Utilitarios::removeMaskMoney($vrItemBruto);
            $pct_desconto   = Utilitarios::removeMaskMoney($pct_desconto);
            if($pct_desconto > 100){
                $pct_desconto = 100;

            }elseif($pct_desconto < 0){
                $pct_desconto = 0;

            }
            
            $vrDesconto     = $vrItemBruto * ($pct_desconto / 100);
            $dadosRequest   = [];

            $dadosRequest['qtd']                = $qtd;
            $dadosRequest['servico_id']         = $servico->id;
            $dadosRequest['vrItemBruto']        = $vrItemBruto;
            $dadosRequest['vrItem']             = $vrItem;
            $dadosRequest['vrTotal']            = $vrItemBruto * $qtd;
            $dadosRequest['ordem_servico_id']   = $registro->id;
            $dadosRequest['pct_acrescimo']      = $pctAcrecimos;
            $dadosRequest['vr_acrescimo']       = $vrAcrecimos;
            $dadosRequest['pct_desconto']       = $pct_desconto;    
            $dadosRequest['vr_desconto']        = $vrDesconto;//--- Valor de desconto unitário
            $dadosRequest['vr_final']           = $dadosRequest['vrItem'] * $dadosRequest['qtd'];   
            $dadosRequest['user_id']            = \Auth::User()->id;//trocar pelo id do usuario logado
            $dadosRequest['active']             = 'yes';

            if($servicoItem){
                $dadosRequest['user_update_id']   = \Auth::User()->id;
                $servicoItem->update($dadosRequest);

            }else{
                $servicoItem = ServicoItem::create($dadosRequest);
            }

            //---Recalcula a ordem de serviço
            $registro = $this->recalcularOrdemServico($registro->id);
            
            
            \DB::commit();
            return response()->json(['mensagem'=>$registro, 'class'=>'success'], 200);
        
        }catch(OrdemServicoException $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Error $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removerItem($id)
    {
        try{

            \DB::beginTransaction();

            if($id <= 0){
                throw new OrdemServicoException("Parâmetro inválido.");
            }

            $registro = ServicoItem::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            if(! $registro){
                throw new OrdemServicoException("Item não identificado.");
            }
            
            $ordem = $registro->ordem;
            if(! $ordem){
                throw new OrdemServicoException("Ordem d serviço não identificada.");
            }

            if(trim($ordem->is_faturado) == 'yes'){
                throw new OrdemServicoException("A ordem de serviço de código nº {$ordem->id} encontra-se faturada e não poderá ser modificada.");
            }

            if(! in_array($ordem->status, ['aberto'])){
                throw new OrdemServicoException("A ordem de serviço de código nº {$ordem->id} encontra-se \"{$ordem->status}\" e não poderá ser modificada.");
            }

            $response = $registro->update(['active'=>'no']);

            if(! $response){
                throw new OrdemServicoException("Erro ao exclir registro.");
            }
            $registro = $registro->delete();
            $this->recalcularOrdemServico($ordem->id);

            \DB::commit();
            return response()->json(['mensagem'=>'Registro deletado com sucesso', 'class'=>'success'], 200);
        
        }catch(OrdemServicoException $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Error $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function recalcularOrdemServico($id)
    {


        if( (!isset($id)) || ($id <= 0)){
            throw new OrdemServicoException('Parâmetro inválido');
        }

        $registro = OrdemServico::where('active', '=', 'yes')->where('id', '=', $id)->first();
        if(! $registro){
            throw new OrdemServicoException('Ordem de serviço não identificada. Tente novamente ou entre em contato com o suporte.');
        }

        $servicosArr = $registro->item()->where('active', '=', 'yes')->get();
        if(! $servicosArr){
            throw new OrdemServicoException('Servições não identificados. Tente novamente ou entre em contato com o suporte.');
        }
        $vrTotSevicos       = 0;
        $vrTotDesconto      = 0;
        $vrTotServicoFinal  = 0;

        foreach($servicosArr as $item){
            
            $vrTotSevicos       += $item->vrTotal;
            $vrTotDesconto      += $item->vr_desconto;
            $vrTotServicoFinal  += $item->vr_final;
        }
        

        $dadosRequest = [];
        $dadosRequest['vrTotal']          = $vrTotSevicos;
        $dadosRequest['vr_final']         = $vrTotServicoFinal;
        $dadosRequest['vr_desconto']      = $vrTotDesconto;
        $dadosRequest['pct_desconto']     = ($vrTotDesconto / $vrTotSevicos ) * 100;
        $dadosRequest['pct_acrescimo']    = 0;
        $dadosRequest['vr_acrescimo']     = 0;
        $dadosRequest['user_update_id']         = \Auth::User()->id;
        $registro->update($dadosRequest);


        if(! $registro){
            throw new OrdemServicoException('Registro não encontrado');
        }

        return $registro;
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

            if($id <= 0){
                 return response()->json([['mensagem'=>'Parâmetro inválido', 'class'=>'warning'], 400]);

            }

            $registro = OrdemServico::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();
            if(! $registro){
                return response()->json(['mensagem'=>'Erro ao exclir registro', 'class'=>'warning'], 400);
            }else{

                $registro = $registro->update(['active'=>'no']);

            }

            if($registro == null){

                //\Session::flash('mensagem', ['msg'=>' não encontrado', 'class'=>'alert alert-danger']);
                //return redirect()->back();
                 return response()->json(['mensagem'=>'Erro ao exclir registro', 'class'=>'warning'], 400);
            }

            \DB::commit();
            return response()->json(['mensagem'=>'Registro deletado com sucesso', 'class'=>'success'], 200);
        
        }catch(OrdemServicoException $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Error $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);
    
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['mensagem'=>$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 500);
        }
    }

    public function head(Request $request)
    {
        
        
    }

    
    /**
     * Return a listing of the resource in json.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {
        try{
            
            //$this->validaRequest($request);

            \DB::beginTransaction();

            $consulta = $request->all();
            //dd($consulta);

            $parse = [

            ];

            $registro = \DB::table('ordem_servicos as os')->join('pessoas as pes', function($join){
                
                $join->on('os.pessoa_id', '=', 'pes.id');

            })->join('pessoas as pesrc', function($join){
                
                $join->on('os.pessoa_rca_id', '=', 'pesrc.id');

            })->join('filials as fl', function($join){
                
                $join->on('os.filial_id', '=', 'fl.id');

            })->join('pessoas as pesfl', function($join){
                
                $join->on('fl.pessoa_id', '=', 'pesfl.id');

            })->join('profissionals as pf', function($join){
                
                $join->on('os.profissional_id', '=', 'pf.id');

            })->join('pessoas as pesprf', function($join){
                
                $join->on('pf.pessoa_id', '=', 'pesprf.id');

            });

            $campos =  null;
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
                                
                                $registro->whereIn('os.id', $val);
                            }
                            break;
                        case 'nome_pssoa':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                
                                $registro->where('pes.name', 'like' , '%'.$val.'%');
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
                                    $campos = $this->montaCamposConsulta($registro, $val);
                                    
                                }
                            break;

                    }
                }
            }
            if($campos){
                $registro->select($campos);

            }else{
                $registro->select('os.*', 'pes.name', 'pesrc.name as name_rca', 'pesfl.name as name_filial', 'pesprf.name as name_profissional');

            }
            //$registro = \App\::where('active', '=', 'yes')->get();
            $registro = $registro->where('os.active', '=', 'yes')->get();


            \DB::commit();

            return response()->json(['mensagem'=>$registro, 'class'=>'success'], 201);

        }catch(OrdemServicoException $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
    
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }



    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'filial_id'=> 'required|min:1',
            'pessoa_id'=> 'required|min:1',
            'rca_id'=> 'required|min:1',
        ], [
            'filial_id.required' => 'O campo "Filial" é obrigatório.',
            'filial_id.min' => 'O "Filial" deve conter pelo menos :min caracteres.',
            'pessoa_id.required' => 'O campo "Pessoa" é obrigatório.',
            'pessoa_id.min' => 'O "Pessoa" deve conter pelo menos :min caracteres.',
            'rca_id.required' => 'O campo "Vendedor" é obrigatório.',
            'rca_id.min' => 'O "Vendedor" deve conter pelo menos :min caracteres.',
        ]);
        
        if($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach($errors->all() as $mensagem){
                $msg .= $mensagem.'<br/>';
            }
            
            throw new OrdemServicoException($msg);
        }

        return true;
    }

    protected function validaAddItemRequest(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'servico_id'=> 'required|min:1',
            'qtd'=> 'required|min:1',
            'vrItem'=> 'required|min:0.01',
            'pct_desconto'=> 'max:100',
        ], [
            'servico_id.required' => 'O campo "Serviço" é obrigatório.',
            'servico_id.min' => 'O "Serviço" deve conter pelo menos :min caracteres.',
            'qtd.required' => 'O campo "Quantidade" é obrigatório.',
            'qtd.min' => 'O "Quantidade" deve conter pelo menos :min caracteres.',            
            'vrItem.required' => 'O campo "Valor" é obrigatório.',
            'vrItem.min' => 'O "Valor" deve conter pelo menos :min caracteres.',
            'pct_desconto.max' => 'O campo "Desconto" permite até :max %.',
        ]);
        
        if($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach($errors->all() as $mensagem){
                $msg .= $mensagem.'<br/>';
            }
            
            throw new OrdemServicoException($msg);
        }

        return true;
    }
}
