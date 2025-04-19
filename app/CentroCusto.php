<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\SoftDeletes;

class CentroCusto extends Model
{
    use SoftDeletes, BelongsToTenant;
}
