<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipis', function (Blueprint $table) {
            $table->id();
            $table->string('dsIpi');
            $table->string('cst');
            $table->string('cdExTipi')->nullable();
            $table->enum('tpCalculo', ['vr', 'pc'])->default('pc');
            $table->decimal('pcIpi', 50, 3)->default(0);
            $table->decimal('vrIpi', 50, 3)->default(0);
            $table->decimal('bcIpi', 50, 3)->default(0);
            $table->enum('somaBcIcms', ['yes', 'no'])->default('no');
            $table->enum('somaBcIcmsSt', ['yes', 'no'])->default('no');
            $table->string('dsClassEnquadra')->nullable();
            $table->string('cdEnquadra')->nullable();
            $table->string('cnpjProdutor')->nullable();
            $table->string('cdCeloControle')->nullable();
            
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
        Schema::dropIfExists('ipis');
    }
}
