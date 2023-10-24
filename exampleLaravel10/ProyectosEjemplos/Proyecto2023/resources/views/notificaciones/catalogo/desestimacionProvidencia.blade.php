<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordatorio Providencia</title>
</head>
<bod>
    <div style="background-color: #F8FAFC; padding: 40px 0;">
        <table
            style="width:650px; background-color: #ffffff; margin:0 auto; border: 1px solid lightgray; padding:4%; border-radius: 0 .25rem;">
            <tr>
                <td>
                    <div>
                        <img style="width: 131px; height: 55px; display: block; object-fit: contain;"
                             src="{{asset('images/logo2x.png')}}">
                    </div>
                    <div style="margin: 20px 5px 20px; border: solid 1px #ccc;"></div>
                    <div style="margin: 0 0 20px;">
                        <span style="">
                            Hola <b>{{ $usuario->complete_name }}</b>,
                        </span>
                        <br>
                        <p>
                            Se le informa que a la fecha el denunciante no ha dado respuesta a la providencia emitida el pasado <b>{{$extras->fecha_providencia}}</b> con lo cual vence el término legal para continuar con la atención de la denuncia.
                        </p>
                        </p>
                            Le invitamos a realizar la desestimación por falta de respuesta ingresando a la plataforma de Auditoría Técnica de la Inspección dando clic <a href="{{$extras->url}}">Aquí</a>.
                        </p>
                        <p>
                            Saludos.
                        </p>
                    </div>
                    <div style=" margin: 20px 0 0;">
                        <span
                            style="height: 15px; color: #778ca2; font-family: 'Montserrat', sans-serif; font-size: 12px; font-weight: 500; font-stretch: normal; font-style: italic; line-height: normal; letter-spacing: normal;">
                            Auditoría Técnica de la Inspección
                        </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</bod>
</html>
