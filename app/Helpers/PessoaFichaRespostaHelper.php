<?php

namespace App\Helpers;

use App\Exceptions\PessoaFichaExcepton;
use App\FormularioItem;
use App\PessoaFormulario;
use App\PessoaFormularioResposta;

class PessoaFichaRespostaHelper
{
    public function create(PessoaFormulario $objPessaForm, int $idItem, array $data)
    {
        $formularioItem = FormularioItem::where('id', '=', $idItem)->where('active', '=', 'yes')->first();
        if (!$formularioItem) {
            throw new PessoaFichaExcepton('Item de formuláiro não identificado: ' . $idItem);
        }

        $dadosRequest = [];
        $dadosRequest['pess_form_id']       = $objPessaForm->id;
        $dadosRequest['form_item_id']       = $formularioItem->id;
        $dadosRequest['pergunta']           = $formularioItem->label            ?? null;
        $dadosRequest['resposta']           = $data['resposta']                 ?? null;
        $dadosRequest['observacao']         = $data['observacao']               ?? null;
        $dadosRequest['nr_linha']           = $formularioItem->nr_linha         ?? null;
        $dadosRequest['nr_coluna']          = $formularioItem->nr_coluna        ?? null;
        $dadosRequest['alerta_resposta']    = $formularioItem->alerta_resposta  ?? 'no';
        $dadosRequest['valor_alerta']       = $formularioItem->valor_alerta     ?? null;
        $dadosRequest['active']             = 'yes';
        $dadosRequest['td_faturamento']     = date('Y-m-d H:i:s');
        $dadosRequest['pess_fat_id']        = \Auth::User()->pessoa->id;
        $dadosRequest['user_update_id']     = \Auth::User()->id;
        $dadosRequest['user_id']            = \Auth::User()->id; //trocar pelo id do usuario logado

        $ordemServico = new PessoaFormularioResposta();
        $ordemServico->create($dadosRequest);

        return $ordemServico;
        //
    }

    public function atualizar(PessoaFormularioResposta $ordemServico, $data)
    {

        $dadosRequest = [];
        $dadosRequest['is_faturado']        = 'yes';
        $dadosRequest['type']               = 'pedido';
        $dadosRequest['td_faturamento']     = date('Y-m-d H:i:s');
        $dadosRequest['pess_fat_id']        = \Auth::User()->pessoa->id;
        $dadosRequest['user_update_id']     = \Auth::User()->id;
        $ordemServico->create($dadosRequest);

        return $ordemServico;
        //
    }
}
