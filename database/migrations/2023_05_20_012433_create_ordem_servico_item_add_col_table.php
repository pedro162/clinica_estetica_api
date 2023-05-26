<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdemServicoItemAddColTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servico_items', function (Blueprint $table) {
            $table->decimal('vrItemBruto', 60,6)->nullable()->default(null);
            $table->decimal('qtd_devolucao', 60,6)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servico_items', function (Blueprint $table) {
            $table->dropColumn(['vrItemBruto', 'qtd_devolucao']);
        });
    }
}
