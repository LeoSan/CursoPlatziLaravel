<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    </head>
    <body>
        @include('layouts.alerts')        
        <div class="container">
            
        <fieldset>
            <legend>Example SSR</legend>
            <form action="{{route('store.post')}}" id="form_post" class="form-control" method="POST" autocomplete="off" accept-charset="UTF-8">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input id="nombre" name="nombre" type="text" class="form-control" required/>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <input id="descripcion" name="descripcion" type="text" class="form-control" required />
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
            </fieldset>

        </div>
    </body>
</html>        