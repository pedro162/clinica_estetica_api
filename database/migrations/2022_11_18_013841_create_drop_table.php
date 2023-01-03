<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDropTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Schema::table('evento_agendas', function (Blueprint $table) {
            //
        }); */

        Schema::dropIfExists('categoria_eventos');
        Schema::dropIfExists('evento_agendas');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evento_agendas', function (Blueprint $table) {
            //
        });
    }
}
