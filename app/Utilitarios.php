<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Utilitarios extends Model
{
    public static function loadEnderecoApi($cep)
    {	
    	$cep = preg_replace("/[^0-9]/", '', trim($cep));
    	if(strlen($cep) == 0){
    		return false;
    	}

    	$url = str_replace('{cep}',$cep, 'http://viacep.com.br/ws/{cep}/xml');

    	$xml = simplexml_load_file($url);
		return json_encode($xml);
    }

    public static function validaCpf(String $cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if(strlen($cpf) != 11){
            return false;
        }

        $digitoUm = 0;
        $digitoDois = 0;

        for ($i=0, $x=1; !($i == 9 ); $i++, $x ++) { 
            $digitoUm += $cpf[$i] * $x;
        }

        for ($i=0, $x=0; !($i == 10 ); $i++, $x ++) { 
            if(str_repeat($i, 11) == $cpf){
                return false;
            }

            $digitoDois += $cpf[$i] * $x;
        }

        $calculoUm = (($digitoUm % 11)  == 10) ? 0 : ($digitoUm % 11);
        $calculoDois = (($digitoDois % 11) == 10) ? 0 : ($digitoDois % 11);

        if(($calculoUm != $cpf[9]) || ($calculoDois != $cpf[10])){

            return false;
        }

        
        return true;

    }
}
