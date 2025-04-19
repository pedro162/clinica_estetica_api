<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DiasProfExpediente;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class HoraProfExpediente extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $table = "hora_prof_expedientes";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'hora',
        'dias_prof_expediente_id',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];

    public function diasProfExpediente()
    {
        return $this->belongsTo(DiasProfExpediente::class, 'dias_prof_expediente_id', 'id');
    }
}
