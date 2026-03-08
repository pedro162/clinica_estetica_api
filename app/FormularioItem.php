<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormularioItem extends Model
{
    use SoftDeletes;
    use BelongsToTenant;
    protected $table = 'formulario_items';
    protected $primaryKey = 'id';
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
