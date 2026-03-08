<?php

namespace App\Traits;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait TenantConnector
{
    /*
    * Altera a conexão tenant para a empresa selecionada
    * @param Empresa $Empresa
    * @return void
    * @throws
    */

    /* public function reconnect(Empresa $empresa){

         // Apaga a conexão tenant, forçando o Laravel a voltar suas configurações de conexão para o padrão.
         //DB::purge('tenant');


         // Setando os dados da nova conexão.
         Config::set('database.connections.tenant.host', $empresa->mysql_host);
         Config::set('database.connections.tenant.database', $empresa->mysql_database);
         Config::set('database.connections.tenant.username', $empresa->mysql_username);
         Config::set('database.connections.tenant.password', $empresa->mysql_password);

         // Conecta no banco
         //DB::reconnect('tenant');
         //DB::connection('tenant');

         // Testa a nova conexão
        //Schema::connection('tenant')->getConnection()->reconnect();
     }*/
}
