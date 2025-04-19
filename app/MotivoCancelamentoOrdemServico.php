<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\OrdemServico;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class MotivoCancelamentoOrdemServico extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $table = 'motivo_cancelamento_ordem_servicos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'motivo',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];

    public function ordemServico()
    {
        return $this->hasMany(OrdemServico::class, 'mt_calcel_id', 'id');
    }
}
