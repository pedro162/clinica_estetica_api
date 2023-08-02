<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaReceberCartaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_receber_cartaos', function (Blueprint $table) {
            $table->id();
            $table->string('nr_doc')->nullable()->default(null);
            $table->date('dt_emissao')->nullable()->default(null);
            $table->date('dt_vencimento')->nullable()->default(null);
            $table->date('dt_baixa')->nullable()->default(null);
            $table->string('bandeira_name')->nullable()->default(null);
            $table->decimal('vr_bruto',60, 5)->nullable()->default(null);
            $table->decimal('vr_liquido',60, 5)->nullable()->default(null);
            $table->decimal('vr_taxa',60, 5)->nullable()->default(null);
            $table->decimal('pct_taxa',60, 5)->nullable()->default(null);
            $table->decimal('vr_outrasTaxas',60, 5)->nullable()->default(null);
            $table->enum('status',['aberto', 'pago'])->default('aberto');
            $table->bigInteger('conta_receber_id')->unsigned();
            $table->foreign('conta_receber_id')->references('id')->on('conta_recebers')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('bandeira_cartao_id')->unsigned();
            $table->foreign('bandeira_cartao_id')->references('id')->on('bandeira_cartaos')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null); 
            $table->enum('active',['yes', 'no'])->default('no');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    //
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conta_receber_cartaos');
    }
}
