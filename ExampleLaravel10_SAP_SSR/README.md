# Dummy Desarrollo 


## Renderización: 

```
Si bien el navegador al final solamente interpreta código HTML, CSS y JavaScript, la forma en que llega ese código es el tipo de renderizado. 

Cada una cambiará la experiencia de los usuarios en un sitio web, desde la percepción del rendimiento hasta la interactividad. Muchos frameworks ofrecen la posibilidad de utilizar cualquiera de estos tipos de renderizados.
``` 

**Se dividen en tres tipos diferentes:**

- Client Side Rendering (SPA)
- Server Side Rendering (SSR)
- Static Site Generation (SSG) -> Ignoraremos esto mientras XD

## SPA -> 

**Qué es**

Este tipo de renderizado se hace mayormente **desde el navegador**, 
desde la representación de la interfaz y el layout hasta la lógica de formularios y llamadas de APIs. en pocas palabras desde el cliente  

```
Si bien este tipo de renderizado no tiene muchas ventajas, hay que destacar:

La navegación entre vistas es rápida, después de renderizar toda la aplicación y al ir de una vista a otra, por ejemplo de inicio (/) a contacto (/contacto), esta no se volverá a descargar y no tendrá que hacer peticiones al servido
```
- Nota -> *Si bien este tipo de renderizado no tiene muchas ventajas, hay que destacar:*

**Ventajas**
- La navegación entre vistas es rápida. 
- Esta no se volverá a descargar y no tendrá que hacer peticiones al servidor
- Peticiones ajax 

**Desventajas**

- Bajo rendimiento, debido a que toda la aplicación se debe ejecutar mediante JavaScript
- Mal posicionamiento en SEO, debido a que rastreadores como el de Google le resulta mucho más fácil rastrear código HTML
- Complejidad de mantenimiento, cuándo una aplicación crece demasiado, utilizando este tipo de renderizado hará que a la larga sea muy difícil de mantener y escalar
- Muchas peticiones ajax relentiza la página 
- algo complicado lograr autenticar seccione si no trabajamos con base de datos para este caso usamos los Json Web Tokens 

**Cuando Usar**
- No deseas tener posicionamiento en buscadores.
- Deseas crear una aplicación web interactiva con datos dinámicos.

## SSR ->  

**Qué es** 

```
El renderizado desde el servidor es lo que comúnmente se ha utilizado desde el inicio de la Web, 
aunque puedas pensar que está relacionado con los frameworks modernos, la verdad que no es así 
solamente que se está volviendo a poner de moda. 

**Como Funciona**
Cuándo el navegador solicita una página web, está es creada desde el 
servidor compilando todo el código y los datos y devuelve una página HTML completa
```

**Ventajas**
- Performance, debido a que el código entregado al usuario final está compilado a HTML y solamente se necesita JavaScript en partes dinámicas de nuestra aplicación web, el rendimiento es considerablemente mejor.
Posicionamiento SEO, al entregar código HTML es mucho más fácil escanear nuestro sitio web para los rastreadores.

**Desventajas**

- Siempre dependes de contratar un proveedor de alojamiento para ejecutar tu aplicación, aunque sea muy sencilla.
- Si tu sitio web llega a tener muchas visitas, al ejecutarse todo desde el servidor este debe manejar todas esas peticiones por lo que los costes van a aumentar.

**Cuando Usar**
- Cuándo tenemos una aplicación web creada en cualquier librería frontend y queremos mejorar aspectos de rendimiento y posicionamiento
- Cuándo queremos utilizar funcionalidades más complejas como autenticación, inicios y registro de sesión




**Comando del Example Para iniciar Dev**
- composer dump-autoload
- php artisan migrate 
- php artisan storage:link
- .env nombre de base de datos -> `DB_DATABASE=example`

**Puntos Importantes**
- Archivo JavaScript    ->  [Aqui](https://github.com/LeoSan/CursoPlatziLaravel/blob/main/ExampleLaravel10_SAP_SSR/public/js/post.js)
- Archivo Controlador   ->  [Aqui](https://github.com/LeoSan/CursoPlatziLaravel/blob/main/ExampleLaravel10_SAP_SSR/app/Http/Controllers/PostController.php)
- Archivo Formulario    ->  [Aqui](https://github.com/LeoSan/CursoPlatziLaravel/blob/main/ExampleLaravel10_SAP_SSR/resources/views/post/formAjax.blade.php)


**Ejemplo SAP Ajax**
[![Alt text](https://img.youtube.com/vi/5-r5fgzkQgA/0.jpg)](https://www.youtube.com/watch?v=5-r5fgzkQgA&ab_channel=leonardjosecuencaroa)

**Ejemplo SSR Normal**
[![Alt text](https://img.youtube.com/vi/snC0G9SKdeA/0.jpg)](https://www.youtube.com/watch?v=snC0G9SKdeA&ab_channel=leonardjosecuencaroa)


**Comando del Example Para Crear Dev**

- composer create-project laravel/laravel nombreProyecto "10.*"
- composer dump-autoload
- Genero base de datos  -> example
- php artisan make:migration create_post_table
- php artisan make:controller Post --resource --model=Post
- php artisan storage:link

```  en caso en error 
php artisan optimize:clear
php artisan config:cache
php artisan config:clear
php artisan clear-compiled
composer dump-autoload
```


**enlaces referencia fuente** 
- https://5balloons.info/example-of-vanilla-javascript-fetch-post-api-in-laravel -> Explica como usar fetch (Efecto ajax en Laravel)
- 