<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ContaReceberItem;
use App\ContaReceber;
use App\Pessoa;

class ContaReceberCartao extends Model
{
    protected $primaryKey = "id";

    protected $table = "conta_receber_cartaos";

    protected $fillable = [
    	'nr_doc',
        'dt_emissao',
        'dt_vencimento',
        'dt_baixa',
        'bandeira_name',
        'vr_bruto',
        'vr_liquido',
        'vr_taxa',
        'pct_taxa',
        'vr_outrasTaxas',
        'status',
        'conta_receber_id',
        'cont_receb_item_id',
        'bandeira_cartao_id',
        'user_id',
        'user_update_id',
        'active',
    ];
}
