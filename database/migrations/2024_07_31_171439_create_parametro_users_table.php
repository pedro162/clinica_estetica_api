<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametroUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametro_users', function (Blueprint $table) {
            $table->id();
            $table->text('p_value')->nullable()->default(null)->comment('The parameter value');
            $table->bigInteger('p_campos_id')->unsigned()->comment('Parameter\'s field foreign key');
            $table->foreign('p_campos_id')->references('id')->on('parametro_campos')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('tenant_id')->nullable()->index();
            $table->foreign('tenant_id')->references('id')->on('simple_tenant_databases')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('p_user_id')->unsigned()->nullable()->default(null)->comment('The user to whom the parameter belongs');
            $table->foreign('p_user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('active', ['yes', 'no'])->default('yes');
            $table->bigInteger('user_id')->unsigned()->nullable()->default(null);
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('parametro_users');
    }
}
