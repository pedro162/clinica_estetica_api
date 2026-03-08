<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Http extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $table = 'https';
    protected $primaryKey = 'id';
    protected $fillable = [
        'http_code',
        'http_body',
        'http_header',
        'http_url',
        'user_id',
        'user_update_id',
        'active',
        'deleted_at',
        'created_at',
        'updated_at',
        'simple_tenant_database_id',
        'tenant_id'
    ];
}
