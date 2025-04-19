<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class Fornecedor extends Model
{
    use SoftDeletes, BelongsToTenant;
}
