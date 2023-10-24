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
                            Estimado   <b>{{ $usuario->complete_name }}</b>,
                        </span>
                        <br>
                        <p>
                            Le informamos que el auditor <strong>{{ $extras['auditor'] }}</strong> a cargo de la
                            <strong>denuncia con expediente {{ $extras['expediente_ati'] }}</strong>
                            ha cargado el informe de la misma para su revisión.
                        </p>
                        <p>
                            No omitimos mencionar que el plazo para la atención de esta denuncia vence el
                            <strong>{{ $extras['fecha_vencimiento']->isoFormat('D [de] MMMM [de] YYYY') }}</strong>
                        </p>
                        <p>
                            Le invitamos a ingresar al sistema haciendo clic
                            <a href="{{ route('denuncias.detalle', ['id' => $extras['denuncia_id']]) }}">aquí</a>
                            para realizar las actualizaciones que considere pertinentes.
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
