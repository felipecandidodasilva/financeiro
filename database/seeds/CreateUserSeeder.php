<?php

use Illuminate\Database\Seeder;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'          => 'Administrador Padrão',
            'email'         => 'administrador@sistema.com.br',
            'cliente'       => false,
            'funcionario'       => true,
            'password'      => bcrypt('sistema'),
            ]);
            DB::table('users')->insert([
            'name'          => 'Cliente padrão',
            'email'         => 'cliente@sistema.com.br',
            'password'      => bcrypt('sistema'),
            ]);
            DB::table('users')->insert([
            'name'          => 'Fornecedor padrão',
            'email'         => 'fornecedor@sistema.com.br',
            'cliente'       => false,
            'fornecedor'    => true,
            'password'      => bcrypt('sistema'),
        ]);
    }
}
