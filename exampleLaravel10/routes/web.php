<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/contacto', function () {
    return "hola desde la página de contacto";
})->name('curso.contacto');

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


//->name() -> Método que permite colocar le nombre a las rutas
// return route('nombreRuta')
// return route('nombreRuta', 4) -> permite enviarle parametros asi
// return route('nombreRuta', ['id'=>1, 'nombre'=>'utilidad']) -> permite enviarle parametros asi
Route::get('/materia/{materia}/', function ($materia) {
    return route('curso.contacto');
})->name('informacion.cursos');

Route::get('/materia/{materia}/', function ($materia) {
    return "Bienvenido a tu materia $materia";
})->name('cursos.materia');

/**
 * Forma de CRUD
 *
 */

 Route::post('/post/{post}/', function ($post) {
    return "Esto procesa el formulario $post";
})->name('procesar.formulario');

Route::get('/post/{post}/', function ($post) {
    return "Esto muestra el formulario $post";
})->name('agregar.formulario');

Route::put('/post/{post}/', function ($post) {
    return "Esto muestra el formulario para editar $post";
})->name('editar.formulario');

Route::delete('/post/{post}/', function ($post) {
    return "Esto muestra el formulario para eliminar $post";
})->name('eliminar.formulario');




/**
 * Este fragmento proteje las rutas por middleware
 * Como saber que middle esta protegida es con este comando - `php artisan r:l --except-vendor -v` el menos V le indicas que te traiga el middle
 */

// $this->routes(function () {
//     Route::middleware('api')
//         ->prefix('api')
//         ->group(base_path('routes/api.php'));

//     Route::middleware('web')
//         ->group(base_path('routes/web.php'));
// });
