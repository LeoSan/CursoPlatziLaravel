# Single_Page_Applications_Laravel_Inertia_Vue

## Introducción a Jetstream 🚀
Jetstream es un componente que nos permite incorporar el inicio de sesión, registro, verificación de email, etc, dentro de Laravel.

Y además podemos utilizar un sistema llamado Inertia.js que usa como motor de vista componentes de Vue.js. Todo diseñado con el Framework CSS de Tailwind.

laravel new peoject --jet

# Si queremos instalar después Jetstream🚀
composer require laravel/jetstream
Dependiendo de que sistema utilicemos vamos a trabajar en una carpeta diferente:

Livewire → resources/views (trabajamos con Blade)
Inerta → resources/js (trabajamos con Vue)
Si utilizamos Inerta.js vamos a contar con el manejador de packages npm, y con estos comandos:

- npm install → Para que se instalen todas las dependencias-
- npm run dev → Con este creamos un solo JS con sus componentes.
- npm run watch → Y si estamos haciendo cambios constantemente a ese JS utilizamos este comando.


## Configuración inicial🚀

Concepto importantes a tener en cuenta:

- Modelo == Tabla (o Entidad) en una database
- Controlador == a un Archivo que se encarga de coordinar las diferentes solicitudes del usuario.
- Factories == una estructura de datos falsos con la que vamos a probar la app.
- Migración == estructura de una tabla que la vamos a tener dentro de Laravel, y luego creamos una tabla (o entidad) en la database.

> Para poder utilizar el comando Laravel new tienes que tener instalado el CLI de Laravel en la computadora. 

> Si este no es tu caso, y instalas todo por la consola de Linux o WSL, utilizas la instalación estándar con Composer.

## Comandos Principales 🚀

- Paso 1: `composer create-project --prefer-dist laravel/laravel nombreApp && cd nombreApp`
- Paso 2:  `composer require laravel/jetstream`
- Paso 3:  `php artisan jetstream:install inertia`
- Paso 4:  configuramos una base de datos mysql, en el .env 
- Paso 5:  `php artisan key:generate`
- Paso 6:  `php artisan migrate:refresh --seed`
- Paso 7:  `npm install && npm run watch`

## ProyectoNotas 🚀
- Creamos nuestro modelo nota `php artisan make:model Note -rfm` creamos un modelo con migrate-ruta-factory


## Sistema basado en componentes

> Laravel es el sistema que nos permite crear código sencillo, flexible y elegante. Es un sistema basado en componentes.

> Framework está guardado en la carpeta de 📁vendor.

> Este está compuesto por componentes creados por terceros o por el propio Laravel. Tiene una comunidad muy sólida.

## Notas: 
- jetstream -> Es ese componente que nos da esa calidad visual
- fortity -> Son clases que utiliza jet para iniciar sesión 
- Laravel es un sistema basado en componentes que usa el código de otras personas “La comunidad de laravel”.
- La filosofía de Laravel es desarrollar código PHP de forma elegante y simple.


## Jetstream: configuración inicial

El sistema de Jestream nos dice como vamos a trabajar del lado del front-end.

Por alguna razón en Laravel 8x cambiaron la vista “welcome.blade.php”, 
y ahora está en la carpeta donde están los componentes de Vue. 

## Admin Rutas 
``` 

//Nota: Claro importamos nuestros controladores para que funcione 
Route::view('/', 'index');//Apunta al blade -> resources\views\index.blade.php

Route::middleware('auth:sanctum')->group(function () {

    Route::get('dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    Route::resource('notes',NoteController::class);

});

``` 

## Jetstream: personalización

