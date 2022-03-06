<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //endereço
            $table->string('cep',8)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            //dados
            $table->string('contato')->nullable(); // quando empresa precisa ter um nome de contato
            $table->string('telefone')->nullable();
            $table->date('nascimento')->nullable();
            $table->string('cpf')->nullable();
            $table->string('cnpj')->nullable();
            $table->boolean('cliente')->nullable()->default(true);
            $table->boolean('funcionario')->nullable()->default(false);
            $table->boolean('fornecedor')->nullable()->default(false);
            $table->text('detalhes')->nullable(); // detalhes do cliente/empresa
            
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
            //
        });
    }
}
