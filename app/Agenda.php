<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use SoftDeletes, BelongsToTenant;
    protected $table = "agendas";
    protected $primaryKey = 'id';
    protected $fillable = [
        'descricao',
        'data',
        'hora',
        'referencia_id',
        'referencia',
        'status',
        'dt_cancelamento',
        'pessoa_id',
        'pess_cancel_id',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];
}
