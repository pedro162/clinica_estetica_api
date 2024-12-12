<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotivoCancelamentoOrdemServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motivo_cancelamento_ordem_servicos', function (Blueprint $table) {
            $table->id();
            $table->string('motivo');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);
            $table->enum('active', ['yes', 'no'])->default('no');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('ordem_servicos', function (Blueprint $table) {

            $table->bigInteger('mt_calcel_id')->unsigned()->nullable()->default(null)->comment("Código do motivo de cancelamento da ordem de seviço");
            $table->foreign('mt_calcel_id')->references('id')->on('motivo_cancelamento_ordem_servicos')->onDelete('cascade')->onUpdate('cascade');
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

            $table->dropForeign('ordem_servicos_mt_calcel_id_foreign');
            $table->dropColumn([
                'mt_calcel_id'
            ]);
        });

        Schema::dropIfExists('motivo_cancelamento_ordem_servicos');
    }
}
