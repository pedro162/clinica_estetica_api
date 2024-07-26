<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimpleTenantDatabasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simple_tenant_databases', function (Blueprint $table) {
            $table->id();
            $table->string('name', 1000)->nullable()->default(null);
            $table->string('contact_number', 255)->nullable()->default(null);
            $table->string('contact_email', 255)->nullable()->default(null);
            $table->string('document', 1000)->nullable()->default(null);
            $table->bigInteger("max_users")->unsigned()->default(3);
            $table->enum('account_status', ['activated', 'canceled', 'paused'])->default('activated');
            $table->enum('active', ['yes', 'no'])->default('yes');
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
        Schema::dropIfExists('simple_tenant_databases');
    }
}