##Notas: 
- Antes de entrar a un controlador es importante importar esto `use Inertia\Inertia; ` esto permite hacer llamado a los componentes usados en resources\js\Layouts\AppLayout.vue
- Es importante resalar que usando jetstream podemos configurar el barrner desde esta ruta -> resources\js\Layouts\AppLayout.vue
- Usando Vue tenemos la propiedad Router para genear rutas estas se enrutan con el archivo router/web.php  si no se define aqui genera error 
- Claro hay que resaltar que es un elemento tipo resource, ya viene en el controlador el inde, store, delete, update, get, post etc...

```
#routes\web.php
 Route::resource('notes', App\Http\Controllers\NoteController::class);

```
```
#resources\js\Layouts\AppLayout.vue
<jet-nav-link :href="route('notes.index')" :active="route().current('notes.*')">
	Notas
</jet-nav-link>
```
- Es la forma de renderizar desde un controlador .php debemos importar `use Inertia\Inertia; ` y usamos la propiedad  `return Inertia::render('Dashboard'); ` 
```
#app\Http\Controllers\NoteController.php
    public function index()
    {
        //Nota: Esto hace referencia a Page-> \resources\js\Pages\Dashboard.vue
        return Inertia::render('Dashboard'); 
    }
```

- Hay que definir en nuestra plantillas .vue si el controaldor de vuelve valores, este ajuste hay que ingresarlo en la parte inferior de nuestra plantilla de esta manera
```
# resources\js\Pages\Notes\Index.vue
<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    

    export default defineComponent({
        components: {
            AppLayout,
        },
        props:{
            //Definimos valor
            notes:Array,
        }
    })
</script>

```
- En caso que no funcione el ** `component: inertia-link` ** vue por ajuste de versión podemos usar lo siguiente 

```
Si, tienes el error “Failed to resolve component: inertia-link” pudes resolverlo importando el componente manualmente inertiajs/inertia-vue3, debido a una actualización. El Código quedaría así.

HTML

<Link :href=“route(‘notes.show’, note. id)”>
Mostrar
</Link>

JS

<script>
import AppLayout from '@/Layouts/AppLayout.vue’
import { Head, Link } from ‘@inertiajs/inertia-vue3’
```
- Primero hay que estudiar Vue tiene muchas nomeclaturas que nos saca de apuro una de ellas es la forma de **iterar datos** se hace de esta manera:
- Es parecido a react debes establecer un componenete unico si no genera error -> `v-bind:key="note.id"` 
- Igual que en React podemos **acceder** de esta manera a los **valores** -> `{{ note.excerpt }}`
```
# resources\js\Pages\Notes\Index.vue

                            <table>
                                <tr v-for="note in notes" v-bind:key="note.id">
                                    <td class="border px-4 py-2">
                                        {{note.excerpt}}
                                    </td>
                                    <td class="px-4 py-2">
                                        <Link :href="route('notes.show', note.id)">
                                            ver
                                        </Link>
                                    </td>                                    
                                    <td class="px-4 py-2">
                                        <inertia-link :href="route('notes.edit', note.id)">
                                            Editar
                                        </inertia-link>
                                    </td>

                                </tr>
                            </table>
```


> La forma en la que se trabaja es que realmente no estamos usando el sistema de rutas de Laravel, es decir, se usa ese sistema de rutas únicamente cuando accedemos por primera vez al sitio web, donde Laravel tiene que decidir cuál ruta mostrar, pero ya después de eso, Laravel le pasa su sistema de rutas a Vue a través de la librería `tightengo/ziggy` y es el sistema de rutas de Vue el que se encarga de ir mostrando las demás rutas, en Vue normal, un enlace se llamaría `<route-link>`, de hecho sí podemos usar un elemento `<a>`, pero estaríamos desaprovechando a Vue porque un elemento `<a>` recargaría la página.


## Editar 

