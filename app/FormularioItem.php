<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FormularioGrupo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormularioItem extends Model
{
    use SoftDeletes;
    protected $table = "formulario_items";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'name',
        'type',
        'options',
        'default_value',
        'props',
        'label',
        'props_label',
        'nr_linha',
        'nr_coluna',
        'formulario_grupo_id',
        'formulario_id',
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
        return $this->belongsTo(FormularioGrupo::class, 'formulario_grupo_id', 'id');
    }
}
