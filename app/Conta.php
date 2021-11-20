<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ContaCategoria;

class Conta extends Model
{
    protected $table = "contas";
    protected $primaryKey="id";
    protected $fillable = [
        'id',
        'name',
        'pessoa_id',
        'conta_categorias_id',
        'typo',
        'user_id',
        'user_update_id',
        'active'
    ];

    public function categoria()
    {
        return $this->belongsTo(ContaCategoria::class, 'conta_categorias_id', 'id');
    }

}
