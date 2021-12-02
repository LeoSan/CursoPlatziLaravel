<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Http\UploadedFile;       //Permite ingresar imagenes falsas 
use Illuminate\Support\Facades\Storage;  // Nos permite manipular sl storage 

class ProfileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpLoad()
    {
        Storage::fake('local');
        $response = $this->post('profile', [
            'photo'=> $photo = UploadedFile::fake()->image('photo.png')
        ]);

        Storage::disk('local')->assertExists("profiles/{$photo->hashName()}");
        //$this->assertTrue(Storage::disk('local')->exists($response));
        $response->assertRedirect('profile');
    }

    public function test_photo_required() 
    {
        $response = $this->post('profile', ['photo' => '']);
        
        $response->assertSessionHasErrors(['photo']);
    }
}