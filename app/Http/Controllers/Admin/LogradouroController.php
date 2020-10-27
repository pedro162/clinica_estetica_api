<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Utilitarios;

class LogradouroController extends Controller
{
    public function loadLogradouroApi(Request $request)
    {	
    	try {   		
    		
	    	$dados = $request->only('cep');
	    	if($dados){

	    		$logradouro = Utilitarios::loadEnderecoApi($dados['cep']); 
	    		if($logradouro == false){
	    			
	    			return response()->json(['mensagem'=>'Cep inválido', 'class'=>'success'], 400);
	    		}  		
	    		return response()->json(['mensagem'=>$logradouro, 'class'=>'success'], 200);    		
	    	}

	    	return response()->json(['mensagem'=>'Cep inválido', 'class'=>'success'], 400);

    	} catch (\Exception $e) {
    		return response()->json(['mensagem'=>$e->getMessage(), 'class'=>'warning'], 500);
    	}
    	
    }
}
