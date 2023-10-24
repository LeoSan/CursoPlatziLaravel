<?php

namespace Database\Seeders;

use App\Models\Catalogo;
use App\Models\CatalogoElemento;
use App\Models\Formulario;
use App\Models\FormularioSeccion;
use App\Models\FormularioSeccionPregunta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormulariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cat = Catalogo::whereCodigo('tipos_inspeccion')->first();
        $cat_estatus = Catalogo::whereCodigo('estatus_formularios')->first();
        $asesoriaTecnica = CatalogoElemento::whereCodigo('asesoria_tecnica')->whereCatalogoId($cat->id)->first();
        $ordinaria = CatalogoElemento::whereCodigo('ordinaria')->whereCatalogoId($cat->id)->first();
        $extraordinaria = CatalogoElemento::whereCodigo('extraordinaria')->whereCatalogoId($cat->id)->first();
        $activo = CatalogoElemento::whereCodigo('formulario_activo')->whereCatalogoId($cat_estatus->id)->first();

        $formulario = Formulario::updateOrCreate([
            'nombre'=>'Inpección de asesoría técnica',
            'tipo_inspeccion_id'=>$asesoriaTecnica->id,
            'estatus_id'=>$activo->id
        ]);
        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Oficio "Orden de Inspección de Asesoría"',
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate([
            'pregunta'=>'<p>Se precisa el centro de trabajo a inspeccionar, su ubicaci&oacute;n, objetivo y alcance de la diligencia, fundamento legal, n&uacute;meros telef&oacute;nicos de contacto para constatar los datos de dicha orden.</p>
<p><strong>Fundamento Legal: art 36 y 43 Ley de Inspecci&oacute;n del Trabajo.</strong></p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se conforma expediente con caratula, asignaci&oacute;n de n&uacute;mero y datos principales del expediente?</p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);

        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Ejecución de Inspección',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se ejecut&oacute; mediaci&oacute;n entre patrono y trabajadores para la atenci&oacute;n de incumplimientos?</p>
        <p><strong>Fundamento Legal: Art&iacute;culo 31 del Reglamento de la LIT</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se hace revisi&oacute;n del listado de documentos en la inspecci&oacute;n en su caso?</p>
        <p><strong>Art&iacute;culo 50 de la LIT</strong></p>',
            'seccion_id'=>$seccion->id,
'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se hicieron constar las preguntas y respuestas en un Anexo especial del acta (objeto de la inspecci&oacute;n)?</p>
        <p><strong>Segundo p&aacute;rrafo del art&iacute;culo 49 de la LIT</strong></p>',
        'seccion_id'=>$seccion->id,
'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se le hizo saber al entrevistado o a la entrevistada que las declaraciones eran confidenciales?&nbsp;</p>
        <p><strong>Art&iacute;culo 49 de la LIT</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se detalla el nombre, generales y n&uacute;mero de c&eacute;dula de las personas entrevistadas que rinden testimonio?</p>
        <p><strong>Art&iacute;culo 49 de la LIT</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se entrevist&oacute; al trabajador o al patrono en privado?</p>
        <p><strong>Art&iacute;culo 49 de la LIT </strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;La inspecci&oacute;n se realiz&oacute; de forma inmediata una vez recibido el oficio de inspecci&oacute;n? &iquest;En caso de no ser as&iacute;, fue programada dentro del plazo de tres (3) d&iacute;as m&aacute;ximo?</p>
        <p><strong>Art&iacute;culo 17 del Reglamento de la LIT</strong></p>',
        'seccion_id'=>$seccion->id,
'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se encuentra en el expediente constancia de credenciales vigentes del Inspector que ejecut&oacute; la inspecci&oacute;n?</p>
        <p><strong>&nbsp;</strong><strong>Fundamento Legal: art 43 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se cuenta con acuse de recibido de la orden de inspecci&oacute;n de asesor&iacute;a al patrono, a los trabajadores o a los representantes de &eacute;stos para iniciar la inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 43 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Ingreso el inspector del trabajo en d&iacute;as y horas en los cuales el centro de trabajo estaba laborando?</p>
        <p><strong>&nbsp;</strong><strong>Fundamento Legal: art 39 Ley de Inspecci&oacute;n de Trabajo</strong>&nbsp;</p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);

        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Acta Circunstanciada',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se cuenta en el acta documentos presentados por la parte patronal, trabajador o representante de ambos, en su caso, que subsane alg&uacute;n hecho o situaci&oacute;n detectada en la inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 52 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Los hechos investigados y constatados por el inspector est&aacute;n directamente relacionados con el objeto de la inspecci&oacute;n?</p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;El acta inicial de inspecci&oacute;n cuenta con los datos requeridos por la Ley?</p>
        <ul>
        <li>Nombre del patrono</li>
        <li>Direcci&oacute;n de centro de trabajo</li>
        <li>D&iacute;a en que se practica la Diligencia</li>
        <li>Tipo de inspecci&oacute;n</li>
        <li>N&uacute;mero y fecha de orden de inspecci&oacute;n</li>
        <li>Lista de documentos a exhibir por patrono</li>
        <li>Aspectos para revisar</li>
        <li>Fundamento legal</li>
        </ul>
        <p><strong>&nbsp;</strong><strong>Art&iacute;culo 41 de la LIT y 23 del reglamento</strong>&nbsp;</p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se anexan documentos de evidencia que respalden el acta circunstanciada?</p>
        <p><strong>Fundamento Legal: art 51 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);

        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Medidas preventivas y correctivas',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>C&oacute;mo resultado de la visita de seguimiento &iquest;Se ha ordenado una inspecci&oacute;n extraordinaria o se ha iniciado el Procedimiento Administrativo Sancionador?</p>
        <p><strong>Fundamento Legal: art 38 Ley de Inspecci&oacute;n de Trabajo y 30 de su reglamento</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se otorg&oacute; por UNA (1) sola vez una pr&oacute;rroga de los plazos otorgados para corregir deficiencias o incumplimientos, a petici&oacute;n de la parte interesada?</p>
        <p><strong>Fundamento Legal: art 55 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se estableci&oacute; un m&iacute;nimo de dos (2) visitas de seguimiento para corroborar la atenci&oacute;n de la prevenci&oacute;n o correcci&oacute;n establecida?</p>
        <p><strong>Fundamento Legal: art 38 Ley de Inspecci&oacute;n de Trabajo y 29 de su reglamento</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se aplicaron los plazos adecuados para el cumplimiento de a la prevenci&oacute;n o correcci&oacute;n?</p>
        <p><strong>Fundamento Legal: art&iacute;culos 37 Ley de Inspecci&oacute;n de Trabajo y 30 de su reglamento</strong></p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;La asesor&iacute;a tuvo como resultados acciones de prevenci&oacute;n o correcci&oacute;n?</p>
        <p><strong>Fundamento Legal: art&iacute;culos 37 Ley de Inspecci&oacute;n de Trabajo y 29, 30 de su reglamento</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);

        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Procedimiento Administrativo Sancionador (PAS)',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Las notificaciones establecidas cumplen con lo establecido en la Normatividad Aplicable?</p>
        <p><strong>Fundamento Legal: art 70, 71 y 72 de la Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;El acto de emplazamiento cuenta con las formalidades establecidas en la normativa?</p>
        <p><strong>Fundamento Legal: art 69 de la Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se emplaz&oacute; al patrono dentro de los dos (2) d&iacute;as siguientes a la solicitud de inicio del proceso administrativo sancionador?</p>
        <p><strong>Fundamento Legal: art 68 de la Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se elabor&oacute; la solicitud para el inicio del PAS al Jefe de Inspector Regional?</p>
        <p><strong>&nbsp;</strong><strong>Fundamento Legal: art 67 de la Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);

        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Términos de la Inspección',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>El inspector procedi&oacute; al archivo del acta por el resultado de los siguientes motivos:</p>
        <ol>
        <li>No contener requisitos de ley y por tanto se debi&oacute; anular y practicar nuevamente;</li>
        <li>No se constataron incumplimientos a la normativa legal</li>
        <li>Con las pruebas presentadas por el patrono se encontr&oacute; que cumpli&oacute; con normativa vigente</li>
        </ol>
        <p><strong>Fundamento Legal: art 58 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se detect&oacute; ampliaciones de acta en el expediente?</p>
        <p><strong>Fundamento Legal: art 41 Ley de Inspecci&oacute;n de Trabajo; art 25 del reglamento Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
 'formulario_id'=>$formulario->id
 ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Entreg&oacute; el acta al superior inmediato dentro del t&eacute;rmino de tres (3) d&iacute;as h&aacute;biles, contados a partir del d&iacute;a siguiente a que concluy&oacute; la inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 12.5 Ley de Inspecci&oacute;n de Trabajo; art 17 reglamento Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se encuentran constancias de informaci&oacute;n de los alcances y efectos de la inspecci&oacute;n a la contraparte (patrono, a los trabajadores y los representantes de ambos).</p>
        <p><strong>Fundamento Legal: art 30 de Ley de Inspecci&oacute;n de Trabajo 18 del reglamento</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>En casos de reprogramaci&oacute;n de Inspecci&oacute;n.<br />&iquest;Se ejecut&oacute; la inspecci&oacute;n de manera inmediata o en un m&aacute;ximo de tres (3) d&iacute;as posteriores a la fecha en que no se pudo realizar?&nbsp;</p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;El expediente se encuentra foliado en su completitud?</p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se cuenta con acuse de recibido de la(s) copia(s) de la(s) acta(s) de las partes involucradas en la inspecci&oacute;n?</p>
        <p>&nbsp;<strong>Fundamento Legal: art 45 de Ley de Inspecci&oacute;n de Trabajo 28 del reglamento</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);


        $formulario = Formulario::updateOrCreate([
            'nombre'=>'Auditoría de Inspección Ordinaria',
            'tipo_inspeccion_id'=>$ordinaria->id,
            'estatus_id'=>$activo->id
        ]);
        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Tipo de Inspección',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>En caso de ser una inspecci&oacute;n ordinaria. &iquest;Esta fue de Comprobaci&oacute;n?</p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>En caso de ser una inspecci&oacute;n ordinaria. &iquest;Esta fue Peri&oacute;dica?</p>',
        'seccion_id'=>$seccion->id,
