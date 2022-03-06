<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedbigInteger('user_id');
            $table->unsignedbigInteger('conta_id');
            $table->unsignedbigInteger('categoria_id');
            $table->string('nome', 50)->default('Nome da Entrada');
            $table->text('descricao')->nullable();
            $table->float('valor');
            $table->integer('parcela')->default(1);
            $table->string('comprovante')->nullable();
            $table->string('id_referencia');
            $table->boolean('confirmado')->default(false);
            $table->date('data');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('conta_id')->references('id')->on('contas');
            $table->foreign('categoria_id')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entradas');
    }
}
