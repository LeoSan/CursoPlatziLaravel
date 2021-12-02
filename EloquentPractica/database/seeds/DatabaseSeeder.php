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
        
        $this->call(CitieSeeder::class);
        $this->call(CompanieSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ProjectSeeder::class);
    }
}
