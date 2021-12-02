<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Repository;

use Illuminate\Database\Eloquent\Factories\Factory;


class RepositoryFactory extends Factory
{
    
    protected $model = Repository::class;
    
    
    public function definition()
    {
        return [
            'user_id' => User::factory(),//asi se crea un usuario de prueba usando factory
            'url' => $this->faker->url,
            'description' => $this->faker->text,
        ];
    }
}
