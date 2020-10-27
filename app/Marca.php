<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Marca extends Model
{
	protected $fillable = [
		'name',
		'user_id'
	];

    public function produto()
    {
    	return $this->hasMany(Produto::class, 'marca_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
