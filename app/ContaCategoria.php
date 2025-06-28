<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContaCategoria extends Model
{
    use SoftDeletes, BelongsToTenant;
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
