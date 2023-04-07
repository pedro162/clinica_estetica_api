<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string("descricao")->nullable()->default(null);
            $table->date('data')->nullable()->default(null);
            $table->time('hora')->nullable()->default(null);
            $table->bigInteger('referencia_id')->nullable()->default(null);
            $table->string('referencia')->nullable()->default(null);
            $table->enum('status', ['pendente', 'concluida', 'cancelada']);
            $table->dateTime('dt_cancelamento')->nullable()->default(null);
            $table->bigInteger('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('pess_cancel_id')->unsigned()->nullable()->default(null);
            $table->foreign('pess_cancel_id')->references('id')->on('pessoas')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);  
            $table->enum('active',['yes', 'no'])->default('yes');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendas');
    }
}
