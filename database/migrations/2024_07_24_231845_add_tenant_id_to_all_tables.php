<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTenantIdToAllTables extends Migration
{
    public function up()
    {
        // Obtenha todas as tabelas do banco de dados
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . env('DB_DATABASE')};

            // Ignore as tabelas que não são relevantes
            if (in_array($tableName, ['migrations', 'password_resets', 'failed_jobs', 'personal_access_tokens', 'simple_tenant_databases'])) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                // Adicione a coluna tenant_id se ela não existir
                if (!Schema::hasColumn($tableName, 'tenant_id')) {
                    $table->unsignedBigInteger('tenant_id')->nullable()->index();
                    $table->foreign('tenant_id')->references('id')->on('simple_tenant_databases')->onDelete('cascade')->onUpdate('cascade');
                }
            });
        }
    }

    public function down()
    {
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . env('DB_DATABASE')};

            // Ignore as tabelas que não são relevantes
            if (in_array($tableName, ['migrations', 'password_resets', 'failed_jobs', 'personal_access_tokens', 'simple_tenant_databases'])) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                // Remova a coluna tenant_id se ela existir
                if (Schema::hasColumn($tableName, 'tenant_id')) {
                    $table->dropIndex('parametros_tenant_id_index');
                    $table->dropColumn(['tenant_id']);
                }
            });
        }
    }
}
