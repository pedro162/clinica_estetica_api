<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;
    use BelongsToTenant;
    protected $primaryKey    = 'id';
    protected $table         = 'notifications';
    protected $fillable     = [
        'title',
        'message',
        'origin_contact_address',
        'target_contact_address',
        'target_contact_name',
        'template_id',
        'tenant_id',
        'shipping_state',
        'sent_date',
        'user_id',
        'user_update_id',
        'active',
        'type',
        'filial_id',
    ];
}
