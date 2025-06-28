<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SimpleTenantDatabase extends Model
{
    use SoftDeletes;

    protected $table = "simple_tenant_databases";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'contact_number',
        'contact_email',
        'document',
        'max_users',
        'account_status',
        'active',
    ];
}
