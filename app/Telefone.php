<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telefone extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $fillable =
        [
            'numero',
            'tipo',
            'whatsapp',
            'pessoa_id',
            'user_id',
            'user_update_id',
            'importancia',
            'active',
            'tenant_id'
        ];


    public function pessoa()
    {
        return $this->hasMany(Pessoa::class, 'pessoa_id');
    }
}
