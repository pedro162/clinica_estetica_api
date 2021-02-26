<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\FormaPagamento;

class FormaPagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function planoPagamentoJson(Request $request)
    {
       
        try{    

            \DB::beginTransaction();
                $dados = $request->all();
                $plano = FormaPagamento::where('active', '=', 'yes');
                if(isset($dados['forma_pagamentos_id']) && ($dados['forma_pagamentos_id'] > 0)){
                    $plano->where('id', '=', $dados['forma_pagamentos_id']);
                }
                $result = $plano->first()->planoPagamento;
                
                if(! $result){
                    throw new PlanoPagamentoException('Registro não encontrado');
                }

                return response()->json(['data'=>$result, 'class'=>'success'], 200);

            \DB::commit();

        }catch(PlanoPagamentoException $e){

            \DB::rollback();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        }catch(\Exception $e){

            \DB::rollback();
            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor: '.$e->getMessage(), 'class'=>'warning'], 500);
        }
     

    } 


    public function operadorJson(Request $request)
    {
       
        try{    

            \DB::beginTransaction();
                $dados = $request->all();
                $plano = FormaPagamento::where('active', '=', 'yes');
                if(isset($dados['forma_pagamentos_id']) && ($dados['forma_pagamentos_id'] > 0)){
                    $plano->where('id', '=', $dados['forma_pagamentos_id']);
                }
                $result = $plano->first()->operadorFinanceiro;
                                
                if(! $result){
                    throw new PlanoPagamentoException('Registro não encontrado');
                }

                for($i = 0; !($i == count($result)); $i++){
                    $pessoa = $result[$i]->pessoa;
                    //$result[$i]->pessoaData = $pessoa;
                }

                return response()->json(['data'=>$result, 'class'=>'success'], 200);

            \DB::commit();

        }catch(PlanoPagamentoException $e){

            \DB::rollback();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        }catch(\Exception $e){

            \DB::rollback();
            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor: '.$e->getMessage(), 'class'=>'warning'], 500);
        }
     

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
