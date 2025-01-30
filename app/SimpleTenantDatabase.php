<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimpleTenantDatabase extends Model
{
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
