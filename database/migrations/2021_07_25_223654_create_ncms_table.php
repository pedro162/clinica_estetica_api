<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNcmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ncms', function (Blueprint $table) {
            $table->id();
            $table->string('codNcm');
            $table->string('nmNcm')->nullable();
            $table->string('excecaoNcm')->nullable();
            $table->string('tpCodigo')->nullable();
            $table->string('exTipi')->nullable();
            $table->string('nmTabela')->nullable();
            $table->decimal('vrAliqNacional', 10, 3);
            $table->decimal('vrAliqImportada', 10, 3);
            $table->decimal('vrAliqEstadual', 10, 3);
            $table->decimal('vrAliqMunicipal', 10, 3);
            
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);  
            $table->enum('active',['yes', 'no'])->default('no');

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
        Schema::dropIfExists('ncms');
    }
}
