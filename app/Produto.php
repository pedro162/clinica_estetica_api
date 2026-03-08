<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $fillable = [
        'marca_id',
        'user_id',
        'stock',
        'name',
        'description',
        'price',
        'active',
        'spotlight',
        'image',
        'tenant_id'
    ];

    public function marca()
    {
        return $this->hasOne(Marca::class, 'id', 'marca_id');
    }

    public function ncm()
    {
        return $this->hasOne(Ncm::class, 'produto_id', 'produto_id');
    }

    public function categoria()
    {
        return $this->belongsToMany(Categoria::class);
    }

    public function adicionarCategoria($categoria, $dados)
    {
        return $this->categoria()->attach($categoria, $dados);
    }

    public function removeverCategoria($categoria)
    {
        return $this->categoria()->detach($categoria);
    }
}