'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>En caso de ser una inspecci&oacute;n ordinaria. &iquest;Esta fue Inicial?</p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);

        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Oficio "Órden de Inspección"',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se cuenta de primera instancia con fojas foliadas?</p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se conforma expediente con caratula, asignaci&oacute;n de n&uacute;mero y datos principales del expediente?</p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>Se precisa el centro de trabajo a inspeccionar, su ubicaci&oacute;n, objetivo y alcance de la diligencia, fundamento legal, n&uacute;meros telef&oacute;nicos de contacto para constatar los datos de dicha orden.</p>
        <p><strong>Fundamento Legal: art 43 Ley de Inspecci&oacute;n de Trabajo.</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);

        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Ejecución de Inspección',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Los hechos son relacionados con el objeto de la inspecci&oacute;n?</p>',
        'seccion_id'=>$seccion->id,
'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se hace revisi&oacute;n del listado de documentos en la inspecci&oacute;n?</p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>En caso de que las partes inspeccionadas no firmen &iquest;se hizo constar los hechos en el acta?</p>
        <p><strong>Fundamento Legal: art 53 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p><strong>&nbsp;</strong>&iquest;Se cuenta con constancia de acceso y toma de manifestaciones en el acta por parte de la parte inspeccionada?</p>
        <p><strong>Fundamento Legal: art 53 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se cuenta en el acta documentos presentados por la parte patronal, trabajador o representante de ambos en su caso que subsane alg&uacute;n hecho o situaci&oacute;n detectada en la inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 52 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se anexan documentos (copia) de evidencia que respalden el acta?</p>
        <p><strong>Fundamento Legal: art 51 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Incorpor&oacute; apreciaciones subjetivas o sin sustento el inspector en el acta circunstanciada al referirse a los documentos verificados durante la inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 50 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se describi&oacute; en el acta el contenido y caracter&iacute;sticas documentos solicitados en la orden de inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 50 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se detalla el nombre, generales y n&uacute;mero de c&eacute;dula de las personas que rinden testimonio?</p>
        <p><strong>Art&iacute;culo 49 de la LIT</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se hicieron constar las preguntas y respuestas en un anexo bajo reserva?</p>
        <p><strong>Segundo p&aacute;rrafo del art&iacute;culo 49 de la LIT</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se le hizo saber que las declaraciones eran confidenciales?&nbsp;</p>
        <p><strong>Art&iacute;culo 49 de la LIT</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se entrevist&oacute; al trabajador o al patrono en privado?</p>
        <p><strong>Art&iacute;culo 49 de la Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>En caso de que se haya detectado que el Centro de Trabajo emplea diez (10) o menos trabajadores y la empresa en su conjunto no tiene m&aacute;s establecimientos o sucursales &iquest;Se hace constar en acta circunstanciada para su reprogramaci&oacute;n de visita de asesor&iacute;a t&eacute;cnica?</p>
        <p><strong>Fundamento Legal: art 48 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>En caso de que no se haya podido efectuar la Inspecci&oacute;n en el d&iacute;a y hora establecidos &iquest;Se hace constar en acta circunstanciada para su reprogramaci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 47 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>En caso de que en el Centro de Trabajo de haya negado el acceso al inspector &iquest;Se hace constar en acta circunstanciada?</p>
        <p><strong>Fundamento Legal: art 46 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se ejecuta inspecci&oacute;n por ampliaci&oacute;n o modificaci&oacute;n del Centro de Trabajo?</p>
        <p><strong>Fundamento Legal: art 39 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>En caso de que la inspecci&oacute;n se realiz&oacute; en tiempo inh&aacute;bil &iquest;Se cuenta con la debida formalidad por parte de las autoridades del Trabajo?</p>
        <p><strong>Fundamento Legal: art 39 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se cuenta con orden espec&iacute;fica para constatar el cumplimiento de las medidas emplazadas u ordenadas previamente por el Inspector del Trabajo?</p>
        <p><strong>Fundamento Legal: art 39 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se tom&oacute; en consideraci&oacute;n la actividad econ&oacute;mica, la naturaleza de las actividades que realicen, su grado de riesgo, n&uacute;mero de trabajadores y ubicaci&oacute;n geogr&aacute;fica para la programaci&oacute;n de la Inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 39 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
