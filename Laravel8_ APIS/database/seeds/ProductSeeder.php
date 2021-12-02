<?php

use Illuminate\Database\Seeder;
use  App\models\Product; 
use  App\User; 

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory( Product::class, 20 )->create();
        factory( User::class, 5 )->create();
    }
}
