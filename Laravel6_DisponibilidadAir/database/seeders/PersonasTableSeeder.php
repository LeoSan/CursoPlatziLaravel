<?php

namespace Database\Seeders;

use App\Models\Persona;
use Illuminate\Database\Seeder;

class PersonasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Persona::truncate();
        Persona::create([
            'activo'=>true,
            'user_core_id'=>9019,
            'plataforma_id'=>1
        ]);
        Persona::create([
            'activo'=>true,
            'user_core_id'=>9020,
            'plataforma_id'=>1
        ]);
    }
}