'formulario_id'=>$formulario->id
]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>Derivado de Inspecciones anteriores &iquest;La inspecci&oacute;n se ejecut&oacute; de acuerdo con los tiempos regulados por la Ley?</p>
        <p><strong>Fundamento Legal: art 39 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se ejecuta inspecci&oacute;n por primera vez en el Centro de Trabajo?</p>
        <p><strong>Fundamento Legal: art 39 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;La inspecci&oacute;n se realiz&oacute; de forma inmediata una vez recibido el oficio de inspecci&oacute;n? En caso de no ser as&iacute;. &iquest;Fue programada dentro del plazo de tres (3) d&iacute;as m&aacute;ximo?</p>
        <p><strong>Art&iacute;culo 17 del Reglamento de la LIT</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;El acta inicial de inspecci&oacute;n cuenta con los datos requeridos?</p>
        <ul>
        <li>Nombre del patrono</li>
        <li>Direcci&oacute;n de centro de trabajo</li>
        <li>D&iacute;a en que se practica la Diligencia</li>
        <li>Tipo de inspecci&oacute;n</li>
        <li>N&uacute;mero y fecha de orden de inspecci&oacute;n</li>
        <li>Lista de documentos a exhibir por patrono</li>
        <li>Aspectos para revisar</li>
        <li>Fundamento legal</li>
        </ul>
        <p><strong>&nbsp;</strong><strong>Art&iacute;culo 41 de la LIT y 23 del reglamento</strong>&nbsp;</p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se encuentra en el expediente constancia de credenciales vigentes en el momento en que el Inspector ejecut&oacute; la inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 43 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Ingreso el inspector del trabajo en d&iacute;as y horas en los cuales el centro de trabajo estaba laborando?</p>
        <p><strong>&nbsp;</strong><strong>Fundamento Legal: art 39 y 43 Ley de Inspecci&oacute;n de Trabajo</strong>&nbsp;</p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se cuenta con acuse de recibido de la orden de inspecci&oacute;n al patrono, a los trabajadores o a los representantes de &eacute;stos para iniciar la inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 43 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);

        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Medidas preventivas y correctivas',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>En caso de incumplimiento de medidas ordenadas &iquest;Se solicit&oacute; el inicio del procedimiento administrativo sancionador?</p>
        <p><strong>Fundamento Legal: art 57 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se hace constar el oficio de transcurso del t&eacute;rmino?</p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>En caso de que se realizar&aacute; una petici&oacute;n de prorroga con fundamentos apegados a derecho &iquest;Se otorg&oacute; prorroga, a petici&oacute;n de la parte interesada?</p>
        <p><strong>Fundamento Legal: art 55 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>En caso de deficiencias e incumplimientos relativos a la libertad de asociaci&oacute;n o libre sindicalizaci&oacute;n &iquest;se estableci&oacute; el plazo de 3 d&iacute;as para realizar correcciones?</p>
        <p><strong>Fundamento Legal: art&iacute;culos 54 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>Si se detect&oacute; casos de Peligro o Riesgo Inminente &iquest;se establecieron correcciones inmediatas y de observancia permanente?</p>
        <p><strong>Fundamento Legal: art&iacute;culos 54 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se emiti&oacute; el emplazamiento documental, en el cual se se&ntilde;alan las medidas ordenadas y el plazo dentro del cual deben implementarse o bien, el plazo para exhibir la documentaci&oacute;n que acredite el cumplimiento de sus obligaciones, documentaci&oacute;n que el inspector est&aacute; obligado a verificar con los afectados, acta que debe ser firmada por su patrono o representante y notificada a los trabajadores o sus representantes?</p>
        <p><strong>Fundamento Legal: art&iacute;culos 56 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;La inspecci&oacute;n tuvo como resultados infracciones a la normativa Laboral?</p>
        <p><strong>Fundamento Legal: art&iacute;culos 54 Ley de Inspecci&oacute;n de Trabajo </strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);


        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Procedimiento Administrativo Sancionador (PAS)',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Las notificaciones establecidas cumplen con lo establecido en la Normatividad Aplicable?</p>
        <p><strong>Fundamento Legal: art 70, 71 y 72 de la Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;El acto de emplazamiento cuenta con las formalidades establecidas en la normativa?</p>
        <p><strong>Fundamento Legal: art 69 de la Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
 'formulario_id'=>$formulario->id
 ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se emplaz&oacute; al patrono dentro de los dos (2) d&iacute;as siguientes a la solicitud de inicio del proceso administrativo sancionador?</p>
        <p><strong>Fundamento Legal: art 68 de la Ley de Inspecci&oacute;n de Trabajo</strong></p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se elabor&oacute; la solicitud para el inicio del PAS al Jefe de Inspector regional?</p>
        <p><strong>&nbsp;</strong><strong>Fundamento Legal: art 67 de la Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);

        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Plazos de la Inspección',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>El inspector procedi&oacute; al archivo del acta por el resultado de los siguientes motivos:</p>
        <ol>
        <li>No contener requisitos de ley y por tanto se debi&oacute; anular y practicar nuevamente;</li>
        <li>No se constataron incumplimientos a la normativa legal</li>
        <li>Con las pruebas presentadas por el patrono se encontr&oacute; que cumpli&oacute; con normativa vigente</li>
        </ol>
        <p><strong>Fundamento Legal: art 58 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se detecto ampliaciones de acta en el expediente?</p>
        <p><strong>Fundamento Legal: art 41 Ley de Inspecci&oacute;n de Trabajo; art 25 del reglamento Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
 'formulario_id'=>$formulario->id
 ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Entreg&oacute; el acta al superior inmediato dentro del t&eacute;rmino de tres (3) d&iacute;as h&aacute;biles, contados a partir del d&iacute;a siguiente a que concluy&oacute; la inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 12.5 Ley de Inspecci&oacute;n de Trabajo; art 17 reglamento Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se encuentran constancias de informaci&oacute;n de los alcances y efectos de la inspecci&oacute;n a la contraparte (patrono, a los trabajadores y los representantes de ambos).</p>
        <p><strong>Fundamento Legal: art 30 de Ley de Inspecci&oacute;n de Trabajo 18 del reglamento</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se ejecut&oacute; la inspecci&oacute;n de manera inmediata o en un m&aacute;ximo de tres (3) d&iacute;as posteriores a la fecha en que no se pudo realizar?&nbsp;</p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se cuenta con acuse de recibido de la(s) copia(s) de la(s) acta(s) de las partes involucradas en la inspecci&oacute;n?</p>
        <p>&nbsp;<strong>Fundamento Legal: art 45 de Ley de Inspecci&oacute;n de Trabajo 28 del reglamento</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);


        $formulario = Formulario::updateOrCreate([
            'nombre'=>'Auditoría de Inspección Extraordinaria',
            'tipo_inspeccion_id'=>$extraordinaria->id,
            'estatus_id'=>$activo->id
        ]);

        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Forma de Expediente',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se cuenta de primera instancia con fojas foliadas?</p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se conforma expediente con caratula, asignaci&oacute;n de n&uacute;mero y datos principales del expediente?</p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);

        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Ejecución de Inspección',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se hicieron constar las preguntas y respuestas en un anexo bajo reserva?</p>
        <p><strong>Segundo p&aacute;rrafo del art&iacute;culo 49 de la LIT</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se le hizo saber al interrogado que las declaraciones eran confidenciales?&nbsp;</p>
        <p><strong>Art&iacute;culo 49 de la LIT</strong></p>',
        'seccion_id'=>$seccion->id,
