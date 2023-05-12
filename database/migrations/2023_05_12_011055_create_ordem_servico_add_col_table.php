<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdemServicoAddColTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordem_servicos', function (Blueprint $table) {
            $table->decimal('vr_final', 60,6)->nullable()->default(null);
            $table->decimal('vr_desconto', 60,6)->nullable()->default(null);
            $table->decimal('pct_acrescimo', 60,6)->nullable()->default(null);
            $table->decimal('vr_acrescimo', 60,6)->nullable()->default(null);
        });

        Schema::table('servico_items', function (Blueprint $table) {
            $table->decimal('vr_final', 60,6)->nullable()->default(null);
            $table->decimal('vr_desconto', 60,6)->nullable()->default(null);
            $table->decimal('pct_acrescimo', 60,6)->nullable()->default(null);
            $table->decimal('vr_acrescimo', 60,6)->nullable()->default(null);
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
            $table->dropColumn(['vr_final', 'vr_desconto', 'vr_acrescimo', 'pct_acrescimo']);
        });

        Schema::table('servico_items', function (Blueprint $table) {
            $table->dropColumn(['vr_final', 'vr_desconto', 'vr_acrescimo', 'pct_acrescimo']);
        });
    }
}
