<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \App\OrdemServico;

class MotivoCancelamentoOrdemServico extends Model
{
    use SoftDeletes;

    protected $table='motivo_cancelamento_ordem_servicos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'motivo',
        'user_id',
		'user_update_id',
		'active'

    ];

    public function ordemServico(){
        return $this->hasMany(OrdemServico::class, 'mt_calcel_id', 'id');
    }
}
