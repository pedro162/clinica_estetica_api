<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Servico;
use \App\OrdemServico;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicoItem extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $table = "servico_items";
    protected $primaryKey = "id";
    protected $fillable = [
        'qtd',
        'servico_id',
        'vrItemBruto',
        'vrTotal',
        'vrItem',
        'user_id',
        'user_update_id',
        'active',
        'ordem_servico_id',
        'vr_final',
        'vr_desconto',
        'pct_acrescimo',
        'vr_acrescimo',
        'pct_desconto',
        'tenant_id'
    ];

    public function ordem()
    {
        return $this->belongsTo(OrdemServico::class, 'ordem_servico_id', 'id');
    }
    public function servico()
    {
        return $this->belongsTo(Servico::class, 'servico_id', 'id');
    }
}
