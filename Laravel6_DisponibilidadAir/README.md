# Verificación Motor de Disponibilidad

Sistema para llevar el control de los eventos de los verificadores.

## Info

- [Documentación Servicios](https://documenter.getpostman.com/view/10617529/U16htS86).
- [Repositorio Github](https://github.com/air-mexico/disponibilidad).
- Laravel ^8.0
- PHP ^8.0
- DB PostgresSql 13

## Pasos y Comando para Ejecutar 

- Paso 1:  `php artisan cache:clear`  Limpiar un poco el artisan por si las flies
- Paso 2:  `composer install` Ejecutar el instalador 
- Paso 3:  `composer update` Ejecutar el actualizador
- Paso 4:  `php artisan key:generate` Ejecutar el generador de Key 
- Paso 5:  `php artisan migrate:refresh --seed` Utilizamos los migrate y seed ya generados en el proyecto
- Paso 6:  `php  artisan serve` para levantar el servidor. En caso de usar Laragon sólo reinicialo para que detecte el proyecto y cree el host virtual.

## Notas
- Agregar al archivo .env la clave TOKEN_DISPONIBILIDAD con un valor hash el cual permitirá la autorización para generar tokens en el Motor.


