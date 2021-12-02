<?php

namespace Tests\Unit\Models;


use App\Models\User;
use App\Models\Repository;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase; //Acá agregar este use

class RepositoryTest extends TestCase
{

    use RefreshDatabase;// Esto es para mantener la tabla dinamicamente limpias. 

    public function test_belong_to_user()
    {
        $repository = Repository::factory()->create();
        Self::assertInstanceOf(User::class, $repository->user);

    }
}
