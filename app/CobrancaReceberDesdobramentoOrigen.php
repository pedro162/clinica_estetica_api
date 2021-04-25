<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CobrancaReceberDesdobramentoOrigen extends Model
{
    protected $fillable = [

        'c_recebers_id' ,
        'c_rec_des_id',
        'user_id',
        'active'
        ];
}
