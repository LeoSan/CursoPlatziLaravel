# Como parte de Mejoras y actualizaciones de PHP  iniciamos Laravel 10 

# Indice 
## Lista de Comandos Utiles 
## Rutas 
## Controladores 
## Vistas 
## Blade template 
## Migraciones 
## Querry Builder
## Introducción Eloquent 
## Relaciones Eloquent
## Formularios 
## Kit de inicio  
## Solicitudes HTTP
## Validaciones 



# Lista de Comandos Utiles 

**Pasos para instalacción**
**Comando para Instalar Laravel 10**
- instalar laravel -> `composer global require laravel/installer`
- composer create-project laravel/laravel laravel-app "10.*"
- `laravel -v` -> Laravel Installer 4.5.0
- `laravel new example-app`  -> forma mas rapida de instalar laravel 
**Comando resaltantes para Laravel 10**
- composer create-project laravel/laravel nombreProyecto "10.*"
- composer require laravel/breeze --dev `<opcional>`-> Ya viene con ciertos componentes para realizar el login  
**Sigue estos pasos en caso de atualizar composer**
- En windows Se debe instalr el `Composer-Setup.exe`
- Ejecutar los siguientes comandos
	- `composer clearcache`
	- `composer update`
	- `composer selfupdate`
	- `composer dump-autoload`
**Sigue estos pasos en caso de usar breeze**
- php artisan breeze:install -> 
**flujo normal**
- php artisan key:generate 
- php artisan migrate:refresh --seed
- php artisan migrate --seed
- npm install 
- npm run dev 


**Comandos Linux**
- whoami
- whoami /all /fo list 



## Comandos Artisan - 

**Tips Listas Route**
- php artisan r:l -> Lista las router de manera mas corta 
- php artisan r:l --path=cursos -> Lista las router de manera mas corta 
- php artisan r:l --except-vendor -> me trae las rutas menos las que fueron instaladas por algun paquete 
- php artisan r:l --except-vendor -v -> me trae las rutas menos las que fueron instaladas por algun paquete y a parte me trae los nombre de los middleware 
- php artisan r:l --only-vendor -v -> me trae las rutas de paquetes
- php artisan route:clear	 -> limpiamos cache 
- php artisan route:cache -> Solo hacerlo en producción 



**Comandos de Make**
- `php artisan make:controller UserController` -> Crea un controlador 
- `php artisan make:controller PhotoController --resource` -> crea controlador y sus rutas en total son 7 metodos, [index, show, update, create, destroy, patch, put]
- `php artisan make:provider NombreEjemplo` -> Crear Provider 

**Comandos View**
- php artisan view:clear

**Comandos Blade Paginacion**
- php artisan vendor:publish --tag=laravel-pagination


# Rutas 
**Concepto**
- Recuerda que laravel maneja las  rutas de manera eficiente en diferentes rutas y estas se ecnuentra en el directorio 
- web.php -> controlas las rutas de tus paginas web
- api.php -> controla las rutas de tus Apis 

```
Route::get('/', function () {
    return view('welcome');
});
Route::get('/contacto', function () {
    return "hola desde la página de contacto";
});

//Nota cuida el orden y la jerarquia
Route::get('/cursos/informacion', function () {
    return "Aquí podras encontrar toda la información de los cursos";
});

//Como pasar Parametros
Route::get('/cursos/{curso}', function ($curso) {
    return "Bienvenido al".$curso;
});

// ? -> Esto esto permite que sea opcional
// whereAlpha -> Metodo que maneja la clase Route, permite validar las entradas solo deben ser whereAlpha
// whereAlphaNumeric ->
// Agregarlo de manera Global -> app/Providers/RouteServiceProvider.php  Anexar este valor lo convierte en generico `Route::pattern('id', '[0-9]+');`
Route::get('/cursos/{curso}/{category?}', function ($curso, $category = null) {
    if($category){
        return "Bienvenido al curso:$curso de la categoria:$category";
    }else{
        return "Bienvenido al curso:$curso";
    }
})->whereAlphaNumeric('curso');

```


# Controladores 

## 24. Qué es el modelo vista controlador (MVC)
**Concepto**
- El modelo representa los datos y la lógica de negocio de la aplicación, como la validación y la manipulación de datos. La vista es la representación visual de la información que se muestra al usuario, como las páginas HTML y las interfaces de usuario. El controlador actúa como intermediario entre el modelo y la vista, y maneja las solicitudes del usuario y la lógica de negocio correspondiente.
- En Laravel 10, el patrón MVC se implementa mediante la creación de modelos, vistas y controladores separados en su propio directorio dentro de la estructura de la aplicación. El modelo se define en una clase que representa una tabla de base de datos y se usa para realizar operaciones de base de datos como la creación, lectura, actualización y eliminación (CRUD) de datos. La vista se define en un archivo de plantilla que utiliza sintaxis de Laravel Blade para renderizar la interfaz de usuario. El controlador se define en una clase que maneja las solicitudes del usuario y se comunica con el modelo y la vista correspondientes.
- En general, el patrón MVC es una forma efectiva de estructurar una aplicación web y mantener la separación de responsabilidades. Laravel 10 hace que la implementación del patrón MVC sea sencilla y eficiente, lo que lo convierte en una buena opción para desarrollar aplicaciones web de manera rápida y efectiva.

## 25. Controladores

**Concepto**
- Al crear su aplicación en Laravel, puede generar fácilmente controladores con el comando make:controller. 
- Por defecto, los controladores se almacenan en el directorio app/Http/Controllers. 
- Por ejemplo, para crear un controlador UserController, puede ejecutar el siguiente comando:

**Pasos**
- Ejecutar este comando para crear controlador `php artisan make:controller UserController` 
- Un controlador puede contener cualquier número de métodos públicos que respondan a las solicitudes HTTP entrantes. 
- Por ejemplo, la siguiente clase UserController tiene un método show que muestra el perfil de usuario:
```
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
   /**
    * Muestra el perfil de un usuario dado.
    */
   public function show(string $id): View
   {
       return view('user.profile', [
           'user' => User::findOrFail($id)
       ]);
   }
}
```
- Después de definir los métodos de su controlador, puede agregar una ruta que apunte a un método de controlador de la 
siguiente manera:

```
use App\Http\Controllers\UserController;

Route::get('/user/{id}', [UserController::class, 'show']);
```
- Cuando una solicitud HTTP entrante coincide con la URI de la ruta especificada, se invoca el método show de la clase UserController y los parámetros de ruta se pasan al método. 
- Para aprovechar al máximo sus controladores, asegúrese de seguir las convenciones de nomenclatura de Laravel y use los verbos HTTP adecuados para cada ruta.

## 26. Route Resource

**Concepto**
- En Laravel, el enrutamiento de recursos permite asignar las rutas típicas de creación, lectura, actualización y eliminación ("CRUD") a un controlador con una sola línea de código. Para ello, se puede utilizar el comando make:controller del Artisan junto con la opción --resource para crear rápidamente un controlador que maneje estas acciones.
- Por ejemplo, al ejecutar el siguiente comando se generará un controlador llamado PhotoController en app/Http/Controllers con métodos stub para cada una de las operaciones de recursos disponibles:

**Pasos**
- `php artisan make:controller PhotoController --resource`
- Luego, se puede registrar una ruta de recursos en el archivo routes/web.php que apunte al controlador recién creado de la siguiente manera:
```
use App\Http\Controllers\PhotoController;

Route::resource('photos', PhotoController::class);
```
- Con esta única declaración de ruta se crean múltiples rutas para manejar una variedad de acciones en el recurso. 
Además, se puede registrar muchos controladores de recursos a la vez pasando una matriz al método resources() de la siguiente manera:

