<?php

namespace App;

class Utilitarios
{
    public static function loadEnderecoApi($cep)
    {
        $cep = preg_replace('/[^0-9]/', '', trim($cep));
        if (strlen($cep) == 0) {
            return false;
        }

        $url = str_replace('{cep}', $cep, 'http://viacep.com.br/ws/{cep}/xml');

        $xml = simplexml_load_file($url);
        return json_encode($xml);
    }

    public static function validaCpf(String $cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        $digitoUm = 0;
        $digitoDois = 0;

        for ($i = 0, $x = 1; !($i == 9); $i++, $x++) {
            $digitoUm += $cpf[$i] * $x;
        }

        for ($i = 0, $x = 0; !($i == 10); $i++, $x++) {
            if (str_repeat($i, 11) == $cpf) {
                return false;
            }

            $digitoDois += $cpf[$i] * $x;
        }

        $calculoUm = (($digitoUm % 11)  == 10) ? 0 : ($digitoUm % 11);
        $calculoDois = (($digitoDois % 11) == 10) ? 0 : ($digitoDois % 11);

        if (($calculoUm != $cpf[9]) || ($calculoDois != $cpf[10])) {

            return false;
        }


        return true;
    }

    public static function getFormTable(array $dados): array
    {
        if (count($dados) == 0) {
            return [];
        }
        $index      = 0;
        $escuta     = true;
        $supArr     = [];
        while (!($escuta  == false)) {

            $subArr     = [];
            foreach ($dados as $key => $val) {
                $subArr[$key] = $val[$index];
                if (!array_key_exists($index + 1, $val)) {
                    $escuta = false;
                }
            }
            $supArr[] = $subArr;
            $index++;
        }

        return $supArr;
    }

    public static function removeMaskMoney($valor)
    {
        if (!(strlen(trim($valor)) > 0)) {
            return false;
        }

        if (strpos($valor, ',') > -1) {
            return (float) str_replace(['.', ','], ['', '.'], $valor);
        } else {
            return (float) $valor;
        }
    }


    public static function difDate($dtInicio, $dtFim, $tipoRetorno = 'd')
    {
        $dtInit = new \DateTime($dtInicio);
        $dtEnd  = new \DateTime($dtFim);

        $intervalo = $dtInit->diff($dtEnd);

        return $intervalo->format('%d');
    }

    public static function validaData($data, $formatoAmericano = true)
    {
        if (strlen(trim($data)) == 0) {
            return false;
        }
        $delimitador = '-';
        if (strpos($data, '/') > -1) {
            $delimitador = '/';
        }

        $dtExplode = explode($delimitador, $data);
        if (
            !(is_array($dtExplode) && (count($dtExplode) > 0))
        ) {
            return false;
        }

        if ($formatoAmericano) {
            if ((count($dtExplode) == 3) && checkdate($dtExplode[1], $dtExplode[2], $dtExplode[0])) {
                return true;
            }
        } else {
            if ((count($dtExplode) == 3)  && checkdate($dtExplode[1], $dtExplode[0], $dtExplode[2])) {
                return true;
            }
        }

        return false;
    }

    public static function montaCamposConsulta($obj, array $campos)
    {
        $dados = implode(',', $campos);
        return $dados;
    }
}
