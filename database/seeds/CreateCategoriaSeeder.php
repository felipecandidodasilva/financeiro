<?php

use Illuminate\Database\Seeder;

class CreateCategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert([
            'nome' => 'Gastos Diversos',
            'tipo' => 'S'
        ]);
        DB::table('categorias')->insert([
            'nome' => 'Alimentação',
            'tipo' => 'S'
        ]);
        DB::table('categorias')->insert([
            'nome' => 'Saúde',
            'tipo' => 'S'
        ]);
        DB::table('categorias')->insert([
            'nome' => 'Despesas Fixas',
            'tipo' => 'S'
        ]);
        DB::table('categorias')->insert([
            'nome' => 'Salário',
            'tipo' => 'E'
        ]);
        DB::table('categorias')->insert([
            'nome' => 'Vendas',
            'tipo' => 'E'
        ]);
    }
}