```
Route::resources([
   'photos' => PhotoController::class,
   'posts' => PostController::class,
]);

//en caso que requiremos pocas rutas usando el metodo only 
Route::resources([
   'photos' => PhotoController::class,
   'posts' => PostController::class,
])->only(['index', 'show']);

Route::resources([
   'photos' => PhotoController::class,
   'posts' => PostController::class,
])->except(['index', 'show']);


```

- Por último, siempre es recomendable ejecutar el comando route:list del Artisan para obtener una descripción general rápida de las rutas de la aplicación.

## 27. Invoke

**Concepto**
- En algunas ocasiones, la lógica de una acción en particular puede ser lo suficientemente compleja como para justificar la creación de un controlador completo para esa acción en particular. 
- En estos casos, Laravel permite crear controladores de acción única.

**Pasos**
- Para crear un controlador de acción única en Laravel, se debe definir el método `__invoke` dentro del controlador. 
- Este método se ejecutará cuando se llame a la acción. 
- A continuación, se muestra un ejemplo de un controlador de acción única para provisionar un nuevo servidor web:
```
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;

class ProvisionServer extends Controller
{
   /**
    * Provision a new web server.
    */
   public function __invoke()
   {
       // ...
   }
}
```
- Para registrar una ruta para un controlador de acción única, se debe pasar el nombre del controlador al enrutador, sin especificar el nombre del método. 
- Por ejemplo:
```
use App\Http\Controllers\ProvisionServer;

Route::post('/server', ProvisionServer::class);
```
- También se puede generar un controlador de acción única usando el comando Artisan make:controller con la opción --invokable:
- `php artisan make:controller ProvisionServer --invokable`
- De esta manera, Laravel permite una mayor flexibilidad en la organización de los controladores y la lógica de las acciones en una aplicación web.

## 28. Grupo de rutas
**Concepto**
 - Los grupos de rutas en Laravel son una herramienta poderosa para compartir atributos de ruta, como el middleware, entre un conjunto de rutas, lo que evita tener que definir estos atributos en cada ruta individual. 
 - Además, los grupos anidados pueden fusionar de forma inteligente los atributos con su grupo principal, incluyendo middleware y condiciones "where", mientras que agregan nombres y prefijos automáticamente.
 
**Pasos**
- Por ejemplo, para asignar middleware a todas las rutas dentro de un grupo, simplemente usa el método middleware antes de definir el grupo. 
- El middleware se ejecuta en el orden en que aparecen en la matriz:
```
Route::middleware(['first', 'second'])->group(function () {
    Route::get('/', function () {
        // Usa los middlewares first y second...
    });
 
    Route::get('/user/profile', function () {
        // Usa los middlewares first y second...
    });
});

```
- También puedes definir un controlador común para todas las rutas dentro de un grupo usando el método controller:
```
use App\Http\Controllers\OrderController;

Route::controller(OrderController::class)->group(function () {
    Route::get('/orders/{id}', 'show');
    Route::post('/orders', 'store');
});
```
- Además, los grupos de rutas también se pueden usar para manejar el enrutamiento de subdominios. 
- A los subdominios se les pueden asignar parámetros de ruta, lo que le permite capturar una parte del subdominio para usar en su ruta o controlador. Para hacer esto, llama al método domain antes de definir el grupo:
```
Route::domain('{account}.example.com')->group(function () {
    Route::get('user/{id}', function (string $account, string $id) {
        // ...
    });
});
```
- El método prefix se puede usar para prefijar cada ruta en el grupo con un URI determinado, por ejemplo, puedes prefijar todos los URI de ruta dentro del grupo con "admin":
```
Route::prefix('admin')->group(function () {
    Route::get('/users', function () {
        // Coincide con la URL "/admin/users"
    });
});
```
- Finalmente, el método name se puede usar para prefijar cada nombre de ruta en el grupo con una cadena dada. 
- Esto es útil para, por ejemplo, anteponer los nombres de todas las rutas del grupo con "admin":
```
Route::name('admin.')->group(function () {
    Route::get('/users', function () {
        // Asigna el nombre de ruta "admin.users"...
    })->name('users');
});
```

# Vistas


## 29. Vistas ¿Qué son y cómo funcionan?


```
Además, exploraremos algunos de los conceptos clave detrás de las vistas en Laravel 10. Descubrirás cómo las vistas te permiten separar la lógica de presentación de la lógica de negocio de tu aplicación y cómo puedes utilizarlas para mejorar la legibilidad del código. También te mostraremos algunos ejemplos prácticos de cómo puedes utilizar las vistas en tus proyectos de Laravel.
```
**Tip**
- Directivas `@if(Route::has('login'))`
- Directivas `{{url('/home')}}`
- Directivas `{{route('/home')}}`
- @auth -> solo lo muestra con usuarios auteitcados 
- como llamarlas ` return view('nombreRuta name ')`

## 30. Pasar parámetros a vistas
> Dentro de laravel podemos enviar valores individuales o como arreglos podemos usar el metodo view para esto: 

**Recordar**
- compact es un método de php no de laravel 
- Recuerda que el compact no se necesita colocar elsimbolo ($) dolar de la variable 

```
public function show($post){

	return view('post.view', [
	'post'=>$post
	]);
	
}

// ó 
public function show($post){
	$hola='Hola mundo';
	return view('post.view', compact('post', 'hola'));
}

```

## 31. Pasar parámetros a todas las vistas

**Concepto**
- A veces, es necesario compartir datos con todas las vistas generadas por su aplicación. 
- Para hacer esto, puede utilizar el método share de la fachada View. 
- Por lo general, debe realizar llamadas al método share dentro del método boot de un proveedor de servicios. 
- Puede agregarlos a la clase App\Providers\AppServiceProvider o generar un proveedor de servicios separado para alojarlos.

**Paso**
- Aquí hay un ejemplo de cómo compartir datos en el proveedor de servicios AppServiceProvider:

```
namespace App\Providers;

use Illuminate\Support\Facades\View; // Paso 1
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // ...
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::share('key', 'value'); //// Paso 2
    }
}
```

- Como usarla 
```
{{$key}}
```

**Resumen**
- En este ejemplo, la clave "key" se compartirá con todas las vistas generadas por su aplicación, y su valor será "value". 
- Puede acceder a estos datos en cualquier vista utilizando la sintaxis de la plantilla de Blade, como {{ $key }}.


## 32. Como crear y registrar un provider

**Concepto**
- Para escribir un proveedor de servicios en Laravel, debemos crear una nueva clase que implemente la Illuminate\Support\ServiceProvider interfaz. 
- Esta interfaz define dos métodos que debemos implementar: register() y boot().
- El método **register()** se usa para enlazar cosas en el contenedor de servicios de Laravel. 
- Por ejemplo, podemos enlazar una instancia de una clase en el contenedor, lo que nos permitirá acceder a esa instancia en cualquier lugar de nuestra aplicación.
- El método **boot()** se usa para realizar cualquier configuración que deba hacerse después de que se hayan registrado los enlaces del contenedor. 
- Esto podría incluir la definición de rutas, la publicación de activos o la configuración de middleware.
- Para registrar un proveedor de servicios con nuestra aplicación Laravel, debemos agregar la clase del proveedor a la providersmatriz en el config/app.phparchivo. 
- Luego, cada vez que nuestra aplicación se inicie, se llamará automáticamente al register() y boot() métodos en nuestra clase de proveedor.
- En resumen, los proveedores de servicios son una forma poderosa de extender y personalizar su aplicación Laravel. Al escribir sus propios proveedores de servicios, puede enlazar sus propias clases en el contenedor de servicios y realizar cualquier configuración necesaria para su aplicación.

