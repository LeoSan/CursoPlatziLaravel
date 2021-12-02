<?php

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Project::firstOrCreate(['name' => 'Aprender Eloquent', 'company_id' => '1', 'user_id'=>1, 'citie_id'=>1]);
        Project::firstOrCreate(['name' => 'Aprender Usar Take', 'company_id' => '1', 'user_id'=>1, 'citie_id'=>1]);
        Project::firstOrCreate(['name' => 'Aprender Usar find', 'company_id' => '1', 'user_id'=>1, 'citie_id'=>1]);
        Project::firstOrCreate(['name' => 'Aprender Usar where', 'company_id' => '1', 'user_id'=>1, 'citie_id'=>1]);
        Project::firstOrCreate(['name' => 'Aprender Usar first', 'company_id' => '1', 'user_id'=>1, 'citie_id'=>1]);
        Project::firstOrCreate(['name' => 'Aprender Usar findOrfail', 'company_id' => '1', 'user_id'=>1, 'citie_id'=>1]);
        Project::firstOrCreate(['name' => 'Aprender Usar findOrCreate', 'company_id' => '1', 'user_id'=>1, 'citie_id'=>1]);
        Project::firstOrCreate(['name' => 'Aprender Usar delete', 'company_id' => '1', 'user_id'=>1, 'citie_id'=>1]);
        Project::firstOrCreate(['name' => 'Aprender Usar update', 'company_id' => '1', 'user_id'=>1, 'citie_id'=>1]);
        Project::firstOrCreate(['name' => 'Aprender Usar create', 'company_id' => '1', 'user_id'=>1, 'citie_id'=>1]);
        Project::firstOrCreate(['name' => 'Aprender Usar destroy', 'company_id' => '1', 'user_id'=>1, 'citie_id'=>1]);
        Project::firstOrCreate(['name' => 'Aprender Usar orderBy', 'company_id' => '1', 'user_id'=>1, 'citie_id'=>1]);
    }
}
