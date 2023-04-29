<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddColValorAtendimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            $table->decimal('vr_atendimento', 60,6)->nullable()->default(null);
            $table->decimal('vr_desconto', 60,6)->nullable()->default(null);
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
        Schema::table('atendimentos', function (Blueprint $table) {
            $table->dropColumn(['vr_atendimento','vr_desconto', 'vr_acrescimo']);
        });
    }
}
