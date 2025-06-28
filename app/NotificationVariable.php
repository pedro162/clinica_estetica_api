<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class NotificationVariable extends Model
{
    use SoftDeletes, BelongsToTenant;
    protected $primaryKey    = 'id';
    protected $table         = 'notification_variables';
    protected $fillable     = [
        'syntax',
        'value',
        'template_variable_id',
        'notification_id',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];
}
