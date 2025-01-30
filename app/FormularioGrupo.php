<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Formulario;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormularioGrupo extends Model
{
    use SoftDeletes;
    protected $table = "formulario_grupos";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "name",
        "nr_ordem",
        "props_grupo",
        "user_id",
        "user_update_id",
        "active",
        'formulario_id',
        "deleted_at",
        "created_at",
        "updated_at",
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
