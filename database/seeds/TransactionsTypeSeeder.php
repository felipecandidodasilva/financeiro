<?php

use Illuminate\Database\Seeder;

class TransactionsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Transactiontypes')->insert([
            'name' => 'Entrada',
            'id' => 1,
        ]);
        DB::table('Transactiontypes')->insert([
            'name' => 'Saída',
            'id' => 2,
        ]);
        DB::table('Transactiontypes')->insert([
            'name' => 'Transferência',
            'id' => 3,
        ]);
        DB::table('Transactiontypes')->insert([
            'name' => 'Estorno',
            'id' => 4,
        ]);
    }
}
