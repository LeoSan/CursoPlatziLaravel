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
                            Estimado(a)   <b>{{ $usuario->complete_name }}</b>,
                        </span>
                        <br>
                        <p>
                            Por medio de la presente solicitamos su valioso apoyo para proporcionar una copia del expediente número <b>{{$extras['folio_denuncia']}}</b> esto con motivo de dar pronta atención a una denuncia presentada la cual está relacionada al expediente en comento.
                        </p>
                            Agradecemos de antemano su apoyo y le invitamos a ingresar al sistema de la Auditoría Técnica de la Inspección haciendo clic <a href="{{$extras['url']}}">aquí</a> para cargar la información solicitada.
                        </p>
                        <p>
                            Finalmente, le recordamos que podrá ingresar con la cuenta de correo en la que recibió este mensaje y si no recuerda su contraseña, podrá recuperarla.
                        </p>
                        <p>
                            Auditoría Técnica de la Inspección.
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
