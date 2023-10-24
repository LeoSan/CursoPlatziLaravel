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
                            Estimado C. <b>{{ $usuario->complete_name }}</b>,
                        </span>
                        <br>
                        <p>
                            Se le informa que el pasado <b>{{$extras->fecha_providencia}}</b> se le hizo llegar por este medio, la providencia con relación a la denuncia <b>{{$extras->folio_denuncia}}</b> que presentó a través de nuestra plataforma, sin embargo, no hemos recibido respuesta alguna.
                        </p>
                        </p>
                            Le recordamos que es de suma importancia dar respuesta a más tardar el <b>{{$extras->fecha_maxima}}</b> ya que su solicitud podría ser desestimada.
                        </p>
                        <p>
                            Para dar contestación a la providencia en comento, le invitamos a ingresar a la plataforma de Auditoría Técnica de la Inspección dando clic
                            <a href="{{$extras->url}}">Aquí</a> .
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
