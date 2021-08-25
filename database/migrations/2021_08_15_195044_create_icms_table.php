<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIcmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icms', function (Blueprint $table) {
            $table->id();
            $table->string('nmIcms');
            $table->decimal('pcAliq', 60, 2)->default(0);
            $table->decimal('pcAliqSt', 60, 2)->default(0);
            $table->decimal('baseIcms', 60, 2)->default(0);
            $table->decimal('baseCalcOpPropri', 60, 2)->default(0);
            $table->decimal('baseIcmsSt', 60, 2)->default(0);
            $table->decimal('baseStRetido', 60, 2)->default(0);
            $table->decimal('aliqStRetido', 60, 2)->default(0);
            $table->decimal('aliqCalcCred', 60, 2)->default(0);
            $table->decimal('aliqSn', 60, 2)->default(0);
            //$table->decimal('pcAliInterna', 60, 2)->default(0);
            $table->decimal('pcAliqPf', 60, 2)->default(0);
            $table->decimal('pcAliqPj', 60, 2)->default(0);
            $table->decimal('pcFcp', 60, 2)->default(0);
            $table->decimal('pcMva', 60, 2)->default(0);
            $table->decimal('vrReduzBc', 60, 2)->default(0);
            $table->decimal('vrReduzBcSt', 60, 2)->default(0);
            $table->string('st')->default(null);
            $table->string('csosn')->default(null);
            $table->string('cest')->default(null);
            $table->enum('modBcIcms', ['mva', 'vr_pauta', 'vr_prec_tab_max_suger', 'vr_operacao', 'list_positiva', 'list_negativa','list_neutra',])->default('vr_operacao');
            
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
        Schema::dropIfExists('icms');
    }
}
