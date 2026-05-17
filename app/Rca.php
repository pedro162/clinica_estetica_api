<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rca extends Model
{
    use SoftDeletes;
    use BelongsToTenant;
    use HasFactory;

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
