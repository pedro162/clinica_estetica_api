<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Formulario;
use \App\Marca;
use \App\Categoria;
use \App\Exceptions\FormularioException;
use \App\FormularioGrupo;
use Illuminate\Support\Facades\Auth;
use App\Helpers\BaseHelper;

class FormularioHelper extends BaseHelper
{
    public function load($data)
    {

        $registro = \DB::table('formularios as form');

        $campos =  null;

        $parse = [
            'name' => 'form.name',
            'id' => 'form.id',

        ];

        $ordem = $data['ordem'] ?? 'id-desc';
        if (!(isset($data['ordem']) && strlen($data['ordem']) > 0)) {

            $ordem = $data['ordem'] = 'id-desc';
        }

        if(is_array($data) && count($data) > 0){
            foreach($data as $key=>$val){
                
                switch(trim($key)){
                    case 'id':
                        if(is_string($val)){
                            
                            if($val[0] == ','){
                                $val = substr($val, 1);
                            } 
                            if($val[strlen($val) - 1] == ','){
                                $val = substr($val, 0, -1);
                            }
                        }
                            
                        $val = explode(',', $val);
                        $registro->whereIn('form.id', $val);
                        
                        break;
                    case 'name':
                        if(is_string($val)){
                            
                            if($val[0] == ','){
                                $val = substr($val, 1);
                            } 
                            if($val[strlen($val) - 1] == ','){
                                $val = substr($val, 0, -1);
                            }
                            
                            $registro->where('form.name', 'like' , '%'.$val.'%');
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
            $registro->select('form.*');

        }

        
        $ordemArr   = explode('-', $ordem);
        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $usePaginate = $data['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($data['nr_itens_per_page']) && $data['nr_itens_per_page'] > 0 ? $data['nr_itens_per_page'] : self::PAGINACAO_ITENS_POR_PAGINA_PADRAO;
        if ($usePaginate > 0) {
            $registro   = $registro->where('form.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->where('form.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->get();
        }

        if (isset($data['to_require']) && $data['to_require'] == true) {
            $dataToRequest = [];
            foreach ($registro as $reg) {
                $dataToRequest[] = ['label' => $reg->name, 'value' => $reg->id];
            }

            $registro = $dataToRequest;
        }

        return $registro;
    }


    public function store($dados)
    {

        $sentinela = null;
        
        $dataGrupos = $dados['grupos'] ?? [];

        if(! (is_array($dataGrupos) && count($dataGrupos) > 0)){
            throw new FormularioException('País não identificado. Tente novamente ou entre em contato com o suporte.');
        }
        foreach($dataGrupos as $key=>$val){
            if(! (isset($val['name']) && strlen(trim($val['name'])) > 0) ){
                throw new FormularioException('Aguns itens dos grupos não possuem "Nome" definido');
            }

            if(! (isset($val['nr_ordem']) && $val['nr_ordem'] >= 0)){
                throw new FormularioException('Aguns itens deos grupos não possuem "Ordem" definida.');
            }
        }

        $dadosRequest = [];

        $dadosRequest['name']               = $dados['name'];
        $dadosRequest['user_id']            = \Auth::User()->id;//trocar pelo id do usuario logado
        $dadosRequest['active']             = 'yes';
        
        $form = Formulario::create($dadosRequest);

        foreach($dataGrupos as $key=>$val){

            $dadosRequest = [];            
            $dadosRequest['name']               = $val['name'];
            $dadosRequest['nr_ordem']           = $val['nr_ordem'];
            $dadosRequest['formulario_id']      = $form->id;
            $dadosRequest['props_grupo']        = $val['props_grupo'] ?? null;
            $dadosRequest['user_id']            = \Auth::User()->id;//trocar pelo id do usuario logado
            $dadosRequest['active']             = 'yes';
            
            $formGroup                          = FormularioGrupo::create($dadosRequest);
            if(! $formGroup){
                throw new FormularioException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte.');
            }
        
        }

        
        if(! $form){
            throw new FormularioException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte.');
        }


        return $form;
    }
}
