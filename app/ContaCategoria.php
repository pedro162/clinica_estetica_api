<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContaCategoria extends Model
{
    protected $table = "conta_categorias";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'name',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];
}
