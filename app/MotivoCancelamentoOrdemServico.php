<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MotivoCancelamentoOrdemServico extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

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
