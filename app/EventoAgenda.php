<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventoAgenda extends Model
{
    use SoftDeletes, BelongsToTenant;
    protected $table = "evento_agendas";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'name',
        'profissional_id',
        'profissional_id',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];
}
