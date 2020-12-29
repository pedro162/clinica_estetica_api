<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\CobrancaReceberDesdobramentoDestino;
use \App\CobrancaReceberDesdobramentoOrigen;

class CobrancaReceberDesdobramento extends Model
{
    protected $fillable = [
        'vrDesdobramento',
        'qtdParcelas',
        'vrJuros',
        'vrMultas',
        'vrJurosProrrogacao',
        'vrAliquotaJuros',
        'qtdDias',
        'vrInicialDesdobramento',
        'vrFinalDesdobramento',
        'vrDiferencaDesdobramento',
        'vrAcrescimos',
        'vrDescontos',
        'vrJurosDispensados',
        'vrMultaDispensada',
        'vrEntrada',
        'idReferencia',
        'tpReferencia',
        'isRenegociacao',
        'user_id',
        'user_update_id',
        'active',
    ];

   public function origem()
   {
       return $this->hasMany(CobrancaReceberDesdobramentoOrigen::class);
   }


   public function destino()
   {
       return $this->hasMany(CobrancaReceberDesdobramentoDestino::class);
   }




}
