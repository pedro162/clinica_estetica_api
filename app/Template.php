<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $primaryKey    = 'id';
    protected $table         = 'templates';
    protected $fillable     = [
        'body',
        'language',
        'title',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];
}
