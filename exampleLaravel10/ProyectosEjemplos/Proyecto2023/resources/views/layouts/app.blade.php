<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SETRASS') }}</title>
    @vite('resources/sass/app.scss')
</head>
<body>
@include('partials.header-app')
<div id="app" class="mb-5">
    @if(url_activa('admin*'))
        @include('layouts.sidebar')
    @endif
    @if(url_activa('denuncias*') || url_activa('planeaciones*') || url_activa('auditorias*'))
        @include('layouts.sidebar-ati')
    @endif
    <main id="content-app" class="d-flex flex-column">
        <div id="content">
            <div class="container pt-3">
                @include('layouts.alerts')
                @yield('content')
            </div>
        </div>
    </main>
</div>
@include('partials.footer')
@livewireScripts
</body>
<script type="module">
    window.base_url = "{{ url('/') }}";
    window.post_size = "{{ini_get('post_max_size')}}";
</script>
@vite('resources/js/app.js')
</html>
