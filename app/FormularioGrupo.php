<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormularioGrupo extends Model
{
    use SoftDeletes;
    use BelongsToTenant;
    protected $table = 'formulario_grupos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'nr_ordem',
        'props_grupo',
        'user_id',
        'user_update_id',
        'active',
        'formulario_id',
        'deleted_at',
        'created_at',
        'updated_at',
        'tenant_id'
    ];

    public function formulario()
    {
        return $this->belongsTo(Formulario::class, 'formulario_id', 'id');
    }

    public function item()
    {
        return $this->hasMany(FormularioItem::class, 'formulario_grupo_id', 'id');
    }
}
