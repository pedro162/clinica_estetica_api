<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class Convenio extends Model
{
    use SoftDeletes, BelongsToTenant;
    protected $table = "convenios";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];
}