**Comandos para crear**
- `php artisan make:provider NombreEjemplo->ViewServiceProvider`

## 33. View Composer

**Concepto**

- View Composer es una herramienta poderosa en Laravel 10 que permite definir la lógica de presentación en una ubicación centralizada y reutilizable. 
- En lugar de definir la lógica de presentación en cada controlador individualmente, View Composer te permite definirla una vez y utilizarla en múltiples vistas.
- Para utilizar View Composer en Laravel 10, primero debes crear una clase de View Composer que implemente el método 'composeIlluminate\View\View como su único argumento y te permite manipular la vista antes de que se muestre al usuario.
- Una vez que hayas creado la clase View Composer, debes registrarla en el método boot de un proveedor de servicios. 
- Dentro de este método, puedes utilizar el método 'composercomposer de la clase View para registrar la clase View Composer para una vista específica o para todas las vistas que utilizan un cierto layout.

**Pasos**
- Por ejemplo, si deseas definir la lógica de presentación para la vista de inicio de tu aplicación, puedes crear un View Composer llamado 'HomeComposer y registrarlo en un proveedor de servicios de la siguiente manera:

```
View::composer('home', HomeComposer::class);
```
- Esto definirá la lógica de presentación para la vista de inicio de tu aplicación en la clase HomeComposer.

**Resumen**
- En resumen, View Composer es una herramienta útil en Laravel 10 que permite definir la lógica de presentación en una ubicación centralizada y reutilizable. 
- Con la capacidad de definir la lógica de presentación una vez y utilizarla en múltiples vistas, View Composer puede mejorar la estructura y la organización del código. 
- Al crear una clase View Composer y registrarla en un proveedor de servicios, se puede definir la lógica de presentación para una vista específica o para todas las vistas que utilizan un cierto layout.


**Recomendaciones**
- Paso 1 desde la app genera un nuevo directorio llamandolo `View`
- Paso 2 Genera otro directorio llamado `Composers`
- Paso 3: Generamos una clase llamada PostComposer.php -> Post es el nombre que manejara tu vista en este caso es un CRUD para un  Post 

```

 <?php
 
 namespace App\View\Composers //-> Este es tu ame de tu directorio 
 use Illuminate\View\View; 
 
 class PostComposer{
 
	public function compose(View $view){
		$view->with('variable', 'Esto es una prueba de variable');
	}
	
 }
```
- Paso 4: conque vistas quremos compartir esta variable debemos vincularlo con un provider podemos crearlo o anexarlo a los que existen 
- Paso 5: ubicamos el provider para este ejemplo usamos `AppServiceProvider` y en el metodo boot anexamos lo siguiente 
```
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Description: me permite usar el paginador de boostrap 5, ya que por defecto usa los css de tailwindcss
         *
         */
        Paginator::useBootstrapFive();
		
		view::composer([
			'post.create', //Nombre de tus vistas creadas en el web.php 
			'post.edit', //Nombre de tus vistas creadas en el web.php 
			'post.show', //Nombre de tus vistas creadas en el web.php 
		], PostComposer::class);
		
		//ó para hacerlo de manera general  el (*) le identificamos que desde post cualquier elemento puede acceder a esta variable 
		view::composer('post.*', PostComposer::class);
		
		
    }
}

```
- Paso 6: ya solo queda imprimirlo en tu view de resourse de la manera simple ejemplo: 

```
echo  $variable; 

{{$variable}}

```


# Blade template 

## 34. Visualización de datos

**Concepto**
- En Laravel, es posible mostrar los datos que se pasan a las vistas de Blade mediante el uso de llaves dobles. 
- Por ejemplo, si se tiene la siguiente ruta y se desea mostrar el contenido de la variable 'name' en la vista 'welcome':

**Pasos**
```
Route::get('/', function () {
    return view('welcome', ['name' => 'Samantha']);
});

```
- Se puede mostrar el contenido de la variable 'name' en la vista usando la sintaxis de llaves dobles de Blade:

```
Hello, {{ $name }}.
```

- Sin embargo, Blade no está limitado a mostrar solo variables. 
- También se puede utilizar para mostrar los resultados de cualquier función de PHP. 
- Por ejemplo, para mostrar la marca de tiempo UNIX actual en la vista, se puede utilizar el siguiente código:
```
The current UNIX timestamp is {{ time() }}.
```

- De esta manera, se puede utilizar Blade para mostrar cualquier tipo de contenido en las vistas de Laravel.
- Por defecto, las declaraciones de Blade se envían automáticamente a través de la función PHP htmlspecialchars para evitar ataques XSS al mostrar contenido en las vistas de Laravel. 
- Sin embargo, si por alguna razón desea imprimir contenido sin escapar, Blade también proporciona una sintaxis especial para eso.

**Resumen**
- En lugar de usar llaves dobles, puede utilizar llaves de exclamación para que Blade no escape el contenido. 
- Por ejemplo, para imprimir el contenido de la variable 'name' sin escapar, se puede utilizar la siguiente sintaxis:
```
Hello, {!! $name !!}.
```

- Sin embargo, se recomienda usar la sintaxis de llaves dobles predeterminada de Blade para garantizar la seguridad de su aplicación. 
- Solo use la sintaxis de llaves de exclamación si tiene una buena razón para hacerlo y comprende los posibles riesgos de seguridad.


## 35. Marco Blade y Javascript

**Concepto**
- Cuando se trabaja con marcos de JavaScript junto con Blade, puede haber un conflicto en el uso de llaves rizadas para indicar una expresión que debe ser mostrada en el navegador. 
- Para resolver esto, Blade proporciona la sintaxis del símbolo @ para informar al motor de renderizado que una expresión debe permanecer intacta.

**Pasos
- Por ejemplo, si se tiene la siguiente vista de Blade que usa llaves rizadas tanto para Blade como para el marco de JavaScript:
```
<h1>Laravel</h1>
Hello, {{ name }}.
```
- El motor de Blade procesará la expresión {{ name }}, lo que puede interferir con el marco de JavaScript. 
- Para evitar esto, se puede usar la sintaxis del símbolo @ para escapar la expresión de Blade:
```
<h1>Laravel</h1>
Hello, @{{ name }}.
```
- En este caso, Blade eliminará el símbolo @, pero la expresión {{ name }} permanecerá intacta, lo que permitirá que el marco de JavaScript la procese.
- Además, también se puede utilizar el símbolo @ para escapar de las directivas de Blade, como en el siguiente ejemplo:

```
{{-- Blade template --}}
@@if()
 
<!-- HTML output -->
@if()
De esta manera, se puede evitar que Blade procese una directiva y se puede imprimir la directiva sin procesar en la salida HTML.
```












































# Relaciones Eloquent 

## 96. Relación Uno a Uno


> Cuando trabajas con Laravel 10, es común necesitar establecer relaciones entre los modelos de la base de datos. Una de estas relaciones es la relación Uno a Uno, donde un registro de un modelo está relacionado con un solo registro de otro modelo. En este capítulo, aprenderás cómo establecer una relación Uno a Uno en Laravel 10 y cómo acceder a los datos relacionados.

> Para establecer una relación Uno a Uno en Laravel 10, debes definir dos modelos y una clave foránea en uno de ellos que haga referencia al otro modelo. Por ejemplo, supongamos que tienes dos modelos "Usuario" y "Perfil", donde cada usuario tiene un único perfil. En el modelo "Usuario", debes agregar la siguiente función para definir la relación:

```
//Proceso natural
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Usuario extends Model
{
   public function perfil()
   {
       return $this->hasOne(Perfil::class);
       //return $this->hasOne(Perfil::class, 'user_id', 'id'); //Recuerda que este metodo hasOne Recibe el nombre de la FK y el nombre de la PK, yo por lo general asi esten bien definido en base de datos prefiero si enviarlas por parametro como buena practica user_id es la forenkey de de profile y la Id es de usuario 
   }
}


//Proceso inverso 

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Perfil extends Model
{
   public function usuario()
   {
       return $this->belongsTo(Usuario::class);
       //return $this->belongsTo(Usuario::class, 'user_id', 'id'); // Recuerda que este metodo hasOne Recibe el nombre de la FK y el nombre de la PK, yo por lo general asi esten bien definido en base de datos prefiero si enviarlas por parametro como buena practica user_id es la forenkey de de profile y la Id es de usuario 
   }
}


$usuario = Usuario::find(1);
$perfil = $usuario->perfil;

$perfil = Perfil::find(1);
$usuario = $perfil->usuario;
```


## 97. Relación Uno a Muchos

**Concepto**
- La relación Uno a Muchos es una de las más comunes en las bases de datos relacionales. 
- Se trata de una relación en la que un registro de una tabla (modelo) está relacionado con varios registros de otra tabla (modelo). En Laravel 10, puedes definir esta relación mediante el uso de métodos en los modelos correspondientes.

**Pasos**
- Para definir una relación Uno a Muchos en Laravel 10, debes establecer el método hasMany en el modelo que tiene varios registros relacionados con otro modelo que tiene solo un registro. 
- Este método acepta como argumento el nombre del modelo relacionado. Por ejemplo, si tienes un modelo User y un modelo Post, y cada usuario tiene varios posts, debes establecer el método hasMany en el modelo User de la siguiente manera:

``` 
class User extends Model
{
   public function posts()
   {
       return $this->hasMany(Post::class);
   }
}
```
- Una vez definida la relación, puedes acceder a los datos relacionados mediante el uso del método posts en una instancia del modelo User. Por ejemplo, si deseas obtener todos los posts de un usuario con un ID específico, puedes hacerlo de la siguiente manera:
```
$user = User::find(1);
$posts = $user->posts;
```

**En resumen**
- Si necesitas establecer una relación Uno a Muchos en Laravel 10, puedes hacerlo de manera sencilla mediante el uso del método hasMany en el modelo correspondiente. 
- Una vez definida la relación, puedes acceder a los datos relacionados mediante el uso de métodos en una instancia del modelo principal. Esperamos que esta información te haya sido útil en tu proyecto de Laravel 10.

## 98. Relación Muchos a Muchos

**Concepto**
- Si estás trabajando en un proyecto de Laravel 10 y necesitas establecer una relación Muchos a Muchos entre dos modelos de la base de datos, has llegado al lugar adecuado. 
- La relación Muchos a Muchos es una de las más comunes en las bases de datos relacionales, y se utiliza para modelar relaciones complejas entre diferentes entidades. 
- En Laravel 10, puedes definir esta relación mediante el uso de métodos en los modelos correspondientes.
- Para establecer una relación Muchos a Muchos en Laravel 10, debes crear una tabla de relación que contenga las claves foráneas de ambos modelos. 
- Es mas conoido como tablas pivotes estas deben tener una nomeclarura ejemplos si tenemos una tabla tag y una tabla courses su nombre es coourse_tag 
- A continuación, debes establecer los métodos belongsToMany en ambos modelos, especificando el nombre de la tabla de relación y los nombres de las columnas de las claves foráneas. 

**Pasos **
- Por ejemplo, si tienes un modelo User y un modelo Role, y cada usuario puede tener varios roles y cada rol puede pertenecer a varios usuarios, debes establecer los métodos belongsToMany en ambos modelos de la siguiente manera:

```
class User extends Model
{
   public function roles()
   {
       return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
   }
}
class Role extends Model
{
   public function users()
   {
       return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id'); // Modelo, nombre tabla, nombre llave foranea del modelo, nombre foraneo de la tabla 
   }
}
```
- Una vez definida la relación, puedes acceder a los datos relacionados mediante el uso de métodos en una instancia del modelo principal. Por ejemplo, si deseas obtener todos los roles de un usuario con un ID específico, puedes hacerlo de la siguiente manera:
```
$user = User::find(1);
$roles = $user->roles;
```

**En resumen**
- Si necesitas establecer una relación Muchos a Muchos en Laravel 10, debes crear una tabla de relación y establecer los métodos belongsToMany en ambos modelos correspondientes. 
- Una vez definida la relación, puedes acceder a los datos relacionados mediante el uso de métodos en una instancia del modelo principal. 

## 99. Relación Uno a Uno a través de

**Concepto**
- La relación Uno a Uno a través de se utiliza cuando tienes tres modelos relacionados entre sí, y quieres establecer una relación directa entre dos de ellos.
- En Laravel 10, puedes definir esta relación mediante el uso de métodos en los modelos correspondientes.

**Pasos **
- Para establecer una relación Uno a Uno a través de en Laravel 10, debes crear una tabla de relación que contenga las claves foráneas de ambos modelos, y establecer los métodos hasOneThrough en el modelo correspondiente. Por ejemplo, si tienes un modelo User, un modelo Country y un modelo City, y cada usuario tiene una ciudad y cada ciudad pertenece a un país, debes establecer el método hasOneThrough en el modelo User de la siguiente manera:
```
class User extends Model
{
   public function country()
   {
       return $this->hasOneThrough(Country::class, City::class, 'country_id', 'id', 'city_id');
   }
}
```
- En este ejemplo, el método hasOneThrough establece que la relación Uno a Uno a través de se establece entre el modelo User y el modelo Country, pasando por el modelo City. 
- Además, se especifica el nombre de las columnas de las claves foráneas.
- Una vez definida la relación, puedes acceder a los datos relacionados mediante el uso de métodos en una instancia del modelo principal. 
- Por ejemplo, si deseas obtener el país de un usuario con un ID específico, puedes hacerlo de la siguiente manera:

```
$user = User::find(1);
$country = $user->country;
```

**En resumen**
- Si necesitas establecer una relación Uno a Uno a través de en Laravel 10, debes crear una tabla de relación y establecer el método hasOneThrough en el modelo correspondiente. 
- Una vez definida la relación, puedes acceder a los datos relacionados mediante el uso de métodos en una instancia del modelo principal.


## 100. Relación Muchos a Muchos -> Ultra profundo


**Concepto**
- La relación Muchos a Muchos es una de las más comunes en las bases de datos relacionales, y se utiliza para modelar relaciones complejas entre diferentes entidades. 
- En Laravel 10, puedes definir esta relación mediante el uso de métodos en los modelos correspondientes.

**Pasos ** 
- Para establecer una relación Muchos a Muchos en Laravel 10, debes crear una tabla de relación que contenga las claves foráneas de ambos modelos. 
- A continuación, debes establecer los métodos belongsToMany en ambos modelos, especificando el nombre de la tabla de relación y los nombres de las columnas de las claves foráneas. 
- Por ejemplo, si tienes un modelo User y un modelo Role, y cada usuario puede tener varios roles y cada rol puede pertenecer a varios usuarios, debes establecer los métodos belongsToMany en ambos modelos de la siguiente manera:

