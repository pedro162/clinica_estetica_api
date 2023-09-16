<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EventoAgenda;
use App\Pessoa;
use App\Profissional;
use Illuminate\Database\Eloquent\SoftDeletes;

class PessoaFormularioResposta extends Model
{
    use SoftDeletes;
    protected $table = "pessoa_formulario_respostas";
    protected $primaryKey = "id";
    protected $fillable = [
        'pess_form_id',
        'pergunta',
        'resposta',
        'observacao',
        'nr_linha',
        'nr_coluna',
        'alerta_resposta',
        'user_id',
        'user_update_id',
        'active',
    ];
}
