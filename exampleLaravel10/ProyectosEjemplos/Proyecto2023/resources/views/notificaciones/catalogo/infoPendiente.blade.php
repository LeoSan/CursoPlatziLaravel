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
                            Estimado  <b>{{ $usuario->complete_name }}</b>,
                        </span>
                        <br>
                        <p>
                            Le informamos que la Procuraduría General de la Republica ha solicitado
                            información que requiere para dar atención al caso de cobro de multa con
                            <b> expediente {{ $extras['numero_expediente'] }}</b>.
                        </p>
                        <p>
                            No es necesario que realice ninguna acción en el sistema. El procurador
                            a cargo del caso realizará las actualizaciones correspondientes.
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
