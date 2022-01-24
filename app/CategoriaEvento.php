<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EventoAgenda;

class CategoriaEvento extends Model
{
    protected $table="categoria_eventos";
    protected $primaryKey="id";
    protected $fillable =[
        'name',
        'categ_event_pai_id',
        'user_id',
        'user_update_id',
        'active',
    ];

    public function eventoAgenda()
    {
    	return $this->hasMany(EventoAgenda::class, 'categoria_evento_id', 'id');
    }
}
