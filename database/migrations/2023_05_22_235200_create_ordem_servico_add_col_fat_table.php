<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdemServicoAddColFatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordem_servicos', function (Blueprint $table) {
            $table->enum('is_faturado', ['yes', 'no'])->default('no');
            $table->date('td_faturamento')->nullable()->default(null);
            $table->date('td_cancelamento')->nullable()->default(null);
            $table->date('td_conclusao')->nullable()->default(null);
            $table->bigInteger('pess_fat_id')->unsigned()->nullable()->default(null)->comment("Código da pessoa que faturou a ordem de seviço");
            $table->foreign('pess_fat_id')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('pess_cancel_id')->unsigned()->nullable()->default(null)->comment('Código da pessoa que cancelou a ordem de serviço');
            $table->foreign('pess_cancel_id')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('pess_concl_id')->unsigned()->nullable()->default(null)->comment("Código da pessoa que marcou a orde de serviço como finalizada");
            $table->foreign('pess_concl_id')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');

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
            $table->dropForeign('ordem_servicos_pess_fat_id_foreign');
            $table->dropForeign('ordem_servicos_pess_cancel_id_foreign');
            $table->dropForeign('ordem_servicos_pess_concl_id_foreign');
            $table->dropColumn(['is_faturado', 'td_faturamento', 'td_cancelamento', 'td_conclusao', 'pess_fat_id', 'pess_cancel_id', 'pess_concl_id']);
        });
    }
}
