<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{

    use RefreshDatabase; // Esto hace que se realice un migrate 
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDataUser()
    {
        // Proceso 
        User::factory()->create(['email'=>'test@example.com']);

        //Debemos usar ambas afirmaciones para que podamos validar si existe o no dicho usuario 
        //Afirmación si guarda 
        Self::assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
        //Afirmación si elimina
        Self::assertDatabaseMissing('users', [
            'email' => 'no@existe.com'
        ]);
    }
}
