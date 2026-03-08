<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PessoaFormulario extends Model
{
    use SoftDeletes;
    use BelongsToTenant;
    protected $table = 'pessoa_formularios';
    protected $primaryKey = 'id';
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
        'filial_id',
        'tenant_id'
    ];


    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id', 'id');
    }

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id', 'id');
    }

    public function formulario()
    {
        return $this->belongsTo(Formulario::class, 'formulario_id', 'id');
    }

    public function filial()
    {
        return $this->belongsTo(Filial::class, 'filial_id', 'id');
    }

    public function resposta()
    {
        return $this->hasMany(PessoaFormularioResposta::class, 'pess_form_id', 'id');
    }
}
