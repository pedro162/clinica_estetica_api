<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class NaturezaOperacao extends Model
{
    use SoftDeletes, BelongsToTenant;
}
