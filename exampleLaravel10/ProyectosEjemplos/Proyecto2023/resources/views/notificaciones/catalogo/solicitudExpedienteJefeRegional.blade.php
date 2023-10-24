<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                            <b>{{ $usuario->complete_name }}</b> <b>{{ $usuario->cargo }}</b>,
                        </span>
                        <br>
                        <p>
                            Por medio de la presente el(la) funcionario(a) público <b>{{$extras['nombre_jefe_auditoria']}} {{$extras['cargo_jefe_auditoria']}}</b> de la Auditoría Técnica de la Inspección, solicita su apoyo para proporcionar una serie de expedientes de inspección que le permitirán llevar a cabo las funciones a su cargo.
                        </p>
                        <p>
                            Para revisar el oficio y el detalle de los expedientes requeridos, por favor ingrese al sistema haciendo clic  <a href="{{$extras['url']}}">aquí</a>.
                        </p>
                        <p>
                            Saludos.
                        </p>
                    </div>
                    <div style=" margin: 20px 0 0;">
                <span
                    style="height: 15px; color: #778ca2; font-family: 'Montserrat', sans-serif; font-size: 12px; font-weight: 500; font-stretch: normal; font-style: italic; line-height: normal; letter-spacing: normal;">
                    {{ $dependencia }}
                </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</bod>
</html>
