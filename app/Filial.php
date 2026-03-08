<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filial extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $table = 'filials';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pessoa_id',
        'dsAtividade',
        'dsTextoContrato',
        'nrExercicioImplantacaoContabil',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];

    public function pessoa()
    {
        //return $this->hasOne(Pessoa::class, 'id' , 'pessoa_id');
        return $this->belongsTo(Pessoa::class, 'pessoa_id', 'id');
    }
}
