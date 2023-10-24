<?php

namespace App\Http\Controllers;

use App\Services\FoliosService;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use App\Models\{Formulario,
    Planeacion,
    Catalogo,
    CatalogoElemento,
    PlaneacionAuditoria,
    PlaneacionAuditoriaEjecucionListaRespuesta,
    PlaneacionAuditoriaEjecucionPlantilla,
    Plantilla,
    User,
    PlaneacionSolicitudExpediente,
    PlaneacionAuditoriaEjecucion,
    PlaneacionAuditoriaMes,
    GestionAuditoria,
    Documento};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\{Log, Mail, Response, Storage};
use App\Mail\{Notificacion};
use Illuminate\Support\Facades\Validator;

class AuditoriasController extends Controller
{
    protected $foliador;
    public function __construct()
    {
        $this->foliador = new FoliosService();
    }
    public function index()
    {
        $catalogo = Catalogo::whereCodigo('estatus_plan_anual')->first();
        $auditores = User::permission('auditorias_ejecucion')->get();
        $estatus = $catalogo->elementos->filter(function ($elemento) {
            return $elemento->codigo === 'registrado' || $elemento->codigo === 'vigente';
        })->pluck('id')->toArray();
        $planeacionVigente = Planeacion::where('anio', date('Y'))->whereIn('estatus_id', $estatus)->first();

        if ($planeacionVigente && $planeacionVigente->ejecuciones->count() < 1) {
            PlaneacionesController::ejecucionVigencia($planeacionVigente);
        }
        return view('auditorias.index', compact('auditores'));
    }


    public function detalle(PlaneacionAuditoriaEjecucion $ejecucion)
    {
        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías', 'ruta' => route('planeaciones'), 'value' => ''],
            ['nombreComponente' => 'Ejecución de auditorías ' . date('Y'), 'ruta' => route('auditorias.ejecuciones'), 'value' => ''],
            ['nombreComponente' => $ejecucion->num_auditoria ?? 'Sin número asignado', 'ruta' => '', 'value' => 'active'],
        ];
        $acta_incumplimiento                              = $ejecucion->documentos()->whereHas('categoria',function($q){$q->whereCodigo('acta_incumplimiento_sin_expedientes');})->first();
        $solicitud_informacion                              = $ejecucion->solicitud ? $ejecucion->solicitud->documentos()->whereHas('categoria',function($q){$q->whereCodigo('oficio_solicitud_informacion_auditoria');})->first() : null;
        $ejecucion_auditoria                              = $ejecucion->solicitud ? $ejecucion->solicitud->documentos()->whereHas('categoria',function($q){$q->whereCodigo('oficio_orden_ejecucion_auditoria');})->first() : null;

        $elementos['acta_incumplimiento_sin_expedientes']  = $acta_incumplimiento;
        $elementos['oficio_solicitud_informacion_auditoria']  = $solicitud_informacion;
        $elementos['oficio_orden_ejecucion_auditoria']  = $ejecucion_auditoria;