Lo mágico de esto es que los datos ya aparecen puestos, y esto es gracias al v-model que es una de las cosas más hermosas de Vue, el “Two Way Data Binding”, de hecho, si en cualquier otro lugar de esa página imprimeras el extracto: {{ form.excerpt }} podrías ver cómo al editar el extracto en el campo de texto también se edita en ese lugar en donde lo imprimiste, es lo mágico de Vue y una de las cosas que más me gusta 😄
- v-model="form.excerpt" ->Esto permite mostrar los elementos en tus campos del formulario
- this.$inertia.put(this.route('notes.update', this.note.id), this.form) -> Esto permite redireccionar y apuntar al controlador enviando la infomación con el vervo put aqui podremos usar post get delete 

## Crear
- v-model="form.excerpt" ->Esto permite mostrar los elementos en tus campos del formulario
-  this.$inertia.post(this.route('notes.store'), this.form) 

## Plantilla

> Es importate señalar que inertia usa un aplantilla donde se renderisa todas las paginas que se crean tipo .vue. 

- Se puede encontrar en esta sección `resources\js\Layouts\AppLayout.vue` 
- Fragmento de codigo donde se carga todo el content 
```
            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
```

- Tambien podemos personalizar mensajes tipo flash: Esto se logra configurando el AppSeriviceProvider 
```
                <div v-if="$page.props.flash.status" class="bg-blue-500 text-white text-sm font-bold p-4">
                    <p>{{ $page.props.flash.status }}</p>
                </div>  
```

- Tambien puedes personalizar tus errores verlos en pantalla 
```
<div v-if="Object.keys($page.props.flash.errors).length != 0" class="bg-red-500 text-white text-sm font-bold p-4">
           <ul>
                  <li v-for="error in $page.props.errors" :key="error">
                       {{ error }}
                 </li>
          </ul>
</div>
```
- Otra forma de personalizar 
```
<main>
	<div v-if="$page.props.flash.status == 'Nota creada'" class="bg-green-500 text-white text-sm font-bold p-4">
		<p>{{ $page.props.flash.status }}</p>
	</div>
	<div v-if="$page.props.flash.status == 'Nota actualizada'" class="bg-blue-500 text-white text-sm font-bold p-4">
		<p>{{ $page.props.flash.status }}</p>
	</div>
	<div v-if="$page.props.flash.status == 'Nota eliminada'" class="bg-red-500 text-white text-sm font-bold p-4">
		<p>{{ $page.props.flash.status }}</p>
	</div>
	<slot></slot>
</main>
```    

- Tambien podemos personalizar los mensaje de los formularios

```
<div v-if="$page.props.errors.excerpt">{{ $page.props.errors.excerpt }}</div>
```

## Como hacer un buscador 

- Paso 1: Debemos generar el diseño, detalle ultra importante `v-model="q"` esto permite que lo escuche los evento y que sea dinamico  
```
                          <div class="flex justify-between">
                                <input type="text" class="form-input rounded-md shadow-sm" placeholder="Buscar..." v-model="q">
                                
                          </div>

```

- Paso 2: Ajustamos nuestro js para escuchar los eventos, detalle ultra importante ` watch:{` esto permite que sea dinamico 
```
<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
  components: {
    AppLayout,
    Link,
  },
  props: {
    //Definimos valor
    notes: Array,
  },
  data(){
    return{
      q:''
    }
  },
  watch:{
    q:function(value){
        this.$inertia.replace(this.route('notes.index', {q:value}))
    }
  }
});
</script>

```
- Paso 3: Ajustamos nuestro controlador para que realice la busqueda: 🚀
```
    public function index(Request $request)
    {
        //Nota: Esto hace referencia a Page-> \resources\js\Pages\Dashboard.vue
        return Inertia::render('Notes/Index',[
            'notes'=>Note::latest()
            ->where('excerpt', 'LIKE', "%$request->q%")    
            ->get()
        ]); 
    }
```




## Enlaces 
- https://inertiajs.com/
- Pasos para instalar laravel https://docs.microsoft.com/en-us/windows/wsl/install-win10#simplified-installation-for-windows-insiders 
- https://inertiajs.com/ 

