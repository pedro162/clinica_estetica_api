<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCols07092023OrdemServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordem_servicos', function (Blueprint $table) {
            //$table->enum('active',['yes', 'no'])->default('no');
            $table->enum('type', ['orcamento', 'pedido'])->default('orcamento');
            $table->enum('is_orcamento', ['yes', 'no'])->comment('Para indicar se o em algum momento foi salvo como orçamento')->default('yes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordem_servicos', function (Blueprint $table) {
            $table->dropColumn([
                'type', 'is_orcamento'
            ]);
        });
    }
}
