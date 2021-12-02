<?php

use App\Models\Citie;
use Illuminate\Database\Seeder;

class CitieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
      //  Citie::query()->truncate();
        /*RAS/Eval*/
        Citie::create(['name' => 'Bogota']);
        Citie::create(['name' => 'Caracas']);
        Citie::create(['name' => 'Ciudad de México']);

    }
}
