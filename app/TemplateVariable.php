<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateVariable extends Model
{
    use SoftDeletes;
    protected $primaryKey    = 'id';
    protected $table         = 'template_variables';
    protected $fillable     = [
        'syntax',
        'value',
        'template_id',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];
}
