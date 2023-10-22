<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Paso 1 -> Esto es para generar el token y usar ajax ya que laravel tiene un token en las peticiones  -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Paso 2: Nota: Esto te ayuda a llegar a los elementos JS de bootstrap Ejemplo modales entre otros   -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    </head>
    <body>
        @include('modals.modal')      
        <div class="container">
            <fieldset>
                <legend>Example SAP</legend>
                <form id="form_1" autocomplete="off" accept-charset="UTF-8" >
                    @csrf
                    <div class="mb-3">
                        <label for="inpNombre" class="form-label">Nombre</label>
                        <input id="inpNombre" name="nombre" type="text" class="form-control" required/>
                    </div>
                    <div class="mb-3">
                        <label for="inpDescripcion" class="form-label">Descripción</label>
                        <input id="inpDescripcion" name="descripcion" type="text" class="form-control" required/>
                    </div>
                    <button id="btnGuardarAjaxs" type="submit"  class="btn btn-primary">Enviar Ajax </button>
                </form>               
            </fieldset>
        </div>
        <!-- Paso 3: Tu archivo JS ajax  -->
        <script src="{{ asset('js/post.js') }}"></script>
        
    </body>
</html>        
