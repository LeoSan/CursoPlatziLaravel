<?php

namespace Tests\Feature\Http\Controllers\Repository;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable;

use App\Models\User; 
use App\Models\Repository; 

class RepositoryControllerTest extends TestCase
{

    use WithFaker, RefreshDatabase; 

    public function test_guest(){
        $this->get('repositories')->assertRedirect('login');        // index
        $this->get('repositories/1')->assertRedirect('login');      // show
        $this->get('repositories/1/edit')->assertRedirect('login'); // edit
        $this->put('repositories/1')->assertRedirect('login');      // update
        $this->delete('repositories/1')->assertRedirect('login');   // destroy
        $this->get('repositories/create')->assertRedirect('login'); // create
        $this->post('repositories', [])->assertRedirect('login');   // store
        //$response->assertStatus(200);
    }

    public function test_validate_store(){
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post('repositories', [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['url', 'description']);
    }

    public function test_validate_update(){
        $repository = Repository::factory()->create();
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->put("repositories/$repository->id", [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['url', 'description']);
    }  

    public function test_store(){
        
        //Tengo mi Data de Pruea
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,
        ];

        //Registro un usuario 
        $user = User::factory()->create();

        //Envio la información 
        $this->actingAs($user)//Me conecto como este usuario 
            ->post('repositories', $data)//Consulto Datos
            ->assertRedirect('repositories'); //Redirecciono para mostrar los datos

            $this->assertDatabaseHas('repositories', $data);//Valido si la data se almaceno en la base datos 

    }

    public function test_update(){

        //Creo un usuario 
        $user = User::factory()->create();        

        //Creado un repositorio 
        $repository = Repository::factory()->create(['user_id' => $user->id]);
        
        //Tengo mi Data de Pruea
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,
        ];

        //Envio la información 
        $this->actingAs($user)//Me conecto como este usuario 
            ->put("repositories/$repository->id", $data)//Actualizo datos de un repo en especifico 
            ->assertRedirect("repositories/$repository->id/edit"); //Redirecciono para mostrar los datos

            $this->assertDatabaseHas('repositories', $data);//Valido si la data se almaceno en la base datos 

    }     

    public function test_update_policy(){

        //Creo un usuario 
        $user = User::factory()->create();//id = 1

        //Creao un repositorio 
        $repository = Repository::factory()->create(); // user_id = 2
        
        //Tengo mi Data de Pruea
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,
        ];


        //Envio la información 
        $this->actingAs($user)//Me conecto como este usuario 
            ->put("repositories/$repository->id", $data)//Actualizo datos de un repo en especifico 
            ->assertStatus(403);
    }       
    
    public function test_destroy(){
        //Creo un usuario 
        $user = User::factory()->create();        

        //Creado un repositorio 
        $repository = Repository::factory()->create(['user_id' => $user->id]);
        

        $this
            ->actingAs($user)
            ->delete("repositories/$repository->id")
            ->assertRedirect('repositories');

        $this->assertDatabaseMissing('repositories', [
            'id' => $repository->id,
            'url' => $repository->url,
            'description' => $repository->description,
        ]);
    } 

    public function test_destroy_polity(){
        //Creo un usuario 
        $user = User::factory()->create();//id = 1

        //Creao un repositorio 
        $repository = Repository::factory()->create(); // user_id = 2

        $this
            ->actingAs($user)
            ->delete("repositories/$repository->id")//Actualizo datos de un repo en especifico 
            ->assertStatus(403);
    }     

    public function test_index_empty()
    {
        Repository::factory()->create(); // user_id = 1

        $user = User::factory()->create(); // id = 2

        $this
            ->actingAs($user)
            ->get('repositories')
            ->assertStatus(200)//Valida si conecta a la vista-> si la vista no esta creada te genera error 500
            ->assertSee('No hay repositorios creados');
    }

    public function test_index_with_data()
    {
        $user = User::factory()->create(); // id = 1
        $repository = Repository::factory()->create(['user_id' => $user->id]); // user_id = 1

        $this
            ->actingAs($user)
            ->get('repositories')
            ->assertStatus(200)//Valida si conecta a la vista-> si la vista no esta creada te genera error 500
            ->assertSee($repository->id)
            ->assertSee($repository->url);
    }


    //show 

    public function test_show()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $this
            ->actingAs($user)
            ->get("repositories/$repository->id")
            ->assertStatus(200);//Valida si conecta a la vista-> si la vista no esta creada te genera error 500
    }

    public function test_show_policy()
    {
        $user = User::factory()->create(); // id = 1
        $repository = Repository::factory()->create(); // user_id = 2

        $this
            ->actingAs($user)
            ->get("repositories/$repository->id")
            ->assertStatus(403);
    }    
    
    
    public function test_edit()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $this
            ->actingAs($user)
            ->get("repositories/$repository->id/edit")//Vamos a la ruta
            ->assertStatus(200)//Valida si conecta a la vista-> si la vista no esta creada te genera error 500
            ->assertSee($repository->url)
            ->assertSee($repository->description);
    }

    public function test_edit_policy()
    {
        $user = User::factory()->create(); // id = 1
        $repository = Repository::factory()->create(); // user_id = 2

        $this
            ->actingAs($user)
            ->get("repositories/$repository->id/edit")
            ->assertStatus(403);
    }


    public function test_create()
    {
        $user = User::factory()->create();
        
        $this->withoutExceptionHandling();//Sin hay alguna Exception la deja pasar de lo contrario usamos  withExceptionHandling 

        $this
            ->actingAs($user)
            ->get('repositories/create')//Vamos a la ruta
            ->assertSee('Repositorios')//Valido titulo del form
            ->assertSee('URL')//Valido label primer campo 
            ->assertSee('Descripción')//Valido label segundo campo 
            ->assertSee('Guardar')//Valido nombre del boton 
            ->assertStatus(200);//Valida si conecta a la vista-> si la vista no esta creada te genera error 500
    }    
 


}
