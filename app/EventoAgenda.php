<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Profissional;
use App\CategoriaEvento;

class EventoAgenda extends Model
{
    protected $table="evento_agendas";
    protected $primaryKey="id";
    protected $fillable =[
        'name',
        'user_id',
        'user_update_id',
        'descricao',
		'periodo',
		'dt_inicio',
		'dt_fim',
		'hr_inicio',
		'hr_fim',
		'profissional_id',
		'categoria_evento_id',
		'recorrente',
		'nivel',
        'active',
    ];

    public function profissional()
    {
    	return $this->belongsTo(Profissional::class, 'profissional_id', 'id');
    }

    public function categoriaEvento()
    {
    	return $this->belongsTo(CategoriaEvento::class, 'categoria_evento_id', 'id');
    }
}
