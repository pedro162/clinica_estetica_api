<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Categoria;

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
        return $this->hasMany(Marca::class, 'marca_id');
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
