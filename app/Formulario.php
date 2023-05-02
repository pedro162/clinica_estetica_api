<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\FormularioGrupo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formulario extends Model
{
    use SoftDeletes;
    protected $table="formularios";
    protected $primaryKey="id";
    protected $fillable = [
        'id',
        'name',
        'user_id',
        'user_update_id',
        'active',
        'deleted_at',
        'created_at',
        'updated_at'
        
    ];

    public function grupo(){
        return $this->hasMany(FormularioGrupo::class, 'formulario_id', 'id')->where('formulario_grupos.active', '=', 'yes');;
    }
}
