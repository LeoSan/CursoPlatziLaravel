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
                            A quien corresponda,
                        </span>
                        <br>
                        <p>
                            Por medio de la presente hacemos de su conocimiento que se ha presentado una denuncia vinculada a la inspección con número de expediente <b>{{$extras['numero_expediente']}}</b>, inspección que se encuentra en proceso.
                        </p>
                        <p>
                            La denuncia ha quedado registrada en los expedientes de la Auditoría Técnica de la Inspección con número <b>{{$extras['num_expediente_ati']}}</b>.
                        </p>
                        <p>
                            Auditoría Técnica de la inspección.
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