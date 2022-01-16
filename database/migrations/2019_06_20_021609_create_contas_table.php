<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;


class CreateContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBiginteger('centrodecusto_id');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->float('saldo')->default(0);
            $table->boolean('saida_rapida')->default(false);
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('centrodecusto_id')->references('id')->on('centrodecustos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contas');
    }
}
