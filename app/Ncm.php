<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ncm extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    use SoftDeletes;

    protected $table = 'ncms';
    protected $primaryKey = 'id';

    protected $fillable = [
        'codNcm',
        'nmNcm',
        'excecaoNcm',
        'tpCodigo',
        'exTipi',
        'nmTabela',
        'vrAliqNacional',
        'vrAliqImportada',
        'vrAliqEstadual',
        'vrAliqMunicipal',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];

    public function produto()
    {
        return $this->hasMany(Produto::class, 'produto_id', 'id');
    }
}
