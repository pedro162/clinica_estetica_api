<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePisCofinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pis_cofins', function (Blueprint $table) {
            $table->id();
            $table->string('dsPisCofins');
            $table->enum('tpCalculo', ['pc', 'vr'])->default('pc');
            $table->enum('tpRegistro', ['pis', 'cofins','pisst', 'cofinsst'])->default('pis');
            $table->decimal('vrPisCofins', 10, 3)->default(0);
            $table->decimal('pcPisCofins', 10, 3)->default(0);
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
        Schema::dropIfExists('pis_cofins');
    }
}
