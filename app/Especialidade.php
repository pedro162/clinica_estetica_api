<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Profissional;

class Especialidade extends Model
{
    protected $table = "especialidades";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];

    public function profissional()
    {
        return $this->belongsToMany(Profissional::class, 'espec_prof', 'especialidade_id', 'profissional_id')
            ->withPivot(
                'nr_doc',
                'dt_emiss_doc',
                'dt_vencimento_doc',
                'org_expedidor',
                'especialidade_id',
                'profissional_id',
                'user_id',
                'user_update_id',
                'active'
            );
    }
}
