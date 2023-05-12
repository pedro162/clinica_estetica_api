<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdemServicoAddColProfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordem_servicos', function (Blueprint $table) {
            $table->bigInteger('profissional_id')->unsigned()->nullable()->default(null);
            $table->foreign('profissional_id')->references('id')->on('profissionals')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('pct_desconto', 60,6)->nullable()->default(null);
        });

        Schema::table('servico_items', function (Blueprint $table) {
            $table->decimal('pct_desconto', 60,6)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordem_servicos', function (Blueprint $table) {
            $table->dropForeign('ordem_servicos_profissional_id_foreign');
            $table->dropColumn(['profissional_id', 'pct_desconto']);
        });

        Schema::table('servico_items', function (Blueprint $table) {
            $table->dropColumn(['pct_desconto']);
        });
    }
}
