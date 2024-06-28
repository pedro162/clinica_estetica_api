<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable()->default(null)->comment('The notification title');
            $table->longText('message')->nullable()->default(null)->comment('The notification message');
            $table->string('origin_contact_address', 3000)->nullable()->default(null)->comment('The origin contact address. Ex: cel phone number, some endpoint');
            $table->string('target_contact_address', 3000)->nullable()->default(null)->comment('The target contact address. Ex: cel phone number, some endpoint');
            $table->string('target_contact_name', 500)->nullable()->default(null)->comment('The target name. Ex: client name');
            $table->bigInteger('template_id')->unsigned()->nullable()->default(null);
            $table->foreign('template_id')->references('id')->on('templates')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('shipping_state', ['waiting', 'processing', 'concluded', 'canceled', 'reject'])->default('waiting');
            $table->dateTime('sent_date')->nullable()->default(null)->comment('The notification sent date');
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
        Schema::dropIfExists('notifications');
    }
}
