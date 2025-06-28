<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produto;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
  use SoftDeletes, BelongsToTenant;
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
