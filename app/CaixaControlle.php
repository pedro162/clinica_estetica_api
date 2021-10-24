<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaixaControlle extends Model
{
    protected $table = "caixa_controlles";
    protected $primaryKey="id";
    protected $fillable = [
        'id',
        'dtAbertura',
        'dtFechamento',
        'dtBloqueio',
        'dtDesbloqueio',
        'pessoa_id',
        'pessoa_close_id',
        'pessoa_bloqueio_id',
        'pessoa_desbloqueio_id',
        'caixa_id',
        'user_id',
        'user_update_id',
        'active'
    ];
}
