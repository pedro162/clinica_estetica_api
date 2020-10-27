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
}
