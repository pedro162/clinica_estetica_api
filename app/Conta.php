<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ContaCategoria;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conta extends Model
{
    use SoftDeletes, BelongsToTenant;
    protected $table = "contas";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'name',
        'pessoa_id',
        'conta_categorias_id',
        'typo',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(ContaCategoria::class, 'conta_categorias_id', 'id');
    }
}
