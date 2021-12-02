<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Tag;

class TagControllerTest extends TestCase
{

    //use RefreshDatabase;

    public function testStore()
    {
       
        $this->post('tags', ['name'=>'PHP'])//enviar info para almacenar al Metodo Store del controlador
             ->assertRedirect('/');//Valida que redirecciona

        $this->assertDatabaseHas('tags', ['name'=>'PHP'] ); //Valida que esta información este en la tabla 
    }    
    
    public function testDestroy()
    {
       
        //$tag = Tag::factory()->create();
        $tag = Tag::find(2);

        $this
            ->delete("tags/$tag->id")
            ->assertRedirect('/');//Valida que redireccione 
        
        $this->assertDatabaseMissing('tags', ['name' => $tag->name]);//Valida que este valor no este en la base de datos
    }    
    
    public function testValidate()
    {
        $this
            ->post('tags', ['name' => ''])
            ->assertSessionHasErrors('name');
    }

    public function test_slug()
    {
        $tag = new Tag;
        $tag->name = 'Tag TDD Laravel 8';

        $this->assertEquals('tag-tdd-laravel-8', $tag->slug);
    }    
}