'formulario_id'=>$formulario->id
]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se detalla el nombre, generales y n&uacute;mero de c&eacute;dula de las personas que rinden testimonio?</p>
        <p><strong>Art&iacute;culo 49 de la LIT</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se entrevist&oacute; al trabajador o al patrono en privado?</p>
        <p><strong>Art&iacute;culo 49 de la LIT </strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;La inspecci&oacute;n se realiz&oacute; de forma inmediata una vez recibido el oficio de inspecci&oacute;n? &iquest;En caso de no ser as&iacute;, fue programada dentro del plazo de tres (3) d&iacute;as m&aacute;ximo?</p>
        <p><strong>Art&iacute;culo 17 del Reglamento de la LIT</strong></p>',
        'seccion_id'=>$seccion->id,
'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se encuentra en el expediente constancia de credenciales vigentes en el momento en que el Inspector ejecut&oacute; la inspecci&oacute;n?</p>
        <p><strong>&nbsp;</strong><strong>Fundamento Legal: art 43 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
            ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se cuenta con acuse de recibido de la orden de inspecci&oacute;n al patrono, a los trabajadores o a los representantes de &eacute;stos para iniciar la inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 43 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
'formulario_id'=>$formulario->id
]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se practic&oacute; de manera inmediata la inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 42 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
'formulario_id'=>$formulario->id
]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;La inspecci&oacute;n realizada est&aacute; legitimada de acuerdo con lo que establece la Ley?</p>
        <p>Se orden&oacute; la inspecci&oacute;n extraordinaria por alguna de las circunstancias siguientes:</p>
        <ul>
        <li>Tengan conocimiento que existe un Peligro o Riesgo Inminente;</li>
        <li>Cuando reciban quejas o denuncias por cualquier medio o forma de posibles incumplimientos a la legislaci&oacute;n laboral; o bien, cuando se enteren por cualquier conducto verbal o escrito, de probables incumplimientos a las normas de trabajo; en estos casos la inspecci&oacute;n debe iniciarse en un plazo m&aacute;ximo de cinco (5) d&iacute;as h&aacute;biles. En caso de que la denuncia o queja la interponga el trabajador, la informaci&oacute;n que revele su nombre o identidad debe ser declarada bajo reserva por la Autoridad del Trabajo a petici&oacute;n del denunciante, sin perjuicio del derecho de defensa que asista a la parte denunciada;</li>
        <li>Cuando al revisar la documentaci&oacute;n presentada para cualquier efecto, se percate de posibles irregularidades imputables al patrono o al trabajador que &eacute;ste se condujo con falsedad;</li>
        <li>Tengan conocimiento de accidentes o siniestros ocurridos en los Centros de Trabajo;</li>
        <li>Cuando en el desarrollo de una Inspecci&oacute;n previa o en la presentaci&oacute;n de documentos ante la Autoridad del Trabajo, el patrono o el trabajador o sus representantes proporcionen informaci&oacute;n falsa o se conduzcan con dolo, mala fe o violencia; y,</li>
        <li>Se detecten actas de Inspecci&oacute;n o documentos que carezcan de los requisitos establecidos en las disposiciones jur&iacute;dicas aplicables o en aquellas de las que se desprendan elementos para presumir que el Inspector del Trabajo incurri&oacute; en conductas irregulares.</li>
        </ul>
        <p><strong>Fundamento Legal: art 40 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
