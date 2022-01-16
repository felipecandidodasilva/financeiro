<?php

use Illuminate\Database\Seeder;

class CentrodecustosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('centrodecustos')->insert([
            'id' => 1,
            'nome' => 'Meu Banco',
            'descricao' => 'Conta padrão do sistema, voce pode mudar o nome dela a vontade',
        ]);

        DB::table('centrodecustos')->insert([
            'id' => 2,
            'nome' => 'Carteira',
            'descricao' => 'Conta padrão do sistema, indica o dinheiro que tem em mãos',
        ]);
    }
}
