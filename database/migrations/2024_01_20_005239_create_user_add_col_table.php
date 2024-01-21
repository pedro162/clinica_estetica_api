<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddColTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('tenant_id')->unsigned()->nullable()->default(null)->comment('The tenant responsible for managing the user accounts');
            $table->string('type', 255)->nullable()->default(null)->comment('User type, like admin, external_user');
            $table->enum('is_system', ['yes', 'no'])->default('no')->comment('Is this the main user of the system?');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'tenant_id', 'type', 'is_system'
            ]);
        });
    }
}
