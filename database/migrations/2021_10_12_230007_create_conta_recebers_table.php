<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaRecebersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_recebers', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('referencia_id')->unsigned()->nullable()->default(null);
            $table->string('referencia')->nullable()->default(null);
            $table->bigInteger('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('descricao')->nullable()->default(null);
            $table->string('documento')->nullable()->default(null);
            $table->date('dtVencimentoOriginal');
            $table->date('dtVencimento');
            $table->decimal('vrBruto', 10, 3)->default(0);
            $table->decimal('vrLiquido', 10, 3)->default(0);
            $table->decimal('vrDevolvido', 10, 3)->default(0);
            $table->decimal('vrPago', 10, 3)->default(0);
            $table->decimal('vrTaxa', 10, 3)->default(0);
            $table->decimal('vrDesconto', 10, 3)->default(0);
            $table->decimal('vrJuros', 10, 3)->default(0);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);  
            $table->enum('active',['yes', 'no'])->default('no');
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
        Schema::dropIfExists('conta_recebers');
    }
}
