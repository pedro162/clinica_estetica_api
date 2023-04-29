<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EventoAgenda;
use App\Pessoa;
use App\Profissional;
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
        'profissional_id',
        'prioridade',
        'status',
        'dt_fim',
        'hr_fim',
        'name_atendido',
        'tipo',
        'dt_inicio',
        'hr_inicio',
        'filial_id',
        'dt_cancelamento',
        'ds_cancelamento',
        'pess_cancel_id',
        'vr_atendimento',
        'vr_desconto',
        'vr_acrescimo',
    ];
    
    //'convenio_id'
    
    public function eventoAgenda()
    {
    	return $this->belongsTo(EventoAgenda::class, 'evento_agenda_id', 'id');
    }

    public function pessoa()
    {
    	return $this->belongsTo(Pessoa::class, 'pessoa_id', 'id');
    }

    public function profissional()
    {
    	return $this->belongsTo(Profissional::class, 'profissional_id', 'id');
    }

}
