<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Estado;
use App\Bairro;

class Cidade extends Model
{
    protected $table = "cidades";
    protected $primaryKey="id";
    protected $fillable = [
        'id',
        'nmCidade',
        'sigla',
        'cdCidade',
        'estado_id',
        'user_id',
        'user_update_id',
        'active'
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id', 'id');
    }

    public function bairro()
    {
        return $this->hasMany(Bairro::class, 'cidade_id', 'id');
    }
}
