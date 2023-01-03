<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_grupos', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("nr_ordem")->nullable()->default(null);
            $table->text("props_grupo")->nullable()->default(null);
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
        Schema::dropIfExists('formulario_grupos');
    }
}
