<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTenantIdToAllTables extends Migration
{
    public function up()
    {
        // Pega a conexão atual e o nome do banco usado
        $connection = DB::connection();
        $databaseName = $connection->getDatabaseName();

        // Obtenha todas as tabelas do banco
        $tables = $connection->select('SHOW TABLES');

        foreach ($tables as $table) {
            // Pega o nome da tabela de forma dinâmica
            $tableName = $table->{'Tables_in_' . $databaseName};

            // Ignore tabelas que não precisam da coluna tenant_id
            if (in_array($tableName, [
                'migrations', 
                'password_resets', 
                'failed_jobs', 
                'personal_access_tokens', 
                'simple_tenant_databases'
            ])) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                // Adiciona a coluna tenant_id se não existir
                if (!Schema::hasColumn($tableName, 'tenant_id')) {
                    $table->unsignedBigInteger('tenant_id')->nullable()->index();
                    $table->foreign('tenant_id')
                          ->references('id')
                          ->on('simple_tenant_databases')
                          ->onDelete('cascade')
                          ->onUpdate('cascade');
                }
            });
        }
    }

    public function down()
    {
        $connection = DB::connection();
        $databaseName = $connection->getDatabaseName();
        $tables = $connection->select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . $databaseName};

            if (in_array($tableName, [
                'migrations', 
                'password_resets', 
                'failed_jobs', 
                'personal_access_tokens', 
                'simple_tenant_databases'
            ])) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'tenant_id')) {
                    $table->dropForeign([$tableName . '_tenant_id_foreign']); // Ajusta nome do índice gerado
                    $table->dropColumn(['tenant_id']);
                }
            });
        }
    }
}
