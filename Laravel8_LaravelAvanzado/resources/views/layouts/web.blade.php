<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta NAME="viewport" content="width=device-width, initial-scale=1.0">
        <title> Cursos App </title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    </head>
<body>
    <header class="shadow-lg">
        <div class="bg-yellow-600 py-1"></div>
        <nav class="bg-yellow-500 py-2">
                <a href="{{route('home')}}">
                    <lottie-player alt="Imagen Platzi" class="h-8 mx-auto" src="https://assets5.lottiefiles.com/private_files/lf30_o6lookm2.json" mode="bounce" background="transparent"  speed="1"  style="width: 250px; height: 250px;"  loop  autoplay></lottie-player>
                </a>
        </nav>
    </header>
    
    <main class="py-10"> 
        <div class="container mx-auto px-4">
            @yield('content')
        </div>
    </main>
    
    <footer class="py-6 text-center shadow-xl">
        <div class="bg-yellow-700 py-1"></div>
        @auth
            <a href="{{url('dashboard')}}" class="text-sm text-gray-700 underline"> Panel Central </a>
        @else
            <a href="{{ url('login') }}" class="text-sm text-gray-700 underline">Login</a>
            <a href="{{ url('register')}}" class="ml-4 text-sm text-gray-700 underline">Registrate</a>
        @endif

    </footer>
</body>

</html>
