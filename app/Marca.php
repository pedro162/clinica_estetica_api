<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marca extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $fillable = [
        'name',
        'user_id',
        'tenant_id'
    ];

    public function produto()
    {
        return $this->hasMany(Produto::class, 'marca_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
