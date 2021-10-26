<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaixasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caixas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type',['convencional', 'banco'])->default('convencional');
            $table->decimal('vrMin', 60, 3)->default(0);
            $table->decimal('vrMax', 60, 3)->default(0);
            $table->decimal('vrSaldo', 60, 3)->default(0);
            $table->enum('tpSaldo',['positivo', 'negativo'])->default('positivo');
            $table->enum('status_abertura',['open', 'close'])->default('close');
            $table->enum('status_bloqueio',['bloqueado', 'liberado'])->default('liberado');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);  
            $table->enum('active',['yes', 'no'])->default('no');
            $table->enum('aceita_transferencia',['yes', 'no'])->default('yes');
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
        Schema::dropIfExists('caixas');
    }
}