```
class User extends Model
{
   public function roles()
   {
       return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
   }
}
class Role extends Model
{
   public function users()
   {
       return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id');
   }
}
```
- Una vez definida la relación, puedes acceder a los datos relacionados mediante el uso de métodos en una instancia del modelo principal. 
- Por ejemplo, si deseas obtener todos los roles de un usuario con un ID específico, puedes hacerlo de la siguiente manera:

```
$user = User::find(1);
$roles = $user->roles;
```

**En resumen**
- En resumen, si necesitas establecer una relación Muchos a Muchos en Laravel 10, debes crear una tabla de relación y establecer los métodos belongsToMany en ambos modelos correspondientes. 
- Una vez definida la relación, puedes acceder a los datos relacionados mediante el uso de métodos en una instancia del modelo principal. 


**Esto es en caso de usar tablas pivotes**

![Pivote](./info/info_001.png)

## 101. Relaciones Uno a Uno Polimórficas

**Concepto**
- Las relaciones Uno a Uno Polimórficas se utilizan cuando tienes varios modelos que necesitan estar relacionados con otro modelo de forma individual, en lugar de tener una relación directa. 
- En Laravel 10, puedes definir esta relación mediante el uso de métodos en los modelos correspondientes.

**Pasos ** 
- Para establecer una relación Uno a Uno Polimórfica en Laravel 10, debes crear una tabla de relación polimórfica que contenga las claves foráneas de ambos modelos, y establecer los métodos morphOne y morphTo en los modelos correspondientes. 
- Por ejemplo, si tienes un modelo Comment, un modelo Post y un modelo Video, y cada uno puede tener un único Comment, debes establecer los métodos de la siguiente manera:

```
class Comment extends Model
{
   public function commentable()
   {
       return $this->morphTo();
   }
}
class Post extends Model
{
   public function comment()
   {
       return $this->morphOne(Comment::class, 'commentable');
   }
}
class Video extends Model
{
   public function comment()
   {
       return $this->morphOne(Comment::class, 'commentable');
   }
}
```
- En este ejemplo, el método morphTo en el modelo Comment establece que la relación es polimórfica, y el método morphOne en los modelos Post y Video establece la relación Uno a Uno polimórfica entre el modelo Comment y el modelo correspondiente. 
- Además, se especifica el nombre de la columna que contiene el tipo de modelo y la clave foránea del modelo en la tabla de relación polimórfica.

Una vez definida la relación, puedes acceder a los datos relacionados mediante el uso de métodos en una instancia del modelo principal. 
- Por ejemplo, si deseas obtener el comentario de un post con un ID específico, puedes hacerlo de la siguiente manera:

```
$post = Post::find(1);
$comment = $post->comment;
```

**Usamos esta nomeclarura para generar las tablas poliformicas**

![Poliformica](./info/info_003.png)


**En resumen**
- En resumen, si necesitas establecer relaciones Uno a Uno Polimórficas en Laravel 10, debes crear una tabla de relación polimórfica y establecer los métodos morphOne y morphTo en los modelos correspondientes. 
- Una vez definida la relación, puedes acceder a los datos relacionados mediante el uso de métodos en una instancia del modelo principal. 

## 102. Relaciones Uno a Muchos Polimórficas

**Concepto**
- Las relaciones Uno a Muchos Polimórficas se utilizan cuando varios modelos necesitan estar relacionados con 
otro modelo de forma individual, y cada uno de ellos puede tener varios registros relacionados en la tabla de relación. 
- En Laravel 10, puedes definir esta relación mediante el uso de métodos en los modelos correspondientes.

**Pasos ** 
- Para establecer una relación Uno a Muchos Polimórfica en Laravel 10, debes crear una tabla de relación polimórfica que contenga las claves foráneas de ambos modelos, 
y establecer los métodos morphMany y morphTo en los modelos correspondientes. 
- Por ejemplo, si tienes un modelo Comment, un modelo Post y un modelo Video, y cada uno puede tener varios Comment, debes establecer los métodos de la siguiente manera:

```
class Comment extends Model
{
   public function commentable()
   {
       return $this->morphTo();
   }
}
class Post extends Model
{
   public function comments()
   {
       return $this->morphMany(Comment::class, 'commentable');
   }
}
class Video extends Model
{
   public function comments()
   {
       return $this->morphMany(Comment::class, 'commentable');
   }
}
```
- En este ejemplo, el método morphTo en el modelo Comment establece que la relación es polimórfica, 
y el método morphMany en los modelos Post y Video establece la relación Uno a Muchos Polimórfica 
entre el modelo Comment y el modelo correspondiente. 
- Además, se especifica el nombre de la columna que contiene el tipo de modelo y la clave foránea del modelo 
en la tabla de relación polimórfica.
- Una vez definida la relación, puedes acceder a los datos relacionados mediante el uso de métodos en una 
instancia del modelo principal. 
- Por ejemplo, si deseas obtener todos los comentarios de un video con un ID específico, puedes hacerlo 
de la siguiente manera:
```
$video = Video::find(1);
$comments = $video->comments;
```
**En resumen**
- En resumen, si necesitas establecer relaciones Uno a Muchos Polimórficas en Laravel 10, 
debes crear una tabla de relación polimórfica y establecer los métodos morphMany y morphTo en los modelos correspondientes. 
- Una vez definida la relación, puedes acceder a los datos relacionados mediante el uso de métodos en una instancia del modelo principal. 

![Tablas poliformicas](./info/info_004.png)

## 103. Relación Muchos a Muchos Polimórficas

**Pasos ** 
- Las relaciones Muchos a Muchos Polimórficas se utilizan cuando varios modelos necesitan estar relacionados con otro 
modelo de forma individual, y cada uno de ellos puede tener varios registros relacionados en la tabla de relación. 
- En Laravel 10, puedes definir esta relación mediante el uso de métodos en los modelos correspondientes.

**Pasos ** 
- Para establecer una relación Muchos a Muchos Polimórfica en Laravel 10, debes crear una tabla de relación polimórfica que contenga las claves foráneas de ambos modelos, y establecer los métodos morphToMany y morphedByMany en los modelos correspondientes. Por ejemplo, si tienes un modelo Tag, un modelo Post y un modelo Video, y cada uno puede tener varias etiquetas y varias etiquetas pueden estar relacionadas con varios modelos, debes establecer los métodos de la siguiente manera:
``` 
class Tag extends Model
{
   public function posts()
   {
       return $this->morphedByMany(Post::class, 'taggable');
   }
   public function videos()
   {
       return $this->morphedByMany(Video::class, 'taggable');
   }
}
class Post extends Model
{
   public function tags()
   {
       return $this->morphToMany(Tag::class, 'taggable');
   }
}
class Video extends Model
{
   public function tags()
   {
       return $this->morphToMany(Tag::class, 'taggable');
   }
}
```

- En este ejemplo, el método morphToMany en los modelos Post y Video establece la relación Muchos a Muchos Polimórfica entre el modelo Tag y el modelo correspondiente. 
- Además, se especifica el nombre de la columna que contiene el tipo de modelo y la clave foránea del modelo en la tabla de relación polimórfica. 
- Por otro lado, el método morphedByMany en el modelo Tag establece la relación Muchos a Muchos Polimórfica inversa entre el modelo Tag y el modelo correspondiente.
- Una vez definida la relación, puedes acceder a los datos relacionados mediante el uso de métodos en una instancia del modelo principal. 
- Por ejemplo, si deseas obtener todas las etiquetas de un video con un ID específico, puedes hacerlo de la siguiente manera:
```
$video = Video::find(1);
$tags = $video->tags;
```
**En resumen**
En resumen, si necesitas establecer relaciones Muchos a Muchos Polimórficas en Laravel 10, 
debes crear una tabla de relación polimórfica y establecer los métodos morphToMany y morphedByMany en los 
modelos correspondientes. 
- Una vez definida la relación, puedes acceder a los datos relacionados mediante el uso de métodos en una instancia 
del modelo principal.

