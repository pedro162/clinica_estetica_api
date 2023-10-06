<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EventoAgenda;
use App\Pessoa;
use App\Profissional;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\FormularioItem;

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
        'form_item_id',
    ];



    public function formitem()
    {
        return $this->belongsTo(FormularioItem::class, 'form_item_id', 'id');
    }
}