        return view('auditorias.detalle.informacion', compact('ejecucion', 'breadcrumbs', 'elementos'));
    }

    public function ejecucionLista(PlaneacionAuditoriaEjecucion $ejecucion)
    {
        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías', 'ruta' => route('planeaciones'), 'value' => ''],
            ['nombreComponente' => 'Ejecución de auditorías ' . date('Y'), 'ruta' => route('auditorias.ejecuciones'), 'value' => ''],
            ['nombreComponente' => $ejecucion->num_auditoria ?? 'Sin número asignado', 'ruta' => route('auditorias.ejecucion.detalle', ['ejecucion' => $ejecucion->id]), 'value' => ''],
            ['nombreComponente' => 'Proceso de ejecución', 'ruta' => '', 'value' => 'active'],
            ['nombreComponente' => 'Lista de verificación', 'ruta' => '', 'value' => 'active'],
        ];
        $formulario = Formulario::where('tipo_inspeccion_id',$ejecucion->grupo->tipo_inspeccion_id)->first();
        $respuestas=[];
        if($formulario)
            foreach ($formulario->preguntas as $pregunta)
                $respuestas[$pregunta->id]=PlaneacionAuditoriaEjecucionListaRespuesta::whereEjecucionId($ejecucion->id)->wherePreguntaId($pregunta->id)->first();
        return view('auditorias.detalle.proceso.verificacion', compact('ejecucion', 'breadcrumbs','formulario','respuestas'));
    }

    public function storeEjecucionLista(PlaneacionAuditoriaEjecucion $ejecucion,Request $request)
    {
        $ejecucion->update([
            'proposito_lista'=>$request->proposito_lista,
            'fuentes_lista'=>$request->fuentes_lista
        ]);
        foreach ($request->preguntas as $k=>$pregunta){
            PlaneacionAuditoriaEjecucionListaRespuesta::updateOrCreate([
                'ejecucion_id'=>$ejecucion->id,
                'pregunta_id'=>$k
            ],[
                'ejecucion_id'=>$ejecucion->id,
                'pregunta_id'=>$k,
                'respuesta'=>@$pregunta['respuesta'],
                'observaciones'=>$pregunta['observaciones'],
            ]);
        }
        return redirect()->route('auditorias.ejecucion.proceso.cedulas', ['ejecucion' => $ejecucion])->with('success','Lista de verificación actualizada correctamente.');
    }

    public function ejecucionCedulas(Request $request, PlaneacionAuditoriaEjecucion $ejecucion)
    {
        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías', 'ruta' => route('planeaciones'), 'value' => ''],
            ['nombreComponente' => 'Ejecución de auditorías ' . date('Y'), 'ruta' => route('auditorias.ejecuciones'), 'value' => ''],
            ['nombreComponente' => $ejecucion->num_auditoria ?? 'Sin número asignado', 'ruta' => route('auditorias.ejecucion.detalle', ['ejecucion' => $ejecucion->id]), 'value' => ''],
            ['nombreComponente' => 'Proceso de ejecución', 'ruta' => route('auditorias.ejecucion.proceso.lista', ['ejecucion' => $ejecucion->id]), 'value' => ''],
            ['nombreComponente' => 'Cédulas de trabajo', 'ruta' => '', 'value' => 'active'],
        ];

        $seccion = CatalogoElemento::whereCodigo('seccion_cedulas_de_trabajo')->first();
        $plantillas = Plantilla::where('seccion_id', $seccion->id)->get();

        $plantillaSeleccionada = Plantilla::find($request->input('plantilla'));

        return view('auditorias.detalle.proceso.cedulas', compact('ejecucion', 'breadcrumbs', 'plantillas', 'plantillaSeleccionada', 'seccion'));
    }

    public function ejecucionResultados(Request $request, PlaneacionAuditoriaEjecucion $ejecucion)
    {
        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías', 'ruta' => route('planeaciones'), 'value' => ''],
            ['nombreComponente' => 'Ejecución de auditorías ' . date('Y'), 'ruta' => route('auditorias.ejecuciones'), 'value' => ''],
            ['nombreComponente' => $ejecucion->num_auditoria ?? 'Sin número asignado', 'ruta' => route('auditorias.ejecucion.detalle', ['ejecucion' => $ejecucion->id]), 'value' => ''],
            ['nombreComponente' => 'Proceso de ejecución', 'ruta' => route('auditorias.ejecucion.proceso.lista', ['ejecucion' => $ejecucion->id]), 'value' => ''],
            ['nombreComponente' => 'Resultados preliminares', 'ruta' => '', 'value' => 'active'],
        ];

        $seccion = CatalogoElemento::whereCodigo('seccion_resultados_preliminares')->first();
        $plantillas = Plantilla::where('seccion_id', $seccion->id)->get();

        $plantillaSeleccionada = Plantilla::find($request->input('plantilla'));

        return view('auditorias.detalle.proceso.resultados', compact('ejecucion', 'breadcrumbs', 'plantillas', 'plantillaSeleccionada', 'seccion'));
    }

    public function ejecucionCierre(Request $request, PlaneacionAuditoriaEjecucion $ejecucion)
    {
        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías', 'ruta' => route('planeaciones'), 'value' => ''],
            ['nombreComponente' => 'Ejecución de auditorías ' . date('Y'), 'ruta' => route('auditorias.ejecuciones'), 'value' => ''],
            ['nombreComponente' => $ejecucion->num_auditoria ?? 'Sin número asignado', 'ruta' => route('auditorias.ejecucion.detalle', ['ejecucion' => $ejecucion->id]), 'value' => ''],
            ['nombreComponente' => 'Proceso de ejecución', 'ruta' => route('auditorias.ejecucion.proceso.lista', ['ejecucion' => $ejecucion->id]), 'value' => ''],
            ['nombreComponente' => 'Acta de cierre de auditoría', 'ruta' => '', 'value' => 'active'],
        ];

        $seccion = CatalogoElemento::whereCodigo('seccion_cierre_auditoria')->first();
        $plantillas = Plantilla::where('seccion_id', $seccion->id)->get();

        $plantillaSeleccionada = Plantilla::find($request->input('plantilla'));

        $formulario = Formulario::where('tipo_inspeccion_id',$ejecucion->grupo->tipo_inspeccion_id)->first();
        $total_preguntas = $formulario?->preguntas->count();
        $total_respuestas = PlaneacionAuditoriaEjecucionListaRespuesta::whereEjecucionId($ejecucion->id)->whereNotNull('respuesta')->count();

        return view('auditorias.detalle.proceso.cierre', compact('ejecucion', 'breadcrumbs', 'plantillas', 'plantillaSeleccionada', 'seccion','total_preguntas','total_respuestas'));
    }

    public function showDetalleSolicitud($id)
    {

        $expediente = PlaneacionSolicitudExpediente::findOrFail($id);

        $estatus_plan_anual = Catalogo::whereCodigo('estatus_plan_anual')->first();
        $estatus_viegente_id = CatalogoElemento::where('catalogo_id', '=', $estatus_plan_anual->id)->whereCodigo('vigente')->first()->id;
        $auditorias          = Planeacion::where('estatus_id', $estatus_viegente_id)->first();
        $anio = isset($auditorias->anio)? $auditorias->anio : '(Sin plan anual)';
        $elementos['titulo_anio'] =  $anio;

        $codigo_oficio_orden_ejecucion  = CatalogoElemento::where('codigo', 'oficio_orden_ejecucion_auditoria')->first()->id;
        $codigo_oficio_solicitud_informacion  = CatalogoElemento::where('codigo', 'oficio_solicitud_informacion_auditoria')->first()->id;
        $codigo_acta_incumplimiento  = CatalogoElemento::where('codigo', 'acta_incumplimiento_auditoria')->first()->id;
        $codigo_oficio_solicitud_prorroga  = CatalogoElemento::where('codigo', 'oficio_solicitud_prorroga_expedientes')->first()->id;

        $doc_oficio_orden_ejecucion  = Documento::where('entidad_id', $expediente->id)->where('tipo_documento_id', $codigo_oficio_orden_ejecucion)->get();
        $doc_oficio_solicitud_informacion  = Documento::where('entidad_id', $expediente->id)->where('tipo_documento_id', $codigo_oficio_solicitud_informacion)->get();
        $doc_acta_incumplimiento  = Documento::where('entidad_id', $expediente->id)->where('tipo_documento_id', $codigo_acta_incumplimiento)->get();
        $doc_oficio_solicitud_prorroga  = Documento::where('entidad_id', $expediente->id)->where('tipo_documento_id', $codigo_oficio_solicitud_prorroga)->get();

        $total_recibido = 0;
        foreach($expediente->planeacion_auditorias as $grupo_auditoria){
            if($grupo_auditoria->planeacion_auditoria_mes($expediente->mes,$grupo_auditoria->id)->num_auditorias >0){
                foreach($grupo_auditoria->planeacion_auditoria_ejecuciones($expediente->mes,$grupo_auditoria->id) as $auditoria){
                    if($auditoria->tiene_expediente ){
                         $total_recibido = $total_recibido + 1;
                     }
                }
            }
        }

        $elementos['total_recibido']                         = $total_recibido;
        $elementos['oficio_orden_ejecucion_auditoria']       = $doc_oficio_orden_ejecucion;
        $elementos['oficio_solicitud_informacion_auditoria'] = $doc_oficio_solicitud_informacion;
        $elementos['acta_incumplimiento_auditoria']          = $doc_acta_incumplimiento;
        $elementos['doc_oficio_solicitud_prorroga']          = $doc_oficio_solicitud_prorroga;

        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías',  'ruta'=> route('planeaciones'), 'value'=>''],
            ['nombreComponente' => 'Solcitudes de expedientes '.$anio,       'ruta'=> route('auditorias.listado.solicitar.expediente'), 'value'=>''],
            ['nombreComponente' => 'Detalle',  'ruta'=> '', 'value'=>'active'],
        ];

        //Actualizo ejecucion con estatus en espera
        $ejecucion = PlaneacionAuditoriaEjecucion::whereHas('grupo',function($query)use($expediente){
            return $query->where('region_id',$expediente->regional_id);
        })->where('mes', $expediente->mes)->first();

        return view('auditorias.detalle-expediente',compact('ejecucion','breadcrumbs', 'expediente', 'elementos'));
    }

    public function showSolictudExpedientes()
    {
        $estatus_plan_anual  = Catalogo::whereCodigo('estatus_plan_anual')->first();
        $estatus_viegente_id = CatalogoElemento::where('catalogo_id', '=', $estatus_plan_anual->id)->whereCodigo('vigente')->first()->id;
        $auditorias          = Planeacion::where('estatus_id', $estatus_viegente_id)->first();
        $anio = isset($auditorias->anio)? $auditorias->anio : '(Sin plan anual)';
        $elementos['titulo_anio'] =  $anio;
        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías',  'ruta'=> route('planeaciones'), 'value'=>''],
            ['nombreComponente' => 'Solcitudes de expedientes '.$anio,  'ruta'=> "#", 'value'=>'active'],
        ];
        return view('auditorias.lista-solicitud-expediente', compact('elementos', 'breadcrumbs'));
    }

    public function showFormSolictudExpedientes()
    {
        $estatus_plan_anual  = Catalogo::whereCodigo('estatus_plan_anual')->first();
        $estatus_viegente_id = CatalogoElemento::where('catalogo_id', '=', $estatus_plan_anual->id)->whereCodigo('vigente')->first()->id;
        $auditorias          = Planeacion::where('estatus_id', $estatus_viegente_id)->first();
        $anio = isset($auditorias->anio)? $auditorias->anio : '(Sin plan anual)';
        $elementos['titulo_anio'] =  $anio;

        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías',  'ruta'=> route('planeaciones'), 'value'=>''],
            ['nombreComponente' => 'Solcitudes de expedientes '.$anio,  'ruta'=> route('auditorias.listado.solicitar.expediente'), 'value'=>''],
            ['nombreComponente' => 'Solicitar expedientes',  'ruta'=> '', 'value'=>'active'],
        ];

        $estatus_auditoria = Catalogo::whereCodigo('estatus_auditorias')->first();
        $estatus_pendiente = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('pendiente')->first()->id;

        $catregional = Catalogo::whereCodigo('regiones_setrass')->orderBy('nombre', 'ASC')->first();
        $cat_regional = CatalogoElemento::whereCatalogoId($catregional->id)->orderBy('orden')->get();
        $meses = [];
        for ($i = 1; $i <= 12; $i++) {
            $fecha = \Carbon\Carbon::parse("2023-$i-01");
            $mesTraducido = $fecha->translatedFormat('F');
            $meses[$i] = ucfirst($mesTraducido);
        }

        $elementos['mes']               = $meses;
        $elementos['valor']             = Auth::id();
        $elementos['cat_regional']      = $cat_regional;
        $elementos['estatus_pendiente'] = $estatus_pendiente;

        return view('auditorias.formulario-solicitud-expediente', compact('elementos', 'breadcrumbs'));
    }

    public function storeSolictudExpedientes(Request $request)
    {
        if ($request->jefe_regional_id == 0 )
            return redirect()->route('auditorias.formulario.solicitud.expediente')->with('error', "La regional seleccionada no cuenta con un auditor.");

        $dependencia_id       = CatalogoElemento::where('codigo', 'setrass')->first()->id;
        $oficio_solicitud     = $request->file('documento_archivo_oficio_solicitud_informacion_auditoria');
        $oficio_orden         = $request->file('documento_archivo_oficio_orden_ejecucion_auditoria');
        $estatus_auditoria    = Catalogo::whereCodigo('estatus_auditorias')->first();
        $estatus_solicitud_expediente   = Catalogo::whereCodigo('estatus_solicitud_expediente')->first();
        $status_espera_id     = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('espera')->first()->id;
        $status_pendiente_id  = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('pendiente')->first()->id;
        $status_solicitud_solicitada_id = CatalogoElemento::where('catalogo_id', '=', $estatus_solicitud_expediente->id)->whereCodigo('solicitud_solicitada')->first()->id;

        $auditor_regional_asignado = User::select('id', 'complete_name', 'email', 'cargo')->where('id','=', $request->jefe_regional_id)->first();

        //Actualizo ejecucion con estatus en espera
        $update_planeacion_ejecucion = PlaneacionAuditoriaEjecucion::whereHas('grupo',function($query)use($request){
            return $query->where('region_id',$request->regional);
        })->where('mes', $request->mes)->where('estatus_id', $status_pendiente_id)->get();


        $solicitud_expediente = PlaneacionSolicitudExpediente::create([
            "numero_oficio"               =>$request->numero_oficio_oficio_solicitud_informacion_auditoria,
            "regional_id"                 =>$request->regional,
            "mes"                         =>$request->mes,
            "fecha_solicitud"             =>now(),
            "auditor_realizo_solicitud"   =>Auth::id(),
            "auditor_jefe_regional_id"    =>$auditor_regional_asignado->id,
            "auditor_asignado_id"         =>$update_planeacion_ejecucion[0]->auditor_asignado_id,
            "total_expdientes_solicitados"=>count($update_planeacion_ejecucion),
            "estatus_id"                  =>$status_solicitud_solicitada_id,
        ]);

        foreach ($update_planeacion_ejecucion as $actualizar)
            $actualizar->update([
                'estatus_id' => $status_espera_id,
                'solicitud_expediente_id'=>$solicitud_expediente->id
            ]);

        GestionAuditoria::create([
            "planeacion_solicitud_expediente_id" => $solicitud_expediente->id,
            "estatus_id"                         => $status_solicitud_solicitada_id,
            "auditor_jefe_regional_id"           => $auditor_regional_asignado->id,
            "usuario_asignado_id"                => $update_planeacion_ejecucion[0]->auditor_asignado_id,
            "creador_id"                         => Auth::id(),
            "fecha_solicitud"                    => now(),
        ]);

        if ($oficio_solicitud){
            $acuse = ArchivosController::storeSimple($request, 'oficio_solicitud_informacion_auditoria', $solicitud_expediente->getMorphClass(), $solicitud_expediente->id, $dependencia_id);
            if ($acuse)
                $acuse->update([
                    'num_oficio' => $request->numero_oficio_oficio_solicitud_informacion_auditoria,
                ]);
        }

        if ($oficio_orden)
            ArchivosController::storeSimple($request, 'oficio_orden_ejecucion_auditoria', $solicitud_expediente->getMorphClass(), $solicitud_expediente->id, $dependencia_id );

        // Envio Correo
            $extras = [
                'nombre_jefe_auditoria' => Auth::user()->complete_name,
                'cargo_jefe_auditoria' => Auth::user()->cargo,
                'url' => route('auditorias.listado.solicitar.expediente'),
            ];
            try {
                Mail::to($auditor_regional_asignado->email)->send(new Notificacion($auditor_regional_asignado, 'solicitudExpedienteJefeRegional', "Solicitud de expedientes para auditoría por parte de la ATI ",  $extras ));
            } catch (\Exception $e) {
                Log::info("Error  proceso envio de correo solicitudExpedienteJefeRegional ->Error [".$e."]");
            }

        registroBitacora($solicitud_expediente,A_REGISTRAR,C_GESTION_AUDITORIAS,SC_SOLICITUD_EXPEDIENTE_AUDITORIA,"Se realizó la solicitud de expediente de manera correcta. ",null,Auth::id());

        return redirect()->route('auditorias.listado.solicitar.expediente')->with('success', "Se realizó la solicitud de expediente de manera correcta.");
    }

    public function solicitudExpedienteDetalle($expediente_id){
        $expediente = PlaneacionSolicitudExpediente::findOrFail($expediente_id);
        $planeacion_id = $expediente->planeacion_auditorias;
        $mes = $expediente->mes;
        $planeacion_auditoria_mes = PlaneacionAuditoriaMes::where('mes',$mes)->where('planeacion_auditoria_id',$expediente->planeacion_auditorias[0]->id)->first();

        $estatus_plan_anual  = Catalogo::whereCodigo('estatus_plan_anual')->first();
        $estatus_viegente_id = CatalogoElemento::where('catalogo_id', '=', $estatus_plan_anual->id)->whereCodigo('vigente')->first()->id;
        $auditorias          = Planeacion::where('estatus_id', $estatus_viegente_id)->first();
        $anio = isset($auditorias->anio)? $auditorias->anio : '(Sin plan anual)';
        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías',  'ruta'=> route('planeaciones'), 'value'=>''],
            ['nombreComponente' => 'Solcitudes de expedientes '.$anio,       'ruta'=> route('auditorias.listado.solicitar.expediente'), 'value'=>''],
            ['nombreComponente' => 'Respuesta a solicitudes de expedientes',  'ruta'=> '', 'value'=>'active'],
        ];
        return view('auditorias.respuesta-solicitud-expediente', compact('expediente','breadcrumbs'));

    }
    public function storeRespuestaSolictudExpedientes(Request $request)
    {
        $datosSolicitud = PlaneacionSolicitudExpediente::findOrFail($request->solicitud_id);

        foreach($request->documento as $key=>$value){
            //Validamos si tiene archivo
            $estatus_auditoria   = Catalogo::whereCodigo('estatus_auditorias')->first();
            $estatus_expediente_recibido    = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('expediente_recibido')->first()->id;
            $estatus_expediente_recibido_sin_info    = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('expediente_recibido_sin_informacion')->first()->id;
            $estatus_solicitud_expediente = Catalogo::whereCodigo('estatus_solicitud_expediente')->first();
            $estatus_solicitud_exp_recibido_id = CatalogoElemento::where('catalogo_id', '=', $estatus_solicitud_expediente->id)->whereCodigo('solicitud_recibida')->first()->id;
            $ejecucion = PlaneacionAuditoriaEjecucion::find($key);
            if(isset($value['file']) && !isset($value['tiene_expediente'])){
                $archivo = $value['file'];
                $mimes = $value['accept'];
                $oficio = $value['numero_oficio'];
                $catalogo = Catalogo::where('codigo', 'documentos')->first();
                $tipo_documento = $catalogo->elementos->where('codigo', $value['codigo'])->first();
                $tipo_entidad = PlaneacionAuditoriaEjecucion::find($key)->getMorphClass();
                if ($archivo){
                    $dependencia_id = CatalogoElemento::where('codigo', 'setrass')->first()->id;
                    $rutaArchivo = $archivo->store("archivos/$dependencia_id/$tipo_entidad/$ejecucion->id/$tipo_documento->codigo");
                    $pesoArchivo = round($archivo->getSize() / 1024, 2);
                    // Guardar el registro en la base de datos
                    $datosArchivo = [
                        'dependencia_id' => $dependencia_id,
                        'ruta' => $rutaArchivo,
                        'nombre' => $archivo->getClientOriginalName(),
                        'descripcion' => $tipo_documento ? $tipo_documento->nombre : '',
                        'fecha_recepcion' => date('Y-m-d'),
                        'num_oficio' => $oficio,
                        'extension' => $archivo->extension(),
                        'peso' => $pesoArchivo . ' KB',
                    ];

                    $existente = Documento::whereTipoEntidad($tipo_entidad)->whereEntidadId($ejecucion->id)->whereTipoDocumentoId($tipo_documento->id)->first();
                    if(isset($existente->id)){
                        $accion = A_ACTUALIZAR;
                        $descripcionBitacora = "Se actualiza el documento $tipo_documento->nombre de la entidad $tipo_entidad y entidad_id $ejecucion->id";
                    }else{
                        $accion = A_REGISTRAR;
                        $descripcionBitacora = "Se registra el documento $tipo_documento->nombre de la entidad $tipo_entidad y entidad_id $ejecucion->id";
                    }

                    $documento = Documento::updateOrCreate([
                        'tipo_entidad' => $tipo_entidad,
                        'entidad_id' => $ejecucion->id,
                        'tipo_documento_id' => $tipo_documento->id,
                    ], $datosArchivo);
                    $estatus = $estatus_expediente_recibido_sin_info;
                    $ejecucion->update([
                        'tiene_expediente' => true,
                        'estatus_id' =>  $estatus_expediente_recibido

                    ]);

                    registroBitacora($documento,$accion,C_DOCUMENTOS,null,$descripcionBitacora,$datosArchivo);
                }
            }else{
                $estatus = $estatus_expediente_recibido;
                $ejecucion->update([
                    'estatus_id' => $estatus_expediente_recibido_sin_info

                ]);
            }
            //Actualizó gestion con observación
            GestionAuditoria::create([
                "planeacion_solicitud_expediente_id" => $datosSolicitud->id,
                "estatus_id"                         => $estatus,
                "observacion"                        => null,
                "usuario_asignado_id"                => $datosSolicitud->auditor_asignado_id,
                "creador_id"                         => Auth::id(),
                "fecha_solicitud"                    => now(),
            ]);

        }

        $datosSolicitud->update([
            'estatus_id' => $estatus_solicitud_exp_recibido_id,
            'vencido' => false,
        ]);
        if(Auth::user()->hasRole('jefe_auditoria_setrass_ati')){

            if(isset($request->expediente_fisico) && isset($request->fecha_entrega_expediente)){
                $datosSolicitud->update([
                    'expediente_fisico' => true,
                    'fecha_expediente_fisico' => $request->fecha_entrega_expediente,
                    'vencido' => false,
                ]);
            }
        }
        return redirect()->route('auditorias.listado.solicitar.expediente')->with('success', "Se enviaron los expedientes de manera correcta.");
    }

    public function showLevantarActa(int $id )
    {
        $estatus_plan_anual  = Catalogo::whereCodigo('estatus_plan_anual')->first();
        $estatus_viegente_id = CatalogoElemento::where('catalogo_id', '=', $estatus_plan_anual->id)->whereCodigo('vigente')->first()->id;
        $auditorias          = Planeacion::where('estatus_id', $estatus_viegente_id)->first();
        $anio = isset($auditorias->anio)? $auditorias->anio : '(Sin plan anual)';

        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías',                         'ruta'=> route('planeaciones'), 'value'=>''],
            ['nombreComponente' => 'Solcitudes de expedientes '.$anio,   'ruta'=> route('auditorias.listado.solicitar.expediente'), 'value'=>''],
            ['nombreComponente' => 'Detalle solcitudes de expedientes',  'ruta'=> route('auditorias.detalle.expediente', [$id]), 'value'=>''],
            ['nombreComponente' => 'Levantar acta de Incumplimiento',    'ruta'=> '', 'value'=>'active'],
        ];

        $datosSolicitud = PlaneacionSolicitudExpediente::findOrFail($id);

        return view('auditorias.levantar-acta-incumplimiento', compact('datosSolicitud', 'breadcrumbs'));
    }

    public function storeLevantarActa(Request $request)
    {
        $dependencia_id    = CatalogoElemento::where('codigo', 'setrass')->first()->id;
        $datosSolicitud    = PlaneacionSolicitudExpediente::findOrFail($request->id);

        $estatus_solicitud_expediente   = Catalogo::whereCodigo('estatus_solicitud_expediente')->first();
        $status_solicitud_incumplimiento_id    = CatalogoElemento::where('catalogo_id', '=', $estatus_solicitud_expediente->id)->whereCodigo('solicitud_incumplimiento')->first()->id;

        $estatus_auditoria = Catalogo::whereCodigo('estatus_auditorias')->first();
        $status_incumplida_id  = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('incumplida')->first()->id;
        $status_plazo_vencido_id  = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('plazo_vencido')->first()->id;

        $auditor_regional_asignado = User::select('id', 'complete_name', 'email', 'cargo')->where('id', '=', $datosSolicitud->auditor_jefe_regional_id)->first();
        $archivo_uno = $request->file('documento_archivo_acta_incumplimiento_auditoria');

        //Actualizó solicitud
        $datosSolicitud->update([
            'estatus_id' => $status_solicitud_incumplimiento_id,
        ]);

        //Actualizó gestion con observación
        GestionAuditoria::create([
            "planeacion_solicitud_expediente_id" => $datosSolicitud->id,
            "estatus_id"                         => $status_solicitud_incumplimiento_id,
            "observacion"                        => $request->observacion,
            "usuario_asignado_id"                => $datosSolicitud->auditor_asignado_id,
            "creador_id"                         => Auth::id(),
            "fecha_solicitud"                    => now(),
        ]);

        //Cargo documento
       if ($archivo_uno)
            ArchivosController::storeSimple($request, 'acta_incumplimiento_auditoria', $datosSolicitud->getMorphClass(), $datosSolicitud->id, $dependencia_id );

        // Envio Correo
        $extras = [
            'nombre_jefe_regional' => Auth::user()->complete_name,
            'numero_oficio'        => $datosSolicitud->numero_oficio,
            'fecha_solicitud'      => $datosSolicitud->fecha_solicitud->format('d/m/Y'),
            'url' => route('auditorias.listado.solicitar.expediente'),
        ];
        try {
            Mail::to($auditor_regional_asignado->email)->send(new Notificacion($auditor_regional_asignado, 'incumplimientoJefeRegional', "Notificación de incumplimiento derivado del oficio $datosSolicitud->numero_oficio",  $extras ));
        } catch (\Exception $e) {
            Log::info("Error  proceso envio de correo solicitudExpedienteJefeRegional ->Error [".$e."]");
        }

        //Actualizo ejecucion con estatus en espera
        $update_planeacion_ejecucion = PlaneacionAuditoriaEjecucion::whereHas('grupo',function($query)use($datosSolicitud){
            return $query->where('region_id',$datosSolicitud->regional_id);
        })->where('mes', $datosSolicitud->mes)->where('estatus_id', $status_plazo_vencido_id)->get();

        foreach ($update_planeacion_ejecucion as $actualizar)
            $actualizar->update([
                'estatus_id' => $status_incumplida_id,
            ]);

        registroBitacora($datosSolicitud,A_REGISTRAR,C_GESTION_AUDITORIAS,SC_ACTA_INCUMPLIMIENTO_AUDITORIA,"Se realizó la acta de incumplimiento de manera correcta.",null,Auth::id());

        return redirect()->route('auditorias.listado.solicitar.expediente')->with('success', "Se realizó la acta de incumplimiento de manera correcta.");
    }

    public function storePlantilla(Request $request)
    {
        $seccion = $request->input('seccion_id');
        $plantilla = PlaneacionAuditoriaEjecucionPlantilla::updateOrCreate([
            'seccion_id' => $seccion,
            'plantilla_id' => $request->input('plantilla_id'),
            'ejecucion_id' => $request->input('ejecucion_id'),
            'identificador' => $request->input('identificador'),
            'contenido' => $request->input('contenido'),
        ]);

        $ruta = 'cedulas';
        $seccion = CatalogoElemento::find($seccion);
        if ($seccion->codigo == 'seccion_resultados_preliminares') {
            $ruta = 'resultados';
        } elseif ($seccion->codigo == 'seccion_cierre_auditoria') {
            $ruta = 'cierre';
        }

        if ($plantilla) {
            return redirect()->route("auditorias.ejecucion.proceso.$ruta", ['ejecucion' => $request->input('ejecucion_id')])->with('success', "Se agregó el registro de manera correcta.");
        }
        return back()->with('error', "Ha ocurrido un error al agregar el registro.");
    }

    public function storePlantillaFirma(Request $request)
    {
        try {
            $seccion = $request->input('seccion_id');
            $plantilla_id = $request->input('plantilla_id');
            $plantilla = PlaneacionAuditoriaEjecucionPlantilla::find($plantilla_id);

            $dependencia_id = CatalogoElemento::where('codigo', 'setrass')->first()->id;
            ArchivosController::storeSimple($request, 'auditoria_plantilla_firmada', $plantilla->getMorphClass(), $plantilla->id, $dependencia_id);

            $ruta = 'cedulas';
            $seccion = CatalogoElemento::find($seccion);
            if ($seccion->codigo == 'seccion_resultados_preliminares') {
                $ruta = 'resultados';
            } elseif ($seccion->codigo == 'seccion_cierre_auditoria') {
                $ruta = 'cierre';
            }

            return redirect()->route("auditorias.ejecucion.proceso.$ruta", ['ejecucion' => $plantilla->ejecucion_id])->with('success', "Se agregó correctamente el documento al registro.");
        } catch (\Exception $e) {
            Log::info("Error en proceso de carga de cédula firmada. ".$e->getMessage());
            return back()->with('error', "Ha ocurrido un error al guardar el archivo de la cédula de trabajo firmada.");
        }
    }

    public function deletePlantilla(Request $request)
    {
        $delete = PlaneacionAuditoriaEjecucionPlantilla::where('id', $request->input('plantilla_id'))->delete();

        if ($delete) {
            return back()->with('success', "Se eliminó el registro de manera correcta.");
        }
        return back()->with('error', "Ha ocurrido un error al eliminar el registro.");
    }

    public function deletePlantillaFirma(Request $request)
    {
        $plantilla = PlaneacionAuditoriaEjecucionPlantilla::where('id', $request->input('plantilla_id'))->first();

        $archivo = $plantilla->documento;
        $eliminacion = false;
        if($archivo){
            registroBitacora($archivo,A_ELIMINAR,C_DOCUMENTOS,null,"Se elimina el documento ".$archivo->categoria->nombre." de la entidad $archivo->tipo_entidad");
            $eliminacion = $archivo->delete() && Storage::delete($archivo->ruta);
        }

        if ($eliminacion) {
            return back()->with('success', "Se eliminó correctamente el documento firmado.");
        }
        return back()->with('error', "Ha ocurrido un error al eliminar el documento firmado.");
    }

    public function plantillaPdf($id)
    {
        $plantilla = PlaneacionAuditoriaEjecucionPlantilla::find($id);

        if (!$plantilla) {
            abort(404);
        }

        $contenidoHTML = $plantilla->contenido;

        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($contenidoHTML);
        return $pdf->download(($plantilla->identificador ?? $plantilla->seccion->nombre). ($plantilla->ejecucion?->num_auditoria ? " " . $plantilla->ejecucion->num_auditoria : '' ) .".pdf");
    }

    public function plantillaDoc($id)
    {
        $plantilla = PlaneacionAuditoriaEjecucionPlantilla::find($id);

        if (!$plantilla) {
            abort(404);
        }

        $contenidoHTML = $plantilla->contenido;

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        Html::addHtml($section, $contenidoHTML, false, false);

        $filename = ($plantilla->identificador ?? $plantilla->seccion->nombre). ($plantilla->ejecucion?->num_auditoria ? " " . $plantilla->ejecucion->num_auditoria : '' ) .".docx";
        header("Content-type: application/vnd.ms-word");
        header('Content-Disposition: attachment; filename=' . $filename);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord);
        $objWriter->save('php://output');
    }
    public function showElaboracionInformeAuditoria(PlaneacionAuditoriaEjecucion $ejecucion){
        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías', 'ruta' => route('planeaciones'), 'value' => ''],
            ['nombreComponente' => 'Ejecución de auditorías ' . date('Y'), 'ruta' => route('auditorias.ejecuciones'), 'value' => ''],
            ['nombreComponente' => $ejecucion->num_auditoria ?? 'Sin número asignado', 'ruta' => route('auditorias.ejecucion.detalle', ['ejecucion' => $ejecucion->id]), 'value' => ''],
            ['nombreComponente' => 'Informe de auditoría', 'ruta' => '', 'value' => 'active']
        ];
        $seccion_informe = CatalogoElemento::whereCodigo('seccion_informe_auditoria')->first();
        $plantilla_informe_auditoria = Plantilla::where('seccion_id', $seccion_informe->id)->first();
        $seccion_cedula = CatalogoElemento::whereCodigo('seccion_cedula_hallazgos')->first();
        $plantilla_cedula_hallazgos = Plantilla::where('seccion_id', $seccion_cedula->id)->first();
        return view('auditorias.detalle.informe-auditoria', compact('ejecucion', 'breadcrumbs','plantilla_informe_auditoria','plantilla_cedula_hallazgos'));

    }
    public function storeElaboracionInformeAuditoriaEjecutada(Request $request){
        $ejecucion = PlaneacionAuditoriaEjecucion::findOrFail($request->ejecucion_id);
        if($ejecucion->auditoria_no_ejecutada==true){
            $rules = [
                'documento_archivo_informe_auditoria' => 'required',
                'documento_archivo_cedula_hallazgos' => 'required',
                'documento_archivo_acta_incumplimiento_auditoria' => 'required'
            ];
        }else{
            $rules = [
                'documento_archivo_informe_auditoria' => 'required',
                'documento_archivo_cedula_hallazgos' => 'required',
            ];
        }
        $messages = [
            '*.required' => 'Campo obligatorio'
        ];

        $validator = Validator::make($request->all(), $rules,$messages);
        $validator->validate();


        $hallazgos = false;
        $seguimiento = false;
        $fecha_seguimiento = null;

        $dependencia_id    = CatalogoElemento::where('codigo', 'setrass')->first()->id;
        $datosSolicitud    = PlaneacionSolicitudExpediente::where('id',$ejecucion->solicitud_expediente_id)->first();
        //Validamos si es auditorua no ejecutada
        if($ejecucion->auditoria_no_ejecutada==true){
            ArchivosController::storeSimple($request, 'acta_incumplimiento_auditoria', $ejecucion->getMorphClass(), $ejecucion->id, $dependencia_id );
        }else{
            if(isset($request->con_seguimiento)){
                $seguimiento = true;
            }
            if(isset($request->fecha_seguimiento)){
                $fecha_seguimiento = $request->fecha_seguimiento;
            }

        }
        if(isset($request->con_hallazgos)){
            $hallazgos = true;
        }
        ArchivosController::storeSimple($request, 'cedula_hallazgos', $ejecucion->getMorphClass(), $ejecucion->id, $dependencia_id );
        ArchivosController::storeSimple($request, 'informe_auditoria', $ejecucion->getMorphClass(), $ejecucion->id, $dependencia_id );
            $ejecucion->update([
            'hallazgos_a_notificar' => $hallazgos,
            'seguimiento' => $seguimiento,
            'fecha_seguimiento' => $fecha_seguimiento,
            'informe_auditoria' => true
        ]);
        $estatus_auditoria = Catalogo::whereCodigo('estatus_auditorias')->first();
        $estatus_finalizada = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('finalizada')->first();
        $ejecucion->update([
            'estatus_id' => $estatus_finalizada->id,
        ]);
         //Actualizó gestion de la auditoria
        GestionAuditoria::create([
            "planeacion_solicitud_expediente_id" => $datosSolicitud->id,
            "estatus_id"                         => $estatus_finalizada->id,
            "observacion"                        => 'Se carga informe de auditoría',
            "usuario_asignado_id"                => $ejecucion->auditor_asignado_id,
            "creador_id"                         => Auth::id(),
            "fecha_solicitud"                    => now(),
        ]);

        registroBitacora($ejecucion,A_REGISTRAR,C_GESTION_AUDITORIAS,null,"Se cargo el informe de auditoría a la ejecucion con id: $ejecucion->id y la ejecución paso a estatus $estatus_finalizada->nombre");
        return back()->with('success', "Se cargó el infome de auditoría correctamente.");
    }


    public function cierreProceso(Request $request)
    {
        try {
            $catalogo = Catalogo::whereCodigo('estatus_auditorias')->first();
            $estatus = $catalogo->elementos->where('codigo', 'elaboracion_informe')->first();

            $ejecucion = PlaneacionAuditoriaEjecucion::find($request->input('ejecucion_id'));

            $ejecucion->estatus_id = $estatus->id;
            $ejecucion->save();

            registroBitacora($ejecucion,A_REGISTRAR,C_GESTION_AUDITORIAS,SC_PROCESO_EJECUCION_AUDITORIA,"Se concluye el proceso de ejecución de auditoría y procede al cierre.",null,Auth::id());

            return redirect()->route("auditorias.ejecucion.detalle", ['ejecucion' => $ejecucion->id])->with('success', "Se cerró correctamente el proceso de ejecución de la auditoría");
        } catch (\Exception $e) {
            Log::info("Fallo al cerrar el proceso de la auditoría ->Error [" . $e . "]");
            return back()->with('error', "Ha ocurrido un error al cerrar el proceso de la auditoría.");
        }
    }


    public function reasignacion(Request $request)
    {
        try {
            $ejecucion = PlaneacionAuditoriaEjecucion::find($request->input('ejecucion_id'));

            $ejecucion->auditor_asignado_id = $request->input('auditor_asignado_id');
            $ejecucion->save();

            registroBitacora($ejecucion,A_REGISTRAR,C_GESTION_AUDITORIAS,SC_PROCESO_EJECUCION_AUDITORIA,"Se reasigna auditor asignado de la ejecución.",null,Auth::id());

            return back()->with('success', "Se reasignó correctamente el usuario relacionado a ejecución de la auditoría");
        } catch (\Exception $e) {
            Log::info("Fallo al reasignar al auditor ->Error [" . $e . "]");
            return back()->with('error', "Ha ocurrido un error al reasignar al auditor.");
        }
    }

    public function showIncumplimiento(PlaneacionAuditoriaEjecucion $ejecucion){
        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías',                           'ruta'=> route('planeaciones'),            'value'=>''],
            ['nombreComponente' => 'Ejecución de auditorías ' . date('Y'), 'ruta' => route('auditorias.ejecuciones'), 'value' => ''],
            ['nombreComponente' => $ejecucion->num_auditoria ?? 'Sin número asignado', 'ruta' => route('auditorias.ejecucion.detalle',$ejecucion), 'value' => ''],
            ['nombreComponente' => 'Incumplimiento '.($ejecucion->tiene_expediente?'':'por falta de expediente'),  'ruta'=> '#', 'value'=>'active'],
        ];
        return view('auditorias.incumplimiento', compact('ejecucion', 'breadcrumbs'));
    }

    public function storeIncumplimiento(Request $request){
        $dependencia_id    = CatalogoElemento::where('codigo', 'setrass')->first()->id;
        $ejecucion         = PlaneacionAuditoriaEjecucion::findOrFail($request->ejecucion_id);

        $estatus_auditoria   = Catalogo::whereCodigo('estatus_auditorias')->first();
        $incumplimiento_sin_exp    = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('incumplimiento_sin_expediente')->first()->id;
        $incumplimiento    = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('incumplimiento')->first()->id;

        $jefe_regional = $ejecucion->solicitud->auditor_regional;
        $acta_incumplimiento = $request->file('documento_archivo_acta_incumplimiento_auditoria');

        $ejecucion->update([
            'observaciones_incumplimiento' => $request->fundamentacion_incumplimiento,
            'estatus_id' => $ejecucion->tiene_expediente ? $incumplimiento : $incumplimiento_sin_exp,
        ]);
       if ($acta_incumplimiento)
            ArchivosController::storeSimple($request, 'acta_incumplimiento_auditoria', $ejecucion->getMorphClass(), $ejecucion->id, $dependencia_id );

       if($ejecucion->tiene_expediente){
           $extras = [
               'nombre_jefe_regional' => $jefe_regional->complete_name,
               'numero_oficio'        => $ejecucion->solicitud->numero_oficio,
               'fecha_solicitud'      => $ejecucion->solicitud->fecha_solicitud->format('d/m/Y'),
               'url' => route('auditorias.ejecucion.detalle',$ejecucion),
           ];
           try {
               Mail::to($jefe_regional->email)->send(new Notificacion($jefe_regional, 'incumplimientoJefeRegional', "Notificación de incumplimiento derivado del oficio ".$ejecucion->solicitud->numero_oficio,  $extras ));
           } catch (\Exception $e) {
               Log::error("Error en el envío de notificación de incumplimiento de auditoría. ".$e->getMessage());
           }
       }

        registroBitacora($ejecucion,A_REGISTRAR,C_GESTION_AUDITORIAS,SC_INCUMPLIMIENTO_AUDITORIA,"Se registró el incumplimiento ".($ejecucion->tiene_expediente?'':'por falta de expediente')." de la auditoría.",null,Auth::id());

        return redirect()->route('auditorias.ejecuciones' )->with('success', "Se registró el incumplimiento de la auditoría correctamente.");
    }
    public function showSeguimiento()
    {
        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías',   'ruta' => route('planeaciones'), 'value' => ''],
            ['nombreComponente' => 'Seguimiento ', 'ruta' => route('auditorias.seguimiento'), 'value' => 'active'],
        ];
        $area_adscripcion_id =  CatalogoElemento::where('codigo', '=', 'ati')->value('id');
        $catalogo = Catalogo::whereCodigo('estatus_plan_anual')->first();

        $estatus = $catalogo->elementos->filter(function ($elemento) {
            return $elemento->codigo === 'registrado' || $elemento->codigo === 'vigente';
        })->pluck('id')->toArray();

        $planeacionVigente = Planeacion::where('anio', date('Y'))->whereIn('estatus_id', $estatus)->first();

        if ($planeacionVigente && $planeacionVigente->ejecuciones->count() < 1) {
            PlaneacionesController::ejecucionVigencia($planeacionVigente);
        }
        $elementos['auditores'] = User::select('users.id', 'users.complete_name')->where('area_adscripcion_id', $area_adscripcion_id)->where('cargo',"!=","Denunciante")->get();;
        return view('auditorias.seguimiento', compact('breadcrumbs', 'elementos'));
    }

    public function showIniciarProceso(PlaneacionAuditoriaEjecucion $ejecucion){
        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías',                           'ruta'=> route('planeaciones'),            'value'=>''],
            ['nombreComponente' => 'Ejecución de auditorías ' . date('Y'), 'ruta' => route('auditorias.ejecuciones'), 'value' => ''],
            ['nombreComponente' => $ejecucion->num_auditoria ?? 'Sin número asignado', 'ruta' => route('auditorias.ejecucion.detalle',$ejecucion), 'value' => ''],
            ['nombreComponente' => 'Iniciar proceso de auditoría',  'ruta'=> '#', 'value'=>'active'],
        ];
        $seccion = CatalogoElemento::whereCodigo('seccion_inicio_proceso')->first();
        $plantilla = Plantilla::where('seccion_id', $seccion->id)->first();
        return view('auditorias.inicio-proceso', compact('ejecucion', 'breadcrumbs','plantilla'));
    }

    public function storeIniciarProceso(Request $request){
        $dependencia_id    = CatalogoElemento::where('codigo', 'setrass')->first()->id;
        $ejecucion         = PlaneacionAuditoriaEjecucion::findOrFail($request->ejecucion_id);

        $estatus_auditoria   = Catalogo::whereCodigo('estatus_auditorias')->first();
        $en_proceso    = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('proceso')->first()->id;

        $jefe_regional = $ejecucion->solicitud->auditor_regional;
        $acta_inicio = $request->file('documento_archivo_acta_inicio_auditoria');

        if ($acta_inicio){
            $acuse_acta_inicio = ArchivosController::storeSimple($request, 'acta_inicio_auditoria', $ejecucion->getMorphClass(), $ejecucion->id, $dependencia_id );
            if ($acuse_acta_inicio)
                $acuse_acta_inicio->update([
                    'num_oficio' => $request->numero_oficio_acta_inicio_auditoria,
                    'fecha_oficio' => $request->fecha_oficio_acta_inicio_auditoria
                ]);
        }

        $folio = $ejecucion->num_auditoria;
        if (!$folio) {
            switch ($ejecucion->grupo->inspeccion->codigo){
                case 'ordinaria':
                    $folio = 'ATI-ORD-'.$this->foliador->generarfolio('auditoria-ordinaria');
                    break;
                case 'extraordinaria':
                    $folio = 'ATI-EXT-'.$this->foliador->generarfolio('auditoria-extraordinaria');
                    break;
                case 'asesoria_tecnica':
                    $folio = 'ATI-TEC-'.$this->foliador->generarfolio('auditoria-tecnica');
                    break;
            }
        }

        $ejecucion->update([
            'estatus_id' => $en_proceso,
            'num_oficio' => @$request->numero_oficio_acta_inicio_auditoria,
            'fecha_entrega_oficio' => @$request->fecha_oficio_acta_inicio_auditoria,
            'num_auditoria'=>$folio
        ]);

        registroBitacora($ejecucion,A_REGISTRAR,C_GESTION_AUDITORIAS,SC_PROCESO_EJECUCION_AUDITORIA,"Se inició el proceso de la auditoría $ejecucion->num_auditoria.",null,Auth::id());

        return redirect()->route('auditorias.ejecuciones' )->with('success', "Se inició el proceso de la auditoría $ejecucion->num_auditoria correctamente.");
    }

    public function showCargaDocumento(PlaneacionAuditoriaEjecucion $ejecucion)
    {
        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías',   'ruta' => route('planeaciones'), 'value' => ''],
            ['nombreComponente' => 'Seguimiento ', 'ruta' => route('auditorias.seguimiento'), 'value' => 'active'],
        ];

        $seccion_recomendaciones_auditoria        = CatalogoElemento::whereCodigo('formato_seguimiento_recomendaciones_auditoria')->first();
        $seccion_informe_seguimiento_resultados   = CatalogoElemento::whereCodigo('formato_informe_seguimiento_resultados_auditoria')->first();

        $plantilla_seguimiento_recomendaciones    = Plantilla::where('seccion_id', $seccion_recomendaciones_auditoria->id)->first();
        $plantilla_seguimiento_resultados         = Plantilla::where('seccion_id', $seccion_informe_seguimiento_resultados->id)->first();

        $plantilla['formato_seguimiento_recomendaciones_auditoria']    = $plantilla_seguimiento_recomendaciones;
        $plantilla['formato_informe_seguimiento_resultados_auditoria'] = $plantilla_seguimiento_resultados;

        $doc_informe_seguimiento_recomendacion_auditoria  = $ejecucion ? $ejecucion->documentos()->whereHas('categoria',function($q){$q->whereCodigo('informe_seguimiento_recomendacion_auditoria');})->get() : null;
        $doc_informe_seguimiento_resultados_auditoria     = $ejecucion ? $ejecucion->documentos()->whereHas('categoria',function($q){$q->whereCodigo('informe_seguimiento_resultados_auditoria');})->get() : null;

        $elementos['informe_seguimiento_recomendacion_auditoria']   = $doc_informe_seguimiento_recomendacion_auditoria;
        $elementos['informe_seguimiento_resultados_auditoria']      = $doc_informe_seguimiento_resultados_auditoria;

        return view('auditorias.detalle.cargar-informe-seguimiento', compact('breadcrumbs', 'ejecucion', 'plantilla', 'elementos'));
    }

    public function storeCargaDocumento(Request $request)
    {
        $dependencia_id    = CatalogoElemento::where('codigo', 'setrass')->first()->id;
        $ejecucion         = PlaneacionAuditoriaEjecucion::findOrFail($request->id);

        $estatus_auditoria   = Catalogo::whereCodigo('estatus_auditorias')->first();
        $estatus_finalizada_id    = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('finalizada')->first()->id;

        $ejecucion->update([
            'estatus_id' => $estatus_finalizada_id,
            'seguimiento' => false,
        ]);

        $documento_archivo_informe_seguimiento_recomendacion = $request->file('documento_archivo_informe_seguimiento_recomendacion_auditoria');
        $documento_archivo_informe_seguimiento_resultados = $request->file('documento_archivo_informe_seguimiento_resultados_auditoria');

        if ($documento_archivo_informe_seguimiento_recomendacion)
            ArchivosController::storeSimple($request, 'informe_seguimiento_recomendacion_auditoria', $ejecucion->getMorphClass(), $ejecucion->id, $dependencia_id );

        if ($documento_archivo_informe_seguimiento_resultados)
            ArchivosController::storeSimple($request, 'informe_seguimiento_resultados_auditoria', $ejecucion->getMorphClass(), $ejecucion->id, $dependencia_id );

        return redirect()->route('auditorias.seguimiento' )->with('success', "Se finalizó la auditoría $ejecucion->num_auditoria correctamente.");
    }

    public function showProrroga(int $id){
        $estatus_plan_anual  = Catalogo::whereCodigo('estatus_plan_anual')->first();
        $estatus_viegente_id = CatalogoElemento::where('catalogo_id', '=', $estatus_plan_anual->id)->whereCodigo('vigente')->first()->id;
        $auditorias          = Planeacion::where('estatus_id', $estatus_viegente_id)->first();
        $anio = isset($auditorias->anio)? $auditorias->anio : '(Sin plan anual)';

        $breadcrumbs = [
            ['nombreComponente' => 'Auditorías',                         'ruta'=> route('planeaciones'), 'value'=>''],
            ['nombreComponente' => 'Solcitudes de expedientes '.$anio,   'ruta'=> route('auditorias.listado.solicitar.expediente'), 'value'=>''],
            ['nombreComponente' => 'Detalle solcitudes de expedientes',  'ruta'=> route('auditorias.detalle.expediente', [$id]), 'value'=>''],
            ['nombreComponente' => 'Prorroga',                           'ruta'=> '', 'value'=>'active'],
        ];

        $expediente = PlaneacionSolicitudExpediente::findOrFail($id);
        return view('auditorias.prorroga-solcitud-expedientes', compact('expediente', 'breadcrumbs'));

    }
    public function storeProrroga(Request $request){
        $expediente        = PlaneacionSolicitudExpediente::findOrFail($request->input('id'));
        $dependencia_id    = CatalogoElemento::where('codigo', 'setrass')->first()->id;
        $oficio_prorroga   = $request->file('documento_archivo_oficio_solicitud_prorroga_expedientes');

        $estatus_auditoria = Catalogo::whereCodigo('estatus_auditorias')->first();
        $estatus_solicitud_expediente   = Catalogo::whereCodigo('estatus_solicitud_expediente')->first();

        $status_plazo_vencido_id = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('plazo_vencido')->first()->id;
        $status_pendiente_id  = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('pendiente')->first()->id;
        $status_solicitud_solicitada_id = CatalogoElemento::where('catalogo_id', '=', $estatus_solicitud_expediente->id)->whereCodigo('solicitud_solicitada')->first()->id;

        $auditor_regional_asignado = User::select('id', 'complete_name', 'email', 'cargo')->where('id','=', $expediente->auditor_jefe_regional_id)->first();

        //Actualizo ejecucion con estatus en plazo vencido
        $update_planeacion_ejecucion = PlaneacionAuditoriaEjecucion::whereHas('grupo',function($query)use($expediente){
            return $query->where('region_id',$expediente->regional_id);
        })->where('mes', $expediente->mes)->where('estatus_id', $status_plazo_vencido_id)->get();

        foreach ($update_planeacion_ejecucion as $actualizar)
            $actualizar->update([
                'estatus_id' => $status_pendiente_id,
                'solicitud_expediente_id'=>$expediente->id
            ]);

            //dd($expediente->plazo_respuesta_solicitud + $request->input('plazo_respuesta_solicitud'));
        //Update Solicitud Expedientes
        $expediente->estatus_id = $status_solicitud_solicitada_id;
        $expediente->plazo_respuesta_solicitud = intval($expediente->plazo_respuesta_solicitud + $request->input('plazo_respuesta_solicitud') );
        $expediente->vencido = false;
        $expediente->save();

        //Genero gestion auditoria
        GestionAuditoria::create([
            "planeacion_solicitud_expediente_id" => $expediente->id,
            "estatus_id"                         => $status_solicitud_solicitada_id,
            "auditor_jefe_regional_id"           => $expediente->auditor_jefe_regional_id,
            "usuario_asignado_id"                => $expediente->auditor_asignado_id,
            "creador_id"                         => Auth::id(),
            "observacion"                        => $request->observacion,
            "fecha_solicitud"                    => $expediente->fecha_solicitud,
        ]);

        if ($oficio_prorroga)
            ArchivosController::storeSimple($request, 'oficio_solicitud_prorroga_expedientes', $expediente->getMorphClass(), $expediente->id, $dependencia_id );

            $extras = [
                'nombre_jefe_auditoria' => Auth::user()->complete_name,
                'cargo_jefe_auditoria' => Auth::user()->cargo,
                'url' => route('auditorias.listado.solicitar.expediente'),
            ];
            try {
                Mail::to($auditor_regional_asignado->email)->send(new Notificacion($auditor_regional_asignado, 'solicitudExpedienteJefeRegional', "Solicitud de expedientes con prorroga número de oficio: $expediente->numero_oficio ",  $extras ));
            } catch (\Exception $e) {
                Log::info("Error  proceso envio de correo solicitudExpedienteJefeRegional ->Error [".$e."]");
            }

        registroBitacora($expediente,A_REGISTRAR,C_GESTION_AUDITORIAS,SC_SOLICITUD_PRORROGA_EXPEDIENTE_AUDITORIA,"Se realizó la prorroga para la solicitud de expediente con el número de oficio: $expediente->numero_oficio",null,Auth::id());

        return redirect()->route('auditorias.detalle.expediente', ['id'=>$expediente->id])->with('success', "Se realizó la prorroga de la solicitud de expediente de manera correcta.");
    }

    public function finalizarSinEjecutar(Request $request){
        $ejecucion = PlaneacionAuditoriaEjecucion::find($request->ejecucion_id);
        $ejecucion->respuestas()->delete();
        $datosSolicitud    = PlaneacionSolicitudExpediente::where('id',$ejecucion->solicitud_expediente_id)->first();
        $estatus_auditoria = Catalogo::whereCodigo('estatus_auditorias')->first();
        $estatus_informe = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('elaboracion_informe')->first();
        $ejecucion->update([
            'auditoria_no_ejecutada' => true,
            'estatus_id' => $estatus_informe->id,
            'proposito_lista'=>null,
            'fuentes_lista'=>null
        ]);
         //Actualizó gestion de la auditoria
        GestionAuditoria::create([
            "planeacion_solicitud_expediente_id" => $datosSolicitud->id,
            "estatus_id"                         => $estatus_informe->id,
            "observacion"                        => 'Se finalizó ejecución como auditoría no ejecutada',
            "usuario_asignado_id"                => $ejecucion->auditor_asignado_id,
            "creador_id"                         => Auth::id(),
            "fecha_solicitud"                    => now(),
        ]);

        registroBitacora($ejecucion,A_REGISTRAR,C_GESTION_AUDITORIAS,null,"Se finalizó ejecución como auditoría no ejecutada a la ejecución con id: $ejecucion->id y la ejecución paso a estatus $estatus_informe->nombre");
        return redirect()->route('auditorias.ejecucion.informe.auditoria',['ejecucion' => $ejecucion->id] )->with('success', "Se finalizó ejecución como auditoría no ejecutada correctamente.");
    }
}