![Tablas poliformicas](./info/info_005.png)

## 104. Seeders

**Concepto**
- Los seeders son una herramienta muy útil en Laravel para poblar tu base de datos con datos de prueba, 
lo que facilita el proceso de desarrollo y pruebas de tu aplicación. 
- Los seeders son clases de PHP que puedes utilizar para insertar datos en tu base de datos a través de una interfaz 
sencilla y programática.
- Por ejemplo, para crear un seeder para la tabla "users", puedes utilizar el siguiente comando:`php artisan make:seeder UsersTableSeeder` 
- Este comando creará un nuevo archivo de seeder en el directorio database/seeds.

**Pasos ** 
- Dentro de tu seeder, puedes utilizar el método DB::table() para interactuar con la tabla de base de datos correspondiente 
y utilizar el método insert() para insertar registros en la tabla. 
- Por ejemplo, para insertar un nuevo usuario en la tabla "users", puedes utilizar el siguiente código:

``` 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
   public function run()
   {
       DB::table('users')->insert([
           'name' => 'John Doe',
           'email' => 'johndoe@example.com',
           'password' => bcrypt('secret'),
       ]);
   }
}
```

- Una vez que hayas creado tus seeders, puedes utilizar el comando db:seed para ejecutarlos y poblar tu 
base de datos con datos de prueba. 
- Por ejemplo, para ejecutar el seeder UsersTableSeeder, puedes utilizar el siguiente comando:
```
php artisan db:seed --class=UsersTableSeeder
```
- También puedes utilizar el comando db:seed sin argumentos para ejecutar todos los seeders en tu aplicación.
- Además, es posible utilizar el comando make:factory para generar factories de modelos y así crear datos 
de prueba de manera automatizada. Luego, en los seeders, puedes utilizar estas factories para crear 
y relacionar modelos de manera rápida y sencilla.

**En resumen**
- En resumen, los seeders son una herramienta poderosa para poblar tu base de datos con datos de prueba en Laravel. 
- Al utilizarlos, puedes agilizar el proceso de desarrollo y pruebas de tu aplicación de manera significativa.

![Tablas](./info/info_006.png)

# Formularios

## 105. Agregar Navegabilidad 

> Recuerda que laravel ya podemos crear componentes de manera muy similar react podemos ejecutar el comando 
- `php artisan make:component DropdownMenu`
- Esto te genera una clase y una view vacia para que la puedas implementar en la clase podemos definir que parametros puede recibir
- y simplemente podemos llamar ese componente de esta manera `<x-dropdown-menu :items="$dropdownItems" />`
- Consejo recuerda que puedes usar href="{{route('nombre de tu ruta usando el ->name()')}}"
 

## 106 Formularios y protección CSRF
- Es importante resaltar que en laravel podemos usar `CSRF` para que los formularios esten protegidos 
- Se genera un token este laravel lo administra en tiempo de expiración y de rutado 
- Esto es simple solo se coloca @csrf y laravel genera un campo typo hidden y le anexa un _token y este lo adminitra
- Tiene un tiempo de vida de 20 min mustra la pagina personalizada de laravel llamada 409 pafe expiro 
- esto lo implementa eloquent para garantizar seguridad en formularios 
**Ejemplo**
```
 <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <form id="form_1" class="form-air" autocomplete="off" accept-charset="UTF-8" >
                @csrf
                    <div class="row mb-3">
                        <div class="form-group col-md-4 mt-2">
                            <label for="selOrigen" class="form-label">Origen de la denuncia </label>
                            <select id="selOrigen" name="origen_id" class="form-select" aria-label="Seleccionar Origen Denuncia"  required>
                                <option value="" selected>Seleccione</option>
                                <option value="1">Sindicato</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 mt-2">
                            &nbsp;
                        </div>
                        <div class="form-group col-md-4 mt-2">
                            &nbsp;
                        </div>
                    </div>
```

**Notas**
- Podemos redireccionar de la siguiente manera desde nuestro controlador 
- `return redirect()->route('post.index')` el nombre debe estar definido en tu route/web.php 
- podemos usar el metodo Post::latest('id')->paginate(); en ves del orden by 

## 107. Agregar Reglas de Validación

**Concepto**
- Para agregar reglas de validación en Laravel 10, primero debes crear una instancia de la clase Validator. 
- Puedes hacer esto usando el helper validator() o el método make() en la clase Validator. 

**Pasos**
- A continuación, debes definir las reglas de validación para cada campo de entrada utilizando los métodos de validación apropiados, como required(), max(), min(), email() y más.
- Por ejemplo, si tienes un formulario con campos "nombre" y "correo electrónico", puedes definir reglas de validación para cada campo de la siguiente manera:

```
$validator = validator(request()->all(), [
   'nombre' => 'required',
   'correo electrónico' => 'required|email',
]);
```
- En este ejemplo, la regla 'required' indica que el campo debe tener un valor, mientras que la regla 'email' indica que el campo debe ser un correo electrónico válido.
- Una vez que hayas definido las reglas de validación, debes verificar si la validación ha sido exitosa utilizando el método passes(). Si la validación no es exitosa, puedes obtener los errores utilizando el método errors().
```
if ($validator->passes()) {
   // La validación ha sido exitosa.
} else {
   // La validación no ha sido exitosa. Obtén los errores.
   $errors = $validator->errors();
}
```

- Laravel 10 también te permite personalizar los mensajes de error para cada regla de validación. Puedes hacer esto utilizando el método messages() 
y proporcionando un array de mensajes personalizados para cada regla de validación.

```
$validator = validator(request()->all(), [
   'nombre' => 'required',
   'correo electrónico' => 'required|email',
], [
   'nombre.required' => 'El nombre es obligatorio.',
   'correo electrónico.required' => 'El correo electrónico es obligatorio.',
   'correo electrónico.email' => 'El correo electrónico debe ser válido.',
]);
```
- En este ejemplo, hemos proporcionado mensajes personalizados para las reglas 'required' y 'email' para los campos "nombre" y "correo electrónico".



## 108. Mostrar Errores de Validación

**Concepto**

- Si los datos ingresados no cumplen con las reglas de validación, Laravel automáticamente redirigirá al usuario a la página anterior y mostrará los errores de 
validación correspondientes. En este capítulo, veremos cómo mostrar los errores de validación en la vista y cómo personalizar los mensajes de error.

**Pasos** 
- Para empezar, definiremos las reglas de validación en el controlador. Por ejemplo, 
si queremos asegurarnos de que un campo de nombre sea obligatorio y tenga una longitud máxima de 255 caracteres, 
podemos definir las reglas de validación de la siguiente manera:

