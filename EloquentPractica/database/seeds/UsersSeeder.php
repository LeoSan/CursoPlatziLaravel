<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::firstOrCreate(['name' => 'Esmeralda Hernandez', 'email' => 'esmeralda.hernandez.j@gmail.com', 'password'=>bcrypt('123456')]);
    }
}
