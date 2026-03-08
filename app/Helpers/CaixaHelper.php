<?php

namespace App\Helpers;

use App\Caixa;
use App\Exceptions\CobrancaReceberException;

class CaixaHelper extends BaseHelper
{
    public function atualizar(array $dados, int $id)
    {

        $id             = $id ?? $dados['id'];
        $callBack       = $dados['callBack'] ?? '';
        $caixa_id       = $dados['caixa_id'] ?? 0;

        if ($id <= 0) {
            throw new CobrancaReceberException('Parâmetro ínválido');
        }

        if (! ($caixa_id > 0)) {
            throw new CobrancaReceberException('Parâmetro ínválido para o caixa de baixa');
        }

        $registro = Caixa::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if (! $registro) {
            throw new CobrancaReceberException('Registro não identificao. Tente novamente ou entre em contato com o suporte.');
        }
    }

    public function getSaldoCaixa(int $id)
    {

        if (! (isset($id) && $id > 0)) {
            throw new CobrancaReceberException('Parâmetro ínválido');
        }

        $registro = Caixa::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if (! $registro) {
            throw new CobrancaReceberException('Registro não identificao. Tente novamente ou entre em contato com o suporte.');
        }

        return $registro->vrSaldo;
    }

    public function getCaixa(int $id)
    {
        $registro = Caixa::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        return $registro;
    }

    public function json(array $consulta)
    {

        if (!isset($consulta['ordem'])) {
            $consulta['ordem'] =  'id-desc';
        }
        $ordem      = $consulta['ordem'] ?? 'id-desc';

        $campos =  null;
        $parse = [
            'caixa_name' => 'caixas.name',
            'name_caixa' => 'caixas.name'

        ];

        $registro = \DB::table('caixas');
        if (is_array($consulta) && count($consulta) > 0) {
            foreach ($consulta as $key => $val) {

                switch (trim($key)) {
                    case 'id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('caixas.id', $val);
                        }
                        break;
                    case 'name':
                    case 'caixa_name':
                    case 'name_caixa':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('caixas.name', 'like', '%' . $val . '%');
                        }
                        break;
                    case 'caixa_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('caixas.id', '=', '' . $val . '');
                        }
                        break;
                    case 'limite':
                        $val = (int) $val;
                        if (is_integer($val) && $val > 0) {

                            $registro->limit($val);
                        }
                        break;
                    case 'ordem':


                        if ($val[0] == ',') {
                            $val = substr($val, 1);
                        }
                        if ($val[strlen($val) - 1] == ',') {
                            $val = substr($val, 0, -1);
                        }

                        $val = explode(',', $val);
                        for ($i = 0; !($i == count($val)); $i++) {
                            $atual = explode('-', $val[$i]);
                            if (array_key_exists(trim($atual[0]), $parse)) {

                                $parsed = $parse[trim($atual[0])];

                                if ($parsed) {

                                    $registro->orderBy($parsed, $atual[1]);
                                }
                            }
                        }

                        break;

                    case 'campos':
                        if (is_array($val) && count($val) > 0) {
                            //$campos = $this->montaCamposConsulta($registro, $val);

                        }
                        break;
                }
            }
        }
        if ($campos) {
            $registro->select($campos);
        } else {
            $registro->select('caixas.*');
        }

        //----
        $ordemArr   = explode('-', $ordem);
        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $usePaginate = $consulta['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::PAGINACAO_ITENS_POR_PAGINA_PADRAO;
        if ($usePaginate > 0) {
            $registro   = $registro->where('caixas.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->where('caixas.active', '=', 'yes')->get();
        }

        if (isset($consulta['to_require']) && $consulta['to_require'] == true) {
            $dataToRequest = [];
            foreach ($registro as $reg) {
                $dataToRequest[] = ['label' => $reg->name, 'value' => $reg->id];
            }

            $registro = $dataToRequest;
        }

        return  $registro;
    }
}
