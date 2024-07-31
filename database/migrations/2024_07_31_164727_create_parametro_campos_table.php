<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametroCamposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametro_campos', function (Blueprint $table) {
            $table->id();
            $table->string('name', 1000)->comment('The field\'s name')->nullable()->default(null);
            $table->string('key', 1000)->comment('The field\'s key')->nullable()->default(null);
            $table->enum('control_type', ['input', 'select', 'textarea', 'image', 'radio'])->comment('The field\'s control type')->nullable()->default('input');
            $table->text('options', 1000)->comment('The field\'s options')->nullable()->default(null);
            $table->text('default_value', 1000)->comment('The field\'s default value')->nullable()->default(null);
            $table->text('props')->comment('The field\'s prop ex: style="color:red" class="class_name" ')->nullable()->default(null);
            $table->bigInteger('parametro_id')->unsigned()->comment('Param foreign key');
            $table->foreign('parametro_id')->references('id')->on('parametros')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('tenant_id')->nullable()->index();
            $table->foreign('tenant_id')->references('id')->on('simple_tenant_databases')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('active', ['yes', 'no'])->default('yes');
            $table->bigInteger('user_id')->unsigned()->nullable()->default(null);
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * 
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
     */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parametro_campos');
    }
}
