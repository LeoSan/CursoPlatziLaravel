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

**Tips Listas rutas**
- php artisan r:l -> Lista las router de manera mas corta 
- php artisan r:l --path=cursos -> Lista las router de manera mas corta 
- php artisan r:l --except-vendor -> me trae las rutas menos las que fueron instaladas por algun paquete 
- php artisan r:l --except-vendor -v -> me trae las rutas menos las que fueron instaladas por algun paquete y a parte me trae los nombre de los middleware 
- php artisan r:l --only-vendor -v -> me trae las rutas de paquetes
- php artisan route:clear	 -> limpiamos cache 
- php artisan route:cache -> Solo hacerlo en producción 

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

