<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspecialidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especialidades', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->default(null);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);  
            $table->enum('active',['yes', 'no'])->default('yes');
            $table->timestamps();
        });

         Schema::create('espec_prof', function (Blueprint $table) {
            $table->id();
            $table->string('nr_doc')->nullable()->default(null);
            $table->date('dt_emiss_doc')->nullable()->default(null);
            $table->date('dt_vencimento_doc')->nullable()->default(null);
            $table->string('org_expedidor')->nullable()->default(null);
            $table->bigInteger('especialidade_id')->unsigned();
            $table->foreign('especialidade_id')->references('id')->on('especialidades')->onUpdate('cascade')->onDelete('cascade');     
            $table->bigInteger('profissional_id')->unsigned();
            $table->foreign('profissional_id')->references('id')->on('profissionals')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);  
            $table->enum('active',['yes', 'no'])->default('yes');
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
        Schema::dropIfExists('especialidades');
        Schema::dropIfExists('espec_prof');
    }
}
