<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produto;

class Categoria extends Model
{
  protected $fillable = [
    'user_id',
    'name',
    'tenant_id'
  ];

  public function produto()
  {
    return $this->belongsToMany(Produto::class);
  }
}
