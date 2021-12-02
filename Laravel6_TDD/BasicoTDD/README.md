# Curso de Desarrollo en Laravel con Test Driven Development 02/11/2021 

<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></p>

## Clase 1: Todo lo que aprenderás sobre TDD en Laravel
- Ciclo Desarrollo Una prueba. 
- Deasarrollo un código. 
- Valido si ese código esta bien. 

## Clase 2: Proyecto desarrollado con TDD
- Se muestra lo que vamos a crear 

## Clase 3: Configuración Inicial del proyecto
Ejecutamos los siguiente comandos: Usaremos laravel con **jetstream:install livewire** para este ejemplo 
- Paso 1: `composer create-project --prefer-dist laravel/laravel BasicoTDD` cd  BasicoTDD->nombre del proyecto 
- Paso 2: `composer require laravel/jetstream` 
- Paso 3: `php artisan jetstream:install livewire`
- Paso 4: `npm install && npm run dev`
- Paso 5: Valido si se intalo bien. 

> Claro como buen dato hay que estudiar todos los metodos que permite usar el http-test ->  [Metodos Test](https://laravel.com/docs/8.x/http-tests)  <- 

> Notas  [For convenience, the CSRF middleware is automatically disabled when running tests.]

![Aqui valido instalación correcta](./info/Valido_Se_instalo_Bien.png)

## Clase 4:  Relaciones: múltiples 

Creamos nuestra primera prueba test usando el comando: 
- `php artisan make:test Models/UserTest --unit` 
- Creamos el modelo repositorio `php artisan make:model Repository -mf`

> Nota: Cambiamos la clase debido que Laravel ya utiliza PHPUnit en su sistema de testing, pero además le añade cierta configuración y métodos que hace mucho más óptimo el testeo. Fíjate que hay dos maneras de testear, una es ejecutando vendor/bin/phpunit y la otra es php artisan test. Nosotros utilizamos php artisan test y es por eso que cambiamos la clase, para obtener toda la configuración optimizada que nos provee Laravel. {by Gabriel Rodriguez, Hace 9 Meses}

```
<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class UserTest extends TestCase
{
    public function test_has_many_repositorios(){

        $user= new User; 
        Self::assertInstanceOf(Collection::class, $user->repositories);
    }
}

```

## Clase 5: Relaciones: pertenencia

Creamos la segunda prueba del modelo de repositorio. Ejecutando el siguiente comando: 
`php artisan make:test Models/RepositoryTest --unit`

Este test es para generar relaciones entre dos modelos aqui le indicamos que un repository pertenece a un usuario. **belongTo**

```
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

```


## Clase 6: Proteger rutas Test 

>Es importante resaltar que si instalamos sanctum, podemos usar sus middleware para validar y proteger nuestras rutas. Est

>En esta practica es un ejemplo de como hacer un test para poder validar rutas. 

```
<?php

namespace Tests\Feature\Http\Controllers\Repository;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepositoryControllerTest extends TestCase
{

    public function test_guest()
    {
        $this->get('repositories')->assertRedirect('login');// Index -> Valida que exista el repositories, si esta No esta login, valida que lo redireccione a login 
        $this->get('repositories/1')->assertRedirect('login');//Show ->Valida que exista el repositories, si esta No esta login, valida que lo redireccione a login 
        $this->get('repositories/1/edit')->assertRedirect('login');//Edit->Valida que exista el repositories, si esta No esta login, valida que lo redireccione a login 
        $this->put('repositories/1')->assertRedirect('login');//Update->Valida que exista el repositories, si esta No esta login, valida que lo redireccione a login 
        $this->delete('repositories/1')->assertRedirect('login');//Destroy-> Valida que exista el repositories, si esta No esta login, valida que lo redireccione a login 
        $this->post('repositories/create')->assertRedirect('login');//Crear-> Valida que exista el repositories, si esta No esta login, valida que lo redireccione a login 
        $this->post('repositories', [])->assertRedirect('login');//Gaurdar-> Valida que exista el repositories, si esta No esta login, valida que lo redireccione a login 

        //$response->assertStatus(200);
    }
}

```

## Clase 7: Nuevo registro Test 

> Lo que queremos hacer: 

`
Enviar HTTP-Post creando nuevo usuario, validar la redirección y validar su presencia en la base de datos
`
```
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

            Self::assertDatabaseHas('repositories', $data);//Valido si la data se almaceno en la base datos 

    }
```

## Clase 8: Actualizar registro Test 
> Lo que queremos hacer: 

`
Enviar HTTP-PUT creando nuevo usuario, validar la redirección y validar su presencia en la base de datos
`

> El test está ahí para ayudarnos a corregir esos errores que tenemos en nuestros códigos, sin embargo, siempre está bien prevenirlos, por eso recomiendo mucho que instalen la extensión `PHPIntelliSense`  y la extensión `PHPIntellephense` para Visual Studio Code, ya que con esa dos extensiones se pueden poner los use de forma automática y así te olvidas de tener que importarlos 😄

```

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
```


## Clase 9: Validación Test 

> Se aprenderá en cuales son los metodos recomendados para realizar validaciones de as validaciones en nustro test. XD `assertStatus` y el `assertSessionHasErrors`

```
    public function test_validate_store()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post('repositories', [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['url', 'description']);
    }

    public function test_validate_update()
    {
        $repository = Repository::factory()->create();
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->put("repositories/$repository->id", [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['url', 'description']);
    }  
```

## Clase 10: Eliminar registro Test 

> Que es lo que queremos hacer para el test -> `assertDatabaseMissing `

```
    public function test_destroy()
    {
        $repository = Repository::factory()->create();

        $user = User::factory()->create();

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

```

## Clase 11:  Proteger: actualizar

> Politicas de accesos, en path queremos hacer este test manejando que un solo usuario pueda acceder a sus accedos 

```
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
``` 

## Clase 12:  Proteger: eliminar

> Debemos aplicar politica de acceso al eliminar un repositorio esto es como logica de negocio 

```

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

```
## Clase 13:  Listado personal test 

> Otros métodos que pueden usar para extra afirmación son el assertViewIs() y assertViewHas()


> Si están utilizando vue para mostrar los datos $response->assertSee() no les funcionará lo de que muestre , ya que este función lee la vista cruda sin ser compliado por JavaScript.

> En el caso para validar si esta vació pueden utilizar la siguiente afirmación, el cual valida que vue tenga vacia la variable repositories.

` Para Vue
$response->assertSee(htmlspecialchars_decode('repositories&quot;:[]'));
` 

```
    public function test_index_empty()
    {
        Repository::factory()->create(); // user_id = 1

        $user = User::factory()->create(); // id = 2

        $this
            ->actingAs($user)
            ->get('repositories')
            ->assertStatus(200)
            ->assertSee('No hay repositorios creados');
    }

    public function test_index_with_data()
    {
        $user = User::factory()->create(); // id = 1
        $repository = Repository::factory()->create(['user_id' => $user->id]); // user_id = 1

        $this
            ->actingAs($user)
            ->get('repositories')
            ->assertStatus(200)
            ->assertSee($repository->id)
            ->assertSee($repository->url);
    }
```

## Clase 14: Ver registro individual test 

> Esto es como modelo de negocio para el show solo muestro lo que le pertenece al usuario 

```
    public function test_show()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $this
            ->actingAs($user)
            ->get("repositories/$repository->id")
            ->assertStatus(200);
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
 
```

## Clase 15: Formulario de edición Test

```
  public function test_edit()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $this
            ->actingAs($user)
            ->get("repositories/$repository->id/edit")
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
 
```


## Clase 16: Formulario de creación Test

> Deseamos crear un test que haga lo siguiente: Como usuario nos dirigimos a la ruta de creación del modelo Repositorio y obtenemos status 200. Para que pase el test hay que crear el método create en el Controller y luego la vista que pide le método. 

```


    public function test_create()
    {
        $user = User::factory()->create();
        
        $this->withoutExceptionHandling();//Sin hay alguna Exception la deja pasar de lo contrario usamos  withExceptionHandling 

        $this
            ->actingAs($user)
            ->get('repositories/create')//Vamos a la ruta
            ->assertSee('Repositorios')//Valido titulo del form
            ->assertSee('URL')//Valido label primer campo 
            ->assertSee('Description')//Valido label segundo campo 
            ->assertSee('Crear')//Valido nombre del boton 
            ->assertStatus(200);//Valida si conecta a la vista-> si la vista no esta creada te genera error 500
    }    
 


```

## Clase 17: Área pública Test 

> Se desea generar un test para el área publica. creamos otra clase tipo test pero page 

```

<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; 
use App\Models\Repository; 

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_home()
    {
      $repository = Repository::factory()->create();
  
      $this
        ->get('/')
        ->assertStatus(200)
        ->assertSee($repository->url);//Quiero visualizaar dicho dato
    }
}


```


## Clase 18: Mejoramos el welcome 

```
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body class="bg-gray-200">
        <ul class="max-w-lg bg-white border-r border-gray-300 shadow-xl">
            @foreach($repositories as $repository)
            <li class="flex items-center text-black p-2 hover:bg-gray-300">
                <img 
                    src="{{ $repository->user->profile_photo_url }}" 
                    class="w-12 h-12 rounded-full mr-2"
                >
                <div class="flex justify-between w-full">
                    <div class="flex-1">
                        <h2 class="text-sm font-semibold texti-back">{{ $repository->url }}</h2>
                        <p>{{ $repository->description }}</p>
                    </div>
                    <span class="text-xs font-medium text-gray-600">{{ $repository->created_at }}</span>
                </div>
            </li>
            @endforeach
        </ul>
    </body>
</html>

```

## Clase 19: 

> Ya en un proyecto muy grande pueden darle un vistazo a la documentación de Faker para tener datos mas variados.
> https://github.com/fzaninotto/Faker 


## Clase 20: Validación de datos Test 
> Podemos generar una clase para las validaciones esta la podemos crear con el siguiente comando `php artisan make:request RepositoryRequest`


>Cualquier request que sea enviado hacia el controlador que esté usando este Form Request será validado, Laravel se encarga de eso 😄

## Clase 21:  Políticas de acceso

> Es una forma de crear politicas  crear venajas en los fragmentos de los modelos de negocio 

- Paso 1: podemos generar politicas usando el siguiente comando `php artisan make:policy epositoryPolicy`
- Paso 2: Debemos ajustar en este archivo `app\Providers\AuthServiceProvider.php` incluir el modelo que contendra la politica 
- Paso 3: 
  ```
      protected $policies = [
         //'App\Models\Model' => 'App\Policies\ModelPolicy',
         'App\Models\Repository' => 'App\Policies\RepositoryPolicy',//Meto los modelos que deseo meter en la politica
    ];
  
  ```  
- Paso 4: En el controlador debemos usar esta linea `$this->authorize('pass', $repository);` como nueva politica 