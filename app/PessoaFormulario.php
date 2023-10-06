<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EventoAgenda;
use App\Pessoa;
use App\Profissional;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\PessoaFormularioResposta;

class PessoaFormulario extends Model
{
    use SoftDeletes;
    protected $table = "pessoa_formularios";
    protected $primaryKey = "id";
    protected $fillable = [
        'observacao',
        'caminho_ficha',
        'pessoa_id',
        'profissional_id',
        'formulario_id',
        'user_id',
        'user_update_id',
        'active',
        'status',
        'sigiloso',
        'dt_abertura',
        'dt_finalizacao',
        'dt_cancelamento',
        'pess_abert_id',
        'pess_cancel_id',
        'pess_finali_id',
    ];


    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id', 'id');
    }

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id', 'id');
    }

    public function resposta()
    {
        return $this->hasMany(PessoaFormularioResposta::class, 'pess_form_id', 'id');
    }
}