```
$validatedData = $request->validate([
   'name' => 'required|max:255',
]);
```
- Si los datos ingresados no cumplen con estas reglas, Laravel automáticamente redirigirá al usuario a la página anterior y mostrará los errores de validación correspondientes.
- Ahora, para mostrar los errores de validación en la vista, podemos utilizar la función errors() de Laravel. Esta función devuelve una instancia de la clase MessageBag, que contiene todos los errores de validación.
- Por ejemplo, si queremos mostrar los errores de validación para el campo de nombre, podemos hacerlo de la siguiente manera:
```
<input type="text" name="name" value="{{ old('name') }}">
@if ($errors->has('name'))
   <div class="alert alert-danger">{{ $errors->first('name') }}</div>
@endif

ó 

@error('nombreCampo')
<span>{{ $message }}</span>
@enderror
```

- En este ejemplo, estamos utilizando la función old() de Laravel para repoblar el valor del campo de nombre en caso de que haya un error de validación. 
- Si hay errores de validación para el campo de nombre, estamos mostrando el primer mensaje de error usando la función first() de la clase MessageBag.

- Finalmente, si deseas personalizar los mensajes de error para cada regla de validación, puedes hacerlo definiendo una matriz de mensajes personalizados en el controlador. 
- Por ejemplo, si deseas personalizar el mensaje de error para la regla required, puedes hacerlo de la siguiente manera:
```
$customMessages = [
   'required' => 'El campo :attribute es obligatorio.',
];
$validatedData = $request->validate([
   'name' => 'required|max:255',
], $customMessages);
```
- En este ejemplo, estamos definiendo un mensaje personalizado para la regla required. 
- El mensaje personalizado incluye un marcador de posición :attribute, que será reemplazado por el nombre del campo correspondiente.

En resumen, en este capítulo hemos aprendido cómo manejar los errores de validación en Laravel 10. Hemos visto cómo definir las reglas de validación en el controlador, cómo mostrar los errores de validación en la vista y cómo personalizar los mensajes de error. Ahora puedes utilizar este conocimiento para crear formularios más robustos y seguros en tu aplicación Laravel.

## 109. Recuperación de Entradas Antiguas con old()

**Concepto**
- Si estás trabajando con Laravel 10, es posible que en algún momento necesites recuperar datos de entradas antiguas en tu aplicación web. 
- Afortunadamente, Laravel proporciona una función útil llamada old() que te permite hacer precisamente eso.
- La función old() te permite recuperar los datos de entrada antiguos de un formulario y mostrarlos en la vista. Esto es útil cuando un usuario envía un formulario, pero hay errores en los datos que ha proporcionado. En lugar de hacer que el usuario vuelva a ingresar toda la información, puedes utilizar la función old() para prellenar los campos con los datos que el usuario ya ha proporcionado.
- Para utilizar la función old(), simplemente tienes que añadirla a la propiedad value de tus campos de formulario. Por ejemplo, si tienes un campo de formulario llamado "nombre", puedes utilizar la función old() de la siguiente manera:
```
<input type="text" name="nombre" value="{{ old('nombre') }}">
```
- De esta manera, si el usuario ha proporcionado un valor para el campo "nombre" en una entrada anterior, la función old() lo recuperará y lo mostrará en el campo. 
- Si el usuario no ha proporcionado un valor para el campo anteriormente, el campo aparecerá vacío.
- También puedes utilizar la función old() para recuperar valores de selección y casillas de verificación. 
- Por ejemplo, si tienes un campo de selección llamado "color" con las opciones "rojo", "verde" y "azul", puedes utilizar la función old() de la siguiente manera:

```
<select name="color">
   <option value="rojo" {{ old('color') == 'rojo' ? 'selected' : '' }}>Rojo</option>
   <option value="verde" {{ old('color') == 'verde' ? 'selected' : '' }}>Verde</option>
   <option value="azul" {{ old('color') == 'azul' ? 'selected' : '' }}>Azul</option>
</select>
```
- En este caso, la función old() comprueba qué opción fue seleccionada en una entrada anterior y la selecciona automáticamente si se encuentra en el conjunto de opciones disponibles.

## 110. Form Request

**Concepto**
- Cuando trabajas con Laravel 10, es importante asegurarte de que los datos de entrada de tu aplicación web sean válidos antes de procesarlos. 
- Para lograr esto, Laravel ofrece una herramienta llamada Form Request, que te permite validar los datos de entrada de una forma centralizada y reutilizable en múltiples controladores.

**Pasos**
- Para crear un Form Request en Laravel 10, simplemente ejecuta el siguiente comando Artisan en la terminal:
- `php artisan make:request ValidarDatosEntrada`
- Este comando creará un archivo llamado "ValidarDatosEntrada.php" en la carpeta "app/Http/Requests". En este archivo, encontrarás una clase que extiende la clase "Illuminate\Foundation\Http\FormRequest" y un método "rules()" que define las reglas de validación para los datos de entrada. Por ejemplo:
```



namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class ValidarDatosEntrada extends FormRequest
{
   
   
    /**
     * Description: Esto permite que pueda usarse el controlador desde un evento creare o update
     *
     * @return type bool  -> true
     */
    public function authorize():bool
    {
        return  true;
    }   
   
   public function rules()
   {
       return [
           'nombre' => 'required|string|max:255',
           'email' => 'required|email|unique:users,email',
           'edad' => 'required|integer|min:18',
       ];
   }
}
```
- En este ejemplo, el método "rules()" define las reglas de validación para los campos de entrada "nombre", "email" y "edad". 
- Las reglas incluyen la validación de que los campos son obligatorios, que el correo electrónico es válido y único en la tabla "users", y que la edad es un número entero mayor o igual a 18.
- Una vez que has creado tu Form Request, puedes utilizarlo en cualquier controlador que procese los datos de entrada. 
- Para hacer esto, simplemente agrega la clase del Form Request como una dependencia del método del controlador correspondiente. 
- Por ejemplo:

```
namespace App\Http\Controllers;
use App\Http\Requests\ValidarDatosEntrada;
use Illuminate\Http\Request;
class ControladorDatosEntrada extends Controller
{
   public function procesarDatos(ValidarDatosEntrada $request)
   {
       // El código para procesar los datos de entrada se coloca aquí
   }
}
```
- En este ejemplo, el método "procesarDatos()" utiliza el Form Request "ValidarDatosEntrada" para validar los datos de entrada antes de procesarlos. 
- Si los datos no pasan la validación, se generará un mensaje de error de validación y el usuario será redirigido de vuelta al formulario.

**En resumen**
- En resumen, Form Request es una herramienta útil en Laravel 10 para validar los datos de entrada de forma centralizada y reutilizable en múltiples controladores. 
- Utilízalo para mejorar la integridad de tus datos y simplificar el proceso de validación en tu aplicación web.


## 111. Route Model Binding

**Concepto**
- permite generar URL amigables para que el motor de google pueda validarlo y rankearlo
- Se generan campos llamados `slug`
- es un proceso muy simple pero no aplica en todos los casos, ya que para este ejemplo estamos usando post de articulos

**Pasos**
- En la tablas debemos crear un nuevo campo llamado slug 
- Este debe ser unico y requerido 
- Luego en tu modelo definimos que tome el slug creando un metodo 
```
public function getRouteKeyName(){
	return "slug";//Claro este campo ya debe estar definido en el $fillable 
}
```

- Con este cambio automaticamente se genera los cambios en los controladores este detalle funcionará si usamos la nomeclatura basica
- Ejemplo: 

```

//En tu metodo edit
public function edit(Post $post){//Usamos esto y en el web.php tambien indicando que llegara un  post
	
	return view('posts.edit', compact('post'));
}

```
**Resumen**
- Es un ejemplo practico pero debes tambien manejar validaciones ya que ese campo es unico

## 112. Regla Unique

