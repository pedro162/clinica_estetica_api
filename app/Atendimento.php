<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EventoAgenda;
use App\Pessoa;

class Atendimento extends Model
{
    protected $table="atendimentos";
    protected $primaryKey="id";
    protected $fillable =[
        'name',
        'historico',
        'pessoa_id',
        'evento_agenda_id',
        'user_id',
        'user_update_id',
        'active',
    ];

    public function eventoAgenda()
    {
    	return $this->belongsTo(EventoAgenda::class, 'evento_agenda_id', 'id');
    }

    public function pessoa()
    {
    	return $this->belongsTo(Pessoa::class, 'pessoa_id', 'id');
    }

}
