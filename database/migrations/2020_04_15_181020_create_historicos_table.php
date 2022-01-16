<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('conta_id');
            $table->unsignedBigInteger('type_id');
            $table->string('descricao');
            $table->float('valor');
            $table->date("date");
            $table->timestamps();

            $table->foreign('conta_id')->references('id')->on('contas');
            $table->foreign('type_id')->references('id')->on('transactiontypes'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('historicos', function (Blueprint $table) {
        //     $table->dropForeign(['historicos_type_id_foreign']);
        //     $table->dropForeign(['historicos_user_id_foreign']);
        // });
        // Schema::dropForeign('historicos_type_id_foreign');
        // Schema::dropForeign('historicos_user_id_foreign');
        Schema::dropIfExists('historicos');
    }
}
