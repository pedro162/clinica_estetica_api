<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateContaReceberItemsChangeStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $driver = DB::getDriverName() ?? 'mysql';

        if ($driver === 'mysql' || $driver === 'mariadb') {
            // MySQL e MariaDB suportam ENUM, então usamos ALTER TABLE
            DB::statement("ALTER TABLE conta_receber_items MODIFY COLUMN status ENUM('pago', 'devolvido', 'estornado', 'aberto') NOT NULL");
        } elseif ($driver === 'pgsql') {
            // Para PostgreSQL, é necessário criar um novo tipo ENUM
            DB::statement("ALTER TYPE status_enum ADD VALUE 'aberto'");
        } else {
            // Para SQLite e outros, trocamos ENUM por STRING
            Schema::table('conta_receber_items', function (Blueprint $table) {
                $table->string('status')->default('pago')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $driver = DB::getDriverName() ?? 'mysql';

        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement("ALTER TABLE conta_receber_items MODIFY COLUMN status ENUM('pago', 'devolvido', 'estornado') NOT NULL");
        } elseif ($driver === 'pgsql') {
            // PostgreSQL não permite remover valores de ENUM diretamente
            // Então precisaríamos criar uma coluna temporária e migrar os dados
            Schema::table('conta_receber_items', function (Blueprint $table) {
                $table->string('status_temp')->default('pago');
            });

            DB::statement("UPDATE conta_receber_items SET status_temp = status::TEXT");

            Schema::table('conta_receber_items', function (Blueprint $table) {
                $table->dropColumn('status');
                $table->renameColumn('status_temp', 'status');
            });
        } else {
            Schema::table('conta_receber_items', function (Blueprint $table) {
                $table->string('status')->default('pago')->change();
            });
        }
    }
}
