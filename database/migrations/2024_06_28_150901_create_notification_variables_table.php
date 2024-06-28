<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_variables', function (Blueprint $table) {
            $table->id();
            $table->string('syntax', 1000)->nullable()->default(null);
            $table->string('value', 1000)->nullable()->default(null);
            $table->bigInteger("template_variable_id")->unsigned();
            $table->foreign('template_variable_id')->references('id')->on('template_variables')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger("notification_id")->unsigned();
            $table->foreign('notification_id')->references('id')->on('notifications')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);
            $table->enum('active', ['yes', 'no'])->default('no');
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
        Schema::dropIfExists('notification_variables');
    }
}
