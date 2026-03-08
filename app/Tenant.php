<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Tenant extends Model
{
    protected $connection  = 'landlord';

    protected $guarded = [];

    protected $fillable = [
        'id',
        'name',
        'domain',
        'database',
    ];

    protected $primaryKey = 'id';

    public function configure()
    {

        DB::purge('mysql');
        DB::purge('tenant');

        /*config([
            'database.connections.tenant.database'=>$this->database,
            'database.connections.tenant.username'=>'root',
            'database.connections.tenant.password'=>''
        ]);*/

        //Config::set('database.connections.tenant.host', $empresa->mysql_host);

        Config::set('database.connections.tenant.database', $this->database);
        Config::set('database.connections.tenant.username', 'root');
        Config::set('database.connections.tenant.password', '');
        Config::set('database.default', 'tenant');




        DB::reconnect('tenant');

        Schema::connection('tenant')->getConnection()->reconnect();
        return $this;

    }

    public function use()
    {
        app()->forgetInstance('tenant');
        app()->instance('tenant', $this);

        return $this;
    }
}
