<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formulario extends Model
{
    use SoftDeletes;
    use BelongsToTenant;
    protected $table = 'formularios';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'user_id',
        'user_update_id',
        'active',
        'deleted_at',
        'created_at',
        'updated_at',
        'tenant_id'
    ];

    public function grupo()
    {
        return $this->hasMany(FormularioGrupo::class, 'formulario_id', 'id')->where('formulario_grupos.active', '=', 'yes');
        ;
    }
}
