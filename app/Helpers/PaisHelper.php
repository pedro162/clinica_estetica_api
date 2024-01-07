<?php

namespace App\Helpers;

use \App\Utilitarios;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pais;
use App\Exceptions\PaisException;

class PaisHelper{

    public function info($dados, $id)
    {
        
        $id = $id ?? $dados['id'];
        $callBack = $dados['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if($id <= 0){
            throw new PaisException('Parâmetro ínválido');
        }

       

        $registro = Pais::where('active', '=', 'yes')
        ->where('id', '=', $id)->first();

        if($registro == null){
            throw new PaisException('Registro não encontrado');
        }

        return $registro;
    }



    public function store($dados)
    {
    	$dadosRequest = [];
 
        $dadosRequest['user_id']            = \Auth::User()->id;
        $dadosRequest['user_update_id']     = \Auth::User()->id;
        $dadosRequest['nmPais']             = $dados['nmPais'];
        $dadosRequest['cdPais']             = $dados['cdPais'];
        $dadosRequest['padrao']             = $dados['padrao'];
        $dadosRequest['active']             = 'yes';
         
        $registro = Pais::create($dadosRequest);

        if(! $registro){
            throw new PaisException('Erro ao cadastrar');
        }

        return $registro;
        
    }


    public function json($consulta)
    {
        
        $campos =  null;
        $parse = [
            'name_Pais'=>'pais.dsIpi',
            'nmPais'=>'pais.nmPais',
            'name'=>'pais.nmPais',
            'id'=>'pais.id',

        ];

        $ordem = $consulta['ordem'] ?? 'id-desc';
        if(!(isset($consulta['ordem']) && strlen($consulta['ordem']) > 0)){

        	$ordem = $consulta['ordem'] = 'id-desc';
        }

        $registro = \DB::table('pais');
        
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
                            
                            $registro->whereIn('pais.id', $val);
                        }
                        break;
                    case 'tipo':
                        if(is_string($val)){
                                
                            if($val[0] == ','){
                                $val = substr($val, 1);
                            } 
                            if($val[strlen($val) - 1] == ','){
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);
                                
                            $registro->whereIn('pais.tpCalculo', $val);
                        }
                    break;
                    case 'nmPais':
                    case 'name':
                        if(is_string($val)){
                            
                            if($val[0] == ','){
                                $val = substr($val, 1);
                            } 
                            if($val[strlen($val) - 1] == ','){
                                $val = substr($val, 0, -1);
                            }
                            
                            $registro->where('pais.nmPais', 'like' , '%'.$val.'%');
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
            $registro->select('pais.*');

        }
       
        $registro = $registro->where('pais.active', '=', 'yes')->get();

        return $registro;
    }

}
