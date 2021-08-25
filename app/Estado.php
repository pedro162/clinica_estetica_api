<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pais;
use App\Icms;

class Estado extends Model
{
    protected $table="estadoss";
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
