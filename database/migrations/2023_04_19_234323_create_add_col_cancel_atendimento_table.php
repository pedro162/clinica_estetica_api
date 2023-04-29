<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddColCancelAtendimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            
            $table->dateTime('dt_cancelamento')->nullable()->default(null);
            $table->string('ds_cancelamento', 500)->nullable()->default(null);
            $table->bigInteger('pess_cancel_id')->unsigned()->nullable()->default(null);
            $table->foreign('pess_cancel_id')->references('id')->on('pessoas')->onUpdate('cascade')->onDelete('cascade');
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
            $table->dropForeign('atendimentos_pess_cancel_id_foreign');
            $table->dropColumn(['dt_cancelamento','ds_cancelamento', 'pess_cancel_id']);
            
        });
    }
}
