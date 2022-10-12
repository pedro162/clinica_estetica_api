<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EventoAgenda;
use App\Pessoa;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atendimento extends Model
{
    use SoftDeletes;
    protected $table="atendimentos";
    protected $primaryKey="id";
    protected $fillable =[
        'name',
        'historico',
        'pessoa_id',
        'user_id',
        'user_update_id',
        'active',
        'dt_marcado',
        'hr_marcado',
        'profissional_id',
        'prioridade',
        'status'
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
