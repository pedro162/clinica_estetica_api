<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsAddCols01Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->enum('type', ['email', 'whatsapp', 'default'])->nullable()->default(null)->index('type_index');
            $table->bigInteger('filial_id')->unsigned()->nullable()->default(null)->comment('Foreign key for branch id');
            $table->foreign('filial_id')->references('id')->on('filials')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            //$table->dropIndex('type_index');
            $table->dropForeign('notifications_filial_id_foreign');
            $table->dropColumn((['type']));
        });
    }
}
