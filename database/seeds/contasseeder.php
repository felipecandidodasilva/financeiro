<?php

use Illuminate\Database\Seeder;

class contasseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contas')->insert([
            'centrodecusto_id' => 1, // conta corrente
            'nome' => 'Meu Banco Conta Corrente',
            'saldo' => 0
        ]);
        DB::table('contas')->insert([
            'centrodecusto_id' => 1, // conta corrente
            'nome' => 'Meu Banco Conta Poupança',
            'saldo' => 0
        ]);
        DB::table('contas')->insert([
            'centrodecusto_id' => 1, // conta corrente
            'nome' => 'Carteira Dinheiro em mãos',
            'saldo' => 0
        ]);
    }
}
