<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

Requisitos previos: Antes de instalar Laravel, asegúrate de tener instalado PHP en tu computadora. Puedes descargar la última versión de PHP en el sitio web oficial de PHP. También necesitarás tener instalado Composer, un administrador de paquetes para PHP. Puedes descargar Composer en getcomposer.org.

Instalar Laravel: Una vez que tienes PHP y Composer instalados, puedes instalar Laravel usando Composer. Abre una terminal o línea de comandos y escribe el siguiente comando:

javascript
Copy code
`composer global require laravel/installer`

Este comando descargará e instalará la última versión de Laravel.

Crear un nuevo proyecto Laravel: Para crear un nuevo proyecto de Laravel, abre una terminal o línea de comandos y navega hasta la carpeta en la que deseas crear el proyecto. Luego, escribe el siguiente comando:

javascript
Copy code
`laravel new nombre-de-tu-proyecto`

Este comando creará un nuevo proyecto de Laravel con el nombre que hayas elegido.

Crear una nueva ruta API: Para crear una nueva ruta API, abre el archivo routes/api.php en tu editor de texto favorito y agrega la siguiente línea:

```
Route::get('/ruta', function () {
    return '¡Hola, mundo!';
});

```
Esta ruta responderá a las solicitudes GET a /ruta y devolverá el texto "¡Hola, mundo!".

Ejecutar el servidor de desarrollo: Para ejecutar el servidor de desarrollo de Laravel, abre una terminal o línea de comandos, navega hasta la carpeta raíz de tu proyecto de Laravel y escribe el siguiente comando:

Copy code
php artisan serve
Este comando ejecutará el servidor de desarrollo de Laravel y podrás acceder a tu aplicación en http://localhost:8000.

Probar la ruta API: Abre un navegador web y visita la URL http://localhost:8000/api/ruta. Deberías ver el texto "¡Hola, mundo!" en tu navegador.

¡Eso es todo! Ahora tienes un servicio web API básico en Laravel. Puedes seguir agregando más rutas y funcionalidades para construir una aplicación web completa.
