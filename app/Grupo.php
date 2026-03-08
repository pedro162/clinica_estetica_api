<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grupo extends Model
{
    use SoftDeletes;
    use BelongsToTenant;
    protected $fillable =
        [
            'name',
            'descricao',
            'user_id',
            'user_update_id',
            'active',
            'tenant_id'
        ];
}
