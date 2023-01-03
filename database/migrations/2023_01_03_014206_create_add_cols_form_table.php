<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddColsFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formulario_grupos', function (Blueprint $table) {
            $table->bigInteger('formulario_id')->unsigned();
            $table->foreign('formulario_id')->references('id')->on('formularios')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('formulario_grupos', function (Blueprint $table) {
            //
        });
    }
}