**Concepto**
- Cuando trabajas con Laravel 10, a menudo es necesario validar que los datos de entrada de un formulario sean únicos para evitar la creación de registros duplicados en la base de datos. 
- Para hacer esto, puedes utilizar la regla Unique de Laravel.

**Pasos**
- La regla Unique te permite validar que un campo de entrada en un formulario sea único en la base de datos. 
- Para utilizar esta regla, simplemente agrega el método unique() a las reglas de validación para el campo correspondiente. 
- Por ejemplo, si tienes un campo de entrada llamado "correo electrónico", puedes utilizar la regla Unique de la siguiente manera:
```
$request->validate([
   'email' => 'required|email|unique:users,email' //Para este caso no permite crear ya que le indicamos tabla=users, campo=slug
]);
```
- En este caso, la regla Unique comprueba que el valor del campo de entrada "correo electrónico" no esté ya presente en la tabla "users" de la base de datos. 
- Si el valor ya existe en la tabla, se generará un mensaje de error de validación y el formulario no se enviará.
- También puedes utilizar la regla Unique para validar la unicidad de múltiples columnas en la base de datos. Para hacer esto, simplemente pasa un array de nombres de columna a la regla Unique. Por ejemplo, si tienes una tabla "clientes" con las columnas "nombre" y "correo electrónico" y deseas validar que los valores en ambas columnas sean únicos, puedes utilizar la regla Unique de la siguiente manera:
```
	dd($this->post);//Imprime el modelo actual que estas usando 
	
	if ($this->post){
		$post_id= ','.$this->post->id;//Cuando editamos 
	}else{
		$post_id= '';//Cuando creamos 
	}

$request->validate([
   'nombre' => 'required|unique:clientes,nombre,email,' . $id,
   'correo electrónico' => 'required|unique:clientes,nombre,email,' . $post_id//En caso para editar debemos enviar la id para que pueda indicarle que NO haga la validación sobre ese registro
]);
```
- En este caso, la regla Unique comprueba que los valores de las columnas "nombre" y "correo electrónico" no estén ya presentes en la tabla "clientes" de la base de datos. El parámetro adicional $id se utiliza para excluir el registro actual de la comprobación de unicidad, lo que permite actualizar los registros existentes sin generar un error de validación.


## 113. Regla Exists

**Concepto**
- Cuando trabajas con Laravel 10, es común necesitar validar la existencia de un registro en la base de datos antes de realizar una acción en él. 
- Para hacer esto, puedes utilizar la regla Exists de Laravel.

**Pasos**
- La regla Exists te permite validar que un valor de entrada exista en una tabla de la base de datos. 
- Para utilizar esta regla, simplemente agrega el método exists() a las reglas de validación para el campo correspondiente. Por ejemplo, si tienes un campo de entrada llamado "user_id" y deseas validar que este valor exista en la tabla "users", puedes utilizar la regla Exists de la siguiente manera:

```
//Esta regla funciona con las claves foraneas es decir validas que esa id exista en la tabla padre relacionada
$request->validate([
   'user_id' => 'required|exists:users,id'
]);
```

- En este caso, la regla Exists comprueba que el valor del campo de entrada "user_id" esté presente en la columna "id" de la tabla "users" de la base de datos. Si el valor no existe en la tabla, se generará un mensaje de error de validación y el formulario no se enviará.
- También puedes utilizar la regla Exists para validar la existencia de un registro en una tabla con múltiples condiciones. Por ejemplo, si tienes una tabla "pedidos" con las columnas "id" y "user_id" y deseas validar que un registro exista en la tabla con una combinación específica de valores para ambas columnas, puedes utilizar la regla Exists de la siguiente manera:
```
$request->validate([
   'pedido_id' => 'required|exists:pedidos,id,user_id,' . auth()->id()
]);
```
- En este caso, la regla Exists comprueba que un registro en la tabla "pedidos" exista con un valor de "id" 
correspondiente al valor del campo de entrada "pedido_id" y un valor de "user_id" correspondiente al ID del 
usuario actualmente autenticado. Si no se encuentra un registro que cumpla con ambas condiciones, 
se generará un mensaje de error de validación y el formulario no se enviará.

**Resumen**
- En resumen, la regla Exists de Laravel 10 es una herramienta útil para validar la existencia de un registro en la base de datos antes de realizar una acción en él. 
- Utilízala para garantizar la integridad de tus datos y mejorar la seguridad de tu aplicación web.

**Notas**
- Hay que validar si esto funciona ajustandolo en los Postrequest en las reglas yo deseo creer que si 
- Recuerda que si usamos Postrequest ya con usar un metodo create o update activa la validación 
- O lo usamos a la vieja escuela invocando el metodo Make:: y usando el metodo desde el controlador 


# Kit de inicio

## 114.  Cómo instalar Breeze en tu proyecto

> Laravel nos permite crearun crud para realizar una autenticación, desde login, recuperación de contraseña, editar datos y guardar 

```
Breeze es un paquete oficial de Laravel que proporciona un sistema de autenticación simple y liviano para aplicaciones web. En este capítulo, aprenderás cómo instalar Breeze en tu proyecto Laravel 10 y cómo configurarlo para autenticar usuarios en tu aplicación.
```

**Pasos**
- Paso 0: Claro crear tu proyecto laravel
- Paso 1: `composer require laravel/breeze --dev`
Este comando instala el paquete Breeze como una dependencia de desarrollo en tu proyecto Laravel 10. A continuación, ejecuta el siguiente comando para publicar los archivos de configuración y vistas de Breeze
- Paso 2:`php artisan breeze:install` 
- Paso 3:`php artisan migrate` 
- Paso 4:`npm install` 
- Paso 5:`npm run dev` 



**Notas**
- Se recomienda solo usar esto desde un proyecto desde cero 

## 115.  Cómo instalar Breeze en tu proyecto

Breeze es un paquete oficial de Laravel que permite implementar la autenticación de usuarios de manera rápida y sencilla en tu aplicación. En este capítulo, exploraremos la estructura de Breeze y cómo implementa la autenticación en Laravel 10.

Cuando instalas Breeze en tu proyecto Laravel, se agregan varios archivos y directorios que contienen el código fuente necesario para manejar la autenticación. El archivo principal es routes/web.php, donde se definen las rutas para la autenticación, el registro y la recuperación de contraseñas. También se incluyen vistas y controladores en los siguientes directorios:

app/Http/Controllers/Auth: Contiene los controladores de autenticación para manejar el inicio de sesión, el registro y la recuperación de contraseñas.
resources/views/auth: Contiene las vistas para los formularios de inicio de sesión, registro y recuperación de contraseñas.
resources/views/layouts: Contiene la plantilla de diseño principal de la aplicación, que se utiliza para envolver todas las vistas de la aplicación, incluyendo las vistas de autenticación.
En cuanto a la personalización de la apariencia de los formularios de inicio de sesión y registro, Breeze utiliza las vistas Blade de Laravel para generar el HTML de los formularios. Esto significa que puedes personalizar el HTML de los formularios modificando las vistas Blade en resources/views/auth. Además, también puedes personalizar los estilos CSS de los formularios agregando tus propias reglas CSS en tus archivos CSS personalizados.

En resumen, la estructura de Breeze en Laravel 10 es simple y bien organizada. Con los archivos y directorios predeterminados, puedes implementar la autenticación de usuarios en tu aplicación con muy poco esfuerzo. Y si deseas personalizar la apariencia de los formularios de autenticación, simplemente debes modificar las vistas y los estilos CSS.

**Notas**
- Tips para validar enlace si esta en la ruta 
![Ejemolo](./info/info_007.png)