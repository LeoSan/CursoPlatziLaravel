<?php

use App\Models\Companie;
use Illuminate\Database\Seeder;

class CompanieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // Companie::query()->truncate();
        //
        Companie::create(['name' => 'Google']);
        Companie::create(['name' => 'Amazon']);
        Companie::create(['name' => 'Apple']);
        Companie::create(['name' => 'Microsoft']);
    }
}
