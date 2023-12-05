<?php

namespace App\Helpers;

use \App\Pessoa;
use \App\Grupo;
use \App\Telefone;
use \App\Logradouro;
use \App\Utilitarios;
use App\Exceptions\PessoaException;
use App\Exceptions\GrupoException;
use Illuminate\Support\Facades\Validator;

class GrupoHelper
{
   public function json(array $dados){
        $consulta = $dados;
        $campos =  null;
        $parse = [
            'grupo_name'=>'grupos.name'

        ];

        $registro = \DB::table('grupos');
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
                            
                            $registro->whereIn('grupos.id', $val);
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
                            
                            $registro->where('grupos.name', 'like' , '%'.$val.'%');
                        }
                        break;
                    case 'grupo_id':
                        if(is_string($val)){
                            
                            if($val[0] == ','){
                                $val = substr($val, 1);
                            } 
                            if($val[strlen($val) - 1] == ','){
                                $val = substr($val, 0, -1);
                            }
                            
                            $registro->where('grupos.id', '=' , ''.$val.'');
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
            $registro->select('grupos.*');

        }
       
        $registro = $registro->where('grupos.active', '=', 'yes')->get();

		return $registro;            
     }
}
