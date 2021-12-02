<?php

use Illuminate\Database\Seeder;
use App\User; 
use \App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
       // User::factory(10)->create();
       // Post::factory(120)->create();
        
         
        //Ejecutar con artisan  tinker  por comandos 
        // factory(App\User::class,12)->create() //Solo si ejecuta si cremos su factory  
        // factory(App\Post::class, 30)->create(); //Solo si ejecuta si cremos su factory 


    }
}
