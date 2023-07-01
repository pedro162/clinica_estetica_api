<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Exceptions\OrdemServicoCobrancaException;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\OrdemServicoCobranca;
use \App\OrdemServico;
use \App\Filial;
use \App\Pessoa;
use \App\Utilitarios;
use \App\FormaPagamento;

class OrdemServicoCobrancaController extends Controller
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
            //dd('aqui');

            set_time_limit(9000000);

            \DB::beginTransaction();

            $this->validaRequest($request);

            $dados = $request->all();

            $ordemServico = OrdemServico::where('active', '=' ,'yes')->where('id', '=', $dados['ordem_servico_id'])->first();
            if(! $ordemServico){
                throw new OrdemServicoCobrancaException('Ordem de serviço não identificada. Tente novamente ou entre em contato com o suporte.');
            }

            $filial = Filial::where('id', '=', $ordemServico->filial->id)->where('active', '=', 'yes')->first();
            if(! $filial){
                throw new OrdemServicoCobrancaException('Filial não identificada');
            }

            $formaPagamento = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $dados['forma_pagamento_id'])->first();
            if(! $formaPagamento){
                throw new OrdemServicoCobrancaException('Forma de pagamento não identificada');
            }

            $operadorFinanceiro = $formaPagamento->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')->where('operador_financeiros.id', '=', $dados['operador_financeiro_id'])->first();

            $planoPagamento = $formaPagamento->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')->where('plano_pagamentos.id', '=', $dados['plano_pagamento_id'])->first();
            if(! $planoPagamento){
                throw new OrdemServicoCobrancaException('Plano de pagamento não identificada');
            }

            if($formaPagamento->hasOperadorFinanceiro == 'yes'){
                if(! $operadorFinanceiro){
                    throw new OrdemServicoCobrancaException('Operador financeiro não identificado');
                }
            }
            
            /*
                'ordem_servico_id',
                'forma_pagamento_id',
                'operador_financeiro_id',
                'plano_pagamento_id',
                'filial_id',
                'nr_doc',
                'vencimento_manual',
                'dt_vencimento_manual',
                'vr_cobranca',
                'vr_acrescimo',
                'vr_final',
                'user_id',
                'user_update_id',
                'active',
            */
            $dadosRequest = [];
            $dadosRequest['ordem_servico_id']           = $ordemServico->id;
            $dadosRequest['forma_pagamento_id']         = $formaPagamento->id;
            $dadosRequest['operador_financeiro_id']     = $operadorFinanceiro ? $operadorFinanceiro->id : null;
            $dadosRequest['plano_pagamento_id']         = $planoPagamento->id;
            $dadosRequest['filial_id']                  = $filial->id;
            $dadosRequest['nr_doc']                     = $dados['nr_doc']                      ?? null;
            $dadosRequest['vencimento_manual']          = $dados['vencimento_manual']           ?? 'no';
            $dadosRequest['dt_vencimento_manual']       = $dados['dt_vencimento_manual']        ?? null;
            $dadosRequest['vr_cobranca']                = Utilitarios::removeMaskMoney($dados['vr_cobranca']   ?? 0);
            $dadosRequest['vr_acrescimo']               = Utilitarios::removeMaskMoney($dados['vr_acrescimo']  ?? 0);
            $dadosRequest['vr_final']                   = $dadosRequest['vr_cobranca'] + $dadosRequest['vr_acrescimo'];
            $dadosRequest['user_id']                    = \Auth::User()->id;//trocar pelo id do usuario logado
            $dadosRequest['active']                     = 'yes';
            
            $form = OrdemServicoCobranca::create($dadosRequest);

            \DB::commit();
            
            if(! $form){
                throw new OrdemServicoCobrancaException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte.');
            }

            return response()->json(['mensagem'=>$form, 'class'=>'success'], 200);

        }catch(OrdemServicoCobrancaException $e){
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
                throw new OrdemServicoCobrancaException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = OrdemServicoCobranca::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();
            $registro->pessoa;
            //$dataItens = [];
            /* if( $registro->item){
                foreach( $registro->item as $key=>$item){
                    $dataItens[] = $item->servico;
                }
            }
            $registro->item = $dataItens; */
            //$registro->item;
            
            




            if($registro == null){
                throw new OrdemServicoCobrancaException(' não encontrado');
            }
           
            \DB::commit();

            return response()->json(['mensagem'=>$registro, 'class'=>'success'], 200);

        }catch(OrdemServicoCobrancaException $e){
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

            $registro = OrdemServicoCobranca::where('active', '=', 'yes')->where('id', '=', $id)->first();

            $dadosRequest = [];
            $dadosRequest['nr_doc']                 = $dados['nr_doc'] ?? null;
            $dadosRequest['user_update_id']         = \Auth::User()->id;
            $registro->update($dadosRequest);


            if(! $registro){
                throw new OrdemServicoCobrancaException('Registro não encontrado');
            }
            
            
            \DB::commit();
            return response()->json(['mensagem'=>$registro, 'class'=>'success'], 200);
        
        }catch(OrdemServicoCobrancaException $e){
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
    public function destroy($id)
    {
        try{

            \DB::beginTransaction();

            if($id <= 0){
                 return response()->json([['mensagem'=>'Parâmetro inválido', 'class'=>'warning'], 400]);

            }

            $registro = OrdemServicoCobranca::where('active', '=', 'yes')
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
        
        }catch(OrdemServicoCobrancaException $e){
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

            $registro = \DB::table('operador_financeiros as opf')->join('pessoas as p', function($join){
                
                $join->on('opf.pessoa_id', '=', 'p.id');

            })->leftJoin('oper_forma_pgto as opfpgto', function($join){
                
                $join->on('opf.id', '=', 'opfpgto.oper_pagamentos_id');

            })->leftJoin('forma_pagamentos as fpto', function($join){
                
                $join->on('opfpgto.forma_pagamentos_id', '=', 'fpto.id');

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
                                
                                $registro->whereIn('plgt.id', $val);
                            }
                            break;
                        case 'forma_pagamentos_id':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                $val = explode(',', $val);
                                
                                $registro->whereIn('fpto.id', $val);
                            }
                            break;
                        case 'nome_operador':
                            if(is_string($val)){
                                
                                if($val[0] == ','){
                                    $val = substr($val, 1);
                                } 
                                if($val[strlen($val) - 1] == ','){
                                    $val = substr($val, 0, -1);
                                }
                                
                                $registro->where('p.name', 'like' , '%'.$val.'%');
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
                $registro->select('opf.*', 'p.name');

            }
            //$registro = \App\::where('active', '=', 'yes')->get();
            $registro = $registro->where('opf.active', '=', 'yes')->get();


            \DB::commit();

            if(isset($consulta['to_require']) && $consulta['to_require'] == true){
                $dataToRequest = [];
                foreach($registro as $reg){
                    $dataToRequest[] = ['label'=>$reg->name, 'value'=>$reg->id];
                }

                $registro = $dataToRequest;
            }
            

            return response()->json(['mensagem'=>$registro, 'class'=>'success'], 201);

        }catch(OrdemServicoCobrancaException $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
    
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }


    /*
        'ordem_servico_id',
                'forma_pagamento_id',
                'operador_financeiro_id',
                'plano_pagamento_id',
                'filial_id',
                'nr_doc',
                'vencimento_manual',
                'dt_vencimento_manual',
                'vr_cobranca',
                'vr_acrescimo',
                'vr_final',
    */
    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'ordem_servico_id'=> 'required|min:1',
            'forma_pagamento_id'=> 'required|min:1',
            'plano_pagamento_id'=> 'required|min:1',
            'vr_cobranca'=> 'required|min:0.01',
        ], [
            'ordem_servico_id.required' => 'Informe uma ordem de serviço válida.',
            'ordem_servico_id.min' => 'O código da ordem de serviço devere ser maior ou igual a :min.',
            'forma_pagamento_id.required' => 'Informe uma forma de pagamento válida.',
            'forma_pagamento_id.min' => 'O código da forma de pagamento deve ser maior ou igual a :min.',
            'plano_pagamento_id.required' => 'Informe um plano de pagamento válido.',
            'plano_pagamento_id.min' => 'O código od plano de pagamento deve ser maior ou igual a :min.',
            'vr_cobranca.required' => 'Informe um valor de cobrança válido.',
            'vr_cobranca.min' => 'O valor da cobrança deve ser maior ou igual a :min.',
        ]);
        
        if($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach($errors->all() as $mensagem){
                $msg .= $mensagem.'<br/>';
            }
            
            throw new OrdemServicoCobrancaException($msg);
        }

        return true;
    }
}