'formulario_id'=>$formulario->id
]);

        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Acta circunstanciada',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>En caso de que las partes inspeccionadas no firmen &iquest;se hizo constar los hechos en el acta?</p>
        <p><strong>Fundamento Legal: art 53 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se cuenta con constancia de acceso y toma de manifestaciones en el acta por parte de la parte inspeccionada?</p>
        <p><strong>Fundamento Legal: art 53 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se cuenta en el acta documentos presentados por la parte patronal, trabajador o representante de ambos en su caso que subsane alg&uacute;n hecho o situaci&oacute;n detectada en la inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 52 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se anexan documentos de evidencia que respalden el acta circunstanciada?</p>
        <p><strong>Fundamento Legal: art 51 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Incorpor&oacute; apreciaciones subjetivas o sin sustento el inspector en el acta circunstanciada al referirse a los documentos verificados durante la inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 50 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se describi&oacute; el contenido y caracter&iacute;sticas documentos solicitados en la orden de inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 50 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);


        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Medidas preventivas y correctivas',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>C&oacute;mo resultado de la visita de seguimiento &iquest;Se ha ordenado una inspecci&oacute;n ordinaria de comprobaci&oacute;n o se ha iniciado el Procedimiento Administrativo Sancionador?</p>
        <p><strong>Fundamento Legal: art 38 Ley de Inspecci&oacute;n de Trabajo y 30 de su reglamento</strong></p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se orden&oacute; y atendi&oacute; inspecci&oacute;n de comprobaci&oacute;n de las medidas ordenadas dentro de los tres (3) d&iacute;as h&aacute;biles siguientes al vencimiento del plazo otorgado para su cumplimiento?</p>
        <p><strong>Fundamento Legal: art&iacute;culos 54 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se aplicaron los plazos adecuados para el cumplimiento de comprobaci&oacute;n de las medidas ordenadas?</p>
        <p><strong>Fundamento Legal: art&iacute;culos 37 Ley de Inspecci&oacute;n de Trabajo y 30 de su reglamento</strong></p>',
            'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>Si se detect&oacute; casos de Peligro o Riesgo Inminente &iquest;Se establecieron correcciones inmediatas y de observancia permanente?</p>
        <p><strong>Fundamento Legal: art&iacute;culos 54 Ley de Inspecci&oacute;n de Trabajo.</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);

        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Procedimiento Administrativo Sancionador (PAS)',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Las notificaciones establecidas cumplen con lo establecido en la Normatividad Aplicable?</p>
        <p><strong>Fundamento Legal: art 70, 71 y 72 de la Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;El acto de emplazamiento cuenta con las formalidades establecidas en la normativa?</p>
        <p><strong>Fundamento Legal: art 69 de la Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se emplaz&oacute; al patrono dentro de los dos (2) d&iacute;as siguientes a la solicitud de inicio del proceso administrativo sancionador?</p>
        <p><strong>Fundamento Legal: art 68 de la Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se elabor&oacute; la solicitud para el inicio del PAS al Jefe de Inspector regional?</p>
        <p><strong>&nbsp;</strong><strong>Fundamento Legal: art 67 de la Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);

        $seccion = FormularioSeccion::updateOrCreate([
            'nombre'=>'Términos de la Inspección',
            'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>El inspector procedi&oacute; al archivo del acta por el resultado de los siguientes motivos:</p>
        <ol>
        <li>No contener requisitos de ley y por tanto se debi&oacute; anular y practicar nuevamente;</li>
        <li>No se constataron incumplimientos a la normativa legal</li>
        <li>Con las pruebas presentadas por el patrono se encontr&oacute; que cumpli&oacute; con normativa vigente</li>
        </ol>
        <p><strong>Fundamento Legal: art 58 Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se detect&oacute; ampliaciones de acta en el expediente?</p>
        <p><strong>Fundamento Legal: art 41 Ley de Inspecci&oacute;n de Trabajo; art 25 del reglamento Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Entreg&oacute; el acta al superior inmediato dentro del t&eacute;rmino de tres (3) d&iacute;as h&aacute;biles, contados a partir del d&iacute;a siguiente a que concluy&oacute; la inspecci&oacute;n?</p>
        <p><strong>Fundamento Legal: art 12.5 Ley de Inspecci&oacute;n de Trabajo; art 17 reglamento Ley de Inspecci&oacute;n de Trabajo</strong></p>',
        'seccion_id'=>$seccion->id,
 'formulario_id'=>$formulario->id
 ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se encuentran constancias de informaci&oacute;n de los alcances y efectos de la inspecci&oacute;n a la contraparte (patrono, a los trabajadores y los representantes de ambos)?.</p>
        <p><strong>Fundamento Legal: art 30 de Ley de Inspecci&oacute;n de Trabajo 18 del reglamento</strong></p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Se ejecut&oacute; la inspecci&oacute;n de manera inmediata o en un m&aacute;ximo de tres (3) d&iacute;as posteriores a la fecha en que no se pudo realizar?&nbsp;</p>',
        'seccion_id'=>$seccion->id,
        'formulario_id'=>$formulario->id
        ]);
        FormularioSeccionPregunta::updateOrCreate(['pregunta'=>'<p>&iquest;Los hechos son relacionados con el objeto de la inspecci&oacute;n?</p>',
        'seccion_id'=>$seccion->id,
'formulario_id'=>$formulario->id
        ]);
    }
}
