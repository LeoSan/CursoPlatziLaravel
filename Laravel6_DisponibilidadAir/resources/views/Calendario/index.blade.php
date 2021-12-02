<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Calendario</title>
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"
        id="bootstrap-css">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
</head>

<body>
    <div class="container theme-showcase">
        <div class="row">
            <div class="col-12">
                <h3>CALENDARIO DE EVENTOS</h3>
            </div>
        </div>
        <div id="calendar">
        </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
