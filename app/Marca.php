<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class Marca extends Model
{
    use SoftDeletes, BelongsToTenant;

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
