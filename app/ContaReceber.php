<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ContaReceberItem;
use App\Pessoa;

class ContaReceber extends Model
{
    protected $primaryKey = "id";

    protected $table = "conta_recebers";

    protected $fillable = [
    	'referencia_id',
		'referencia',
		'pessoa_id',
		'descricao',
		'documento',
		'dtVencimentoOriginal',
		'dtVencimento',
		'vrBruto',
		'vrLiquido',
		'vrDevolvido',
		'vrPago',
		'vrTaxa',
		'vrDesconto',
		'vrJuros',
		'user_id',
		'user_id',
		'user_update_id',
		'active',
		'responsavel_id',
		'importacao_dados',
    ];

    public function contaReceberItem()
    {
    	return $this->hasMany(ContaReceberItem::class,'conta_receber_id', 'id');
    }

    public function pessoa()
    {
    	return $this->belongsTo(Pessoa::class,'pessoa_id', 'id');
    }

}
