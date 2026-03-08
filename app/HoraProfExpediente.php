<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HoraProfExpediente extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $table = 'hora_prof_expedientes';
    protected $primaryKey = 'id';
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
