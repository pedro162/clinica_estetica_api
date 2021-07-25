<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Categoria;
use App\Ncm;

class Produto extends Model
{
    protected $fillable = [
        'marca_id',
        'user_id',
        'stock',
        'name',
        'description',
        'price',
        'active',
        'spotlight',
        'image'
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
