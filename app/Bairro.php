<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bairro extends Model
{
    use SoftDeletes;
    use BelongsToTenant;
    protected $fillable = [
        'user_id',
        'user_update_id',
        'name',
        'codIbge',
        'cep',
        'cidade_id',
        'active',
        'tenant_id'
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cidade_id', 'id');
    }
}
