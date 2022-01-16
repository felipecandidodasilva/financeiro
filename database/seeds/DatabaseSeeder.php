<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UersTableSeeder::class);
        $this->call(CentrodecustosSeeder::class);
        $this->call(CreateUserSeeder::class);
        $this->call(contasseeder::class);
        $this->call(CreateCategoriaSeeder::class);
        $this->call(TransactionsTypeSeeder::class);
    }
}
