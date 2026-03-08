<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PessoaFormularioResposta extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $table = 'pessoa_formulario_respostas';
    protected $primaryKey = 'id';
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
        'tenant_id'
    ];



    public function formitem()
    {
        return $this->belongsTo(FormularioItem::class, 'form_item_id', 'id');
    }
}
