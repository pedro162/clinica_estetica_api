<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Produto;

class Ncm extends Model
{

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

    use SoftDeletes;

    public function produto()
    {
        return $this->hasMany(Produto::class, 'produto_id', 'id');
    }
}
