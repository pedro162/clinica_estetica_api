<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_items', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("type");
            $table->string("options")->nullable()->default(null);
            $table->string("default_value")->nullable()->default(null);
            $table->text("props")->nullable()->default(null);
            $table->string("label")->nullable()->default(null);
            $table->text("props_label")->nullable()->default(null);
            $table->text("nr_linha")->nullable()->default(null);
            $table->text("nr_coluna")->nullable()->default(null);
            $table->bigInteger('formulario_grupo_id')->unsigned();
            $table->foreign('formulario_grupo_id')->references('id')->on('formulario_grupos')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('formulario_id')->unsigned();
            $table->foreign('formulario_id')->references('id')->on('formularios')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('formulario_items');
    }
}
