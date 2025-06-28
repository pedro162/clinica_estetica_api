<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pais;
use App\Icms;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    use SoftDeletes, BelongsToTenant;
    protected $table = "estadoss";
    protected $primaryKey = 'id';
    protected $fillable = [
        'nmEStado',
        'codEstado',
        'sigla',
        'padrao',
        'pais_id',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id', 'id');
    }

    public function icms()
    {
        return $this->hasOne(Icms::class, 'estados_id', 'id');
    }
}
