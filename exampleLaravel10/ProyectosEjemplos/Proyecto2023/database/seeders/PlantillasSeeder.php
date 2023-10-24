<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{ CatalogoElemento, Plantilla };

class PlantillasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $plantilla_seccion = CatalogoElemento::whereCodigo('seccion_resultados_preliminares')->first()->id;
        Plantilla::updateOrCreate(['seccion_id'=>$plantilla_seccion,'nombre'=>'Informe Preliminar','contenido'=>'<table style="border-collapse: collapse; width: 99.9625%; border-color: #000000; border-style: solid; height: 89.5832px;" border="1">
        <tbody>
        <tr style="height: 22.3958px;">
        <td style="width: 14.7469%; height: 44.7916px;" rowspan="2"><strong>N&uacute;mero de auditor&iacute;a:</strong></td>
        <td style="width: 9.34345%; height: 44.7916px;" rowspan="2">&nbsp;</td>
        <td style="text-align: center; width: 46.4921%; height: 44.7916px;" rowspan="2"><strong><span style="background-color: #fbeeb8;">Unidad Auditada</span></strong></td>
        <td style="width: 9.56859%; height: 22.3958px;"><strong>Elabor&oacute;:</strong></td>
        <td style="width: 19.8126%; height: 22.3958px;">&nbsp;</td>
        </tr>
        <tr style="height: 22.3958px;">
        <td style="width: 9.56859%; height: 22.3958px;"><strong>Revis&oacute;:</strong></td>
        <td style="width: 19.8126%; height: 22.3958px;">&nbsp;</td>
        </tr>
        <tr style="height: 22.3958px;">
        <td style="width: 14.7469%; height: 44.7916px;" rowspan="2"><strong>Tipo de c&eacute;dula:</strong></td>
        <td style="width: 9.34345%; height: 44.7916px;" rowspan="2">Anal&iacute;tica</td>
        <td style="text-align: center; width: 46.4921%; height: 44.7916px;" rowspan="2"><span style="background-color: #fbeeb8;"><strong>Concepto por revisar</strong></span></td>
        <td style="width: 9.56859%; height: 22.3958px;"><strong>Aprob&oacute;:</strong></td>
        <td style="width: 19.8126%; height: 22.3958px;">&nbsp;</td>
        </tr>
        <tr style="height: 22.3958px;">
        <td style="width: 9.56859%; height: 22.3958px;"><strong>Fecha:</strong></td>
        <td style="width: 19.8126%; height: 22.3958px;">&nbsp;</td>
        </tr>
        </tbody>
        </table>
        <p style="text-align: center;"><strong>Informe Preliminar<br /></strong></p>
        <ol>
        <li style="text-align: justify;">Oficio "Orden de inspecci&oacute;n de asesor&iacute;a"
        <ul>
        <li style="text-align: justify;">Observaci&oacute;n 1: <span style="background-color: #fbeeb8;">(descripci&oacute;n de la observaci&oacute;n sobre incumplimiento de criterios y el funcionamiento legal que le pertenece)</span></li>
        <li style="text-align: justify;">Observaci&oacute;n 2:</li>
        <li style="text-align: justify;">Observaci&oacute;n 3:</li>
        </ul>
        </li>
        <li style="text-align: justify;">Ejecuci&oacute;n de inspecci&oacute;n
        <ul>
        <li style="text-align: justify;">Observaci&oacute;n 1: <span style="background-color: #fbeeb8;">(descripci&oacute;n de la observaci&oacute;n y el funcionamiento legal que le pertenece)</span></li>
        <li style="text-align: justify;">Observaci&oacute;n 2:</li>
        <li style="text-align: justify;">Observaci&oacute;n 3:</li>
        </ul>
        </li>
        <li style="text-align: justify;">Acta circunstanciada
        <ul>
        <li style="text-align: justify;">Observaci&oacute;n 1: <span style="background-color: #fbeeb8;">(descripci&oacute;n de la observaci&oacute;n y el funcionamiento legal que le pertenece)</span></li>
        <li style="text-align: justify;">Observaci&oacute;n 2:</li>
        <li style="text-align: justify;">Observaci&oacute;n 3:</li>
        </ul>
        </li>
        <li style="text-align: justify;">Medidas preventivas y correctivas
        <ul>
        <li style="text-align: justify;">Observaci&oacute;n 1: <span style="background-color: #fbeeb8;">(descripci&oacute;n de la observaci&oacute;n y el funcionamiento legal que le pertenece)</span></li>
        <li style="text-align: justify;">Observaci&oacute;n 2:</li>
        <li style="text-align: justify;">Observaci&oacute;n 3:</li>
        </ul>
        </li>
        <li style="text-align: justify;">Procedimiento administrativo sancionador
        <ul>
        <li style="text-align: justify;">Observaci&oacute;n 1: <span style="background-color: #fbeeb8;">(descripci&oacute;n de la observaci&oacute;n y el funcionamiento legal que le pertenece)</span></li>
        <li style="text-align: justify;">Observaci&oacute;n 2:</li>
        <li style="text-align: justify;">Observaci&oacute;n 3:</li>
        </ul>
        </li>
        <li style="text-align: justify;">T&eacute;rminos de la inspecci&oacute;n (en caso de que aplique)
        <ul>
        <li style="text-align: justify;">Observaci&oacute;n 1: <span style="background-color: #fbeeb8;">(descripci&oacute;n de la observaci&oacute;n y el funcionamiento legal que le pertenece)</span></li>
        <li style="text-align: justify;">Observaci&oacute;n 2:</li>
        <li style="text-align: justify;">Observaci&oacute;n 3:</li>
        </ul>
        </li>
        </ol>
        <p style="text-align: justify;">&nbsp;</p>
        <p style="text-align: justify;">&nbsp;</p>']);

        $plantilla_seccion = CatalogoElemento::whereCodigo('seccion_cedulas_de_trabajo')->first()->id;
        Plantilla::updateOrCreate(['seccion_id'=>$plantilla_seccion,'nombre'=>'Cédula de trabajo','contenido'=>'<p style="text-align: center;">&nbsp;</p>
        <table style="border-collapse: collapse; width: 100%; border-color: #000000; border-style: solid;" border="1">
        <tbody>
        <tr>
        <td style="width: 12.8757%;" rowspan="2"><strong>N&uacute;mero de auditor&iacute;a:</strong></td>
        <td style="width: 13.569%;" rowspan="2">&nbsp;</td>
        <td style="text-align: center; width: 45.9562%;" rowspan="2"><span style="background-color: #fbeeb8;"><strong>Unidad Auditada</strong></span></td>
        <td style="width: 7.62636%;"><strong>Elabor&oacute;:</strong></td>
        <td style="width: 20.0068%;">&nbsp;</td>
        </tr>
        <tr>
        <td style="width: 7.62636%;"><strong>Revis&oacute;</strong></td>
        <td style="width: 20.0068%;">&nbsp;</td>
        </tr>
        <tr>
        <td style="width: 12.8757%;" rowspan="2"><strong>Tipo de c&eacute;dula:</strong><strong><br /></strong></td>
        <td style="width: 13.569%;" rowspan="2">Anal&iacute;tica</td>
        <td style="text-align: center; width: 45.9562%;" rowspan="2"><span style="background-color: #fbeeb8;"><span style="background-color: #fbeeb8;">Concepto por revisar</span></span><span style="background-color: #fbeeb8;"><br /></span></td>
        <td style="width: 7.62636%;"><strong>Aprob&oacute;:</strong></td>
        <td style="width: 20.0068%;">&nbsp;</td>
        </tr>
        <tr>
        <td style="width: 7.62636%;"><strong>Fecha:</strong></td>
        <td style="width: 20.0068%;">&nbsp;</td>
        </tr>
        </tbody>
        </table>
        <p style="text-align: center;"><strong>C&eacute;dula de trabajo</strong></p>
        <table style="border-collapse: collapse; width: 100.032%; border-color: #000000; border-style: solid;" border="1">
        <tbody>
        <tr style="background-color: #72d8d8;">
        <td style="width: 98.592%; background-color: #72d8d8;"><strong>Alcance:</strong></td>
        </tr>
        <tr>
        <td style="width: 98.592%;">&nbsp;</td>
        </tr>
        <tr>
        <td style="width: 98.592%; background-color: #72d8d8;"><strong>Trabajo desarrollado:</strong></td>
        </tr>
        <tr>
        <td style="width: 98.592%;">&nbsp;</td>
        </tr>
        <tr>
        <td style="width: 98.592%; background-color: #72d8d8;"><strong>Conclusi&oacute;n:</strong></td>
        </tr>
        <tr>
        <td style="width: 98.592%;">&nbsp;</td>
        </tr>
        </tbody>
        </table>']);

        $plantilla_seccion = CatalogoElemento::whereCodigo('seccion_cierre_auditoria')->first()->id;
        Plantilla::updateOrCreate(['seccion_id'=>$plantilla_seccion,'nombre'=>'Cédula confronta de auditoria trabajo','contenido'=>'<p style="text-align: center;">&nbsp;</p>
        <table style="border-collapse: collapse; width: 100%; border-color: #000000; border-style: solid;" border="1">
        <tbody>
        <tr>
        <td style="width: 12.8757%;" rowspan="2"><strong>N&uacute;mero de auditor&iacute;a:</strong></td>
        <td style="width: 13.569%;" rowspan="2">&nbsp;</td>
        <td style="text-align: center; width: 45.9562%;" rowspan="2"><span style="background-color: #fbeeb8;"><strong>Unidad Auditada</strong></span></td>
        <td style="width: 7.62636%;"><strong>Elabor&oacute;:</strong></td>
        <td style="width: 20.0068%;">&nbsp;</td>
        </tr>
        <tr>
        <td style="width: 7.62636%;"><strong>Revis&oacute;</strong></td>
        <td style="width: 20.0068%;">&nbsp;</td>
        </tr>
        <tr>
        <td style="width: 12.8757%;" rowspan="2"><strong>Tipo de c&eacute;dula:</strong><strong><br /></strong></td>
        <td style="width: 13.569%;" rowspan="2">Anal&iacute;tica</td>
        <td style="text-align: center; width: 45.9562%;" rowspan="2"><span style="background-color: #fbeeb8;"><span style="background-color: #fbeeb8;">Concepto por revisar</span></span><span style="background-color: #fbeeb8;"><br /></span></td>
        <td style="width: 7.62636%;"><strong>Aprob&oacute;:</strong></td>
        <td style="width: 20.0068%;">&nbsp;</td>
        </tr>
        <tr>
        <td style="width: 7.62636%;"><strong>Fecha:</strong></td>
        <td style="width: 20.0068%;">&nbsp;</td>
        </tr>
        </tbody>
        </table>
        <p style="text-align: center;"><strong>C&eacute;dula de trabajo</strong></p>
        <table style="border-collapse: collapse; width: 100.032%; border-color: #000000; border-style: solid;" border="1">
        <tbody>
        <tr style="background-color: #72d8d8;">
        <td style="width: 98.592%; background-color: #72d8d8;"><strong>Alcance:</strong></td>
        </tr>
        <tr>
        <td style="width: 98.592%;">&nbsp;</td>
        </tr>
        <tr>
        <td style="width: 98.592%; background-color: #72d8d8;"><strong>Trabajo desarrollado:</strong></td>
        </tr>
        <tr>
        <td style="width: 98.592%;">&nbsp;</td>
        </tr>
        <tr>
        <td style="width: 98.592%; background-color: #72d8d8;"><strong>Conclusi&oacute;n:</strong></td>
        </tr>
        <tr>
        <td style="width: 98.592%;">&nbsp;</td>
        </tr>
        </tbody>
        </table>']);

        $plantilla_seccion = CatalogoElemento::whereCodigo('seccion_inicio_proceso')->first()->id;
        Plantilla::updateOrCreate(['seccion_id'=>$plantilla_seccion,'nombre'=>'Acta de inicio de proceso de auditoría','contenido'=>'<p><strong>Plantilla de acta de inicio de proceso de auditor&iacute;a.</strong></p>
<p>lorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsum</p>
<p>lorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsum.</p>']);

        $plantilla_seccion = CatalogoElemento::whereCodigo('seccion_informe_auditoria')->first()->id;
        Plantilla::updateOrCreate(['seccion_id'=>$plantilla_seccion,'nombre'=>'Informe de auditoría','contenido'=>'<p><strong>Plantilla de informe de auditor&iacute;a.</strong></p>
<p>lorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsum</p>
<p>lorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsum.</p>']);

        $plantilla_seccion = CatalogoElemento::whereCodigo('seccion_cedula_hallazgos')->first()->id;
        Plantilla::updateOrCreate(['seccion_id'=>$plantilla_seccion,'nombre'=>'Cédula de hallazgos','contenido'=>'<p><strong>Plantilla cédula de hallazgos</strong></p>
<p>lorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsum</p>
<p>lorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsum.</p>']);

    }
}
