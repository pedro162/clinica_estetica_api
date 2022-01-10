<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventoAgenda extends Model
{
    protected $table="evento_agendas";
    protected $primaryKey="id";
    protected $fillable =[
        'name',
        'user_id',
        'user_update_id',
        'active',
    ];
}
