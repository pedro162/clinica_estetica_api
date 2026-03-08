<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiasProfExpediente extends Model
{
    use SoftDeletes;
    use BelongsToTenant;
    protected $table = 'dias_prof_expedientes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'nr_dia',
        'profissional_id',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id', 'id');
    }


    public function diasProfExpediente()
    {
        return $this->hasMany(HoraProfExpediente::class, 'dias_prof_expediente_id', 'id');
    }
}
