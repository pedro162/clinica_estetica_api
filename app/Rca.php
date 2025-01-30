<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pessoa;
use App\Filial;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rca extends Model
{
    use SoftDeletes;

    protected $table = 'rcas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'filial_id',
        'pessoa_id',
        'acessaTodosRcas',
        'situacao',
        'metaPositivacao',
        'metaMargem',
        'metaFaturamento',
        'active',
        'user_id',
        'user_update_id',
        'tenant_id'
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id', 'id');
    }

    public function filial()
    {
        return $this->belongsTo(Filial::class, 'filial_id', 'id');
    }
}
