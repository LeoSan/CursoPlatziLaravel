<?php

namespace App\Http\Controllers;

use App\Exports\CasosExport;
use App\Exports\PagosExport;
use App\Mail\Notificacion;
use App\Mail\NotificacionPersonalizada;
use App\Models\Caso;
use App\Models\Catalogo;
use App\Models\CatalogoElemento;
use App\Models\Empresa;
use App\Models\RepresentanteLegal;
use App\Models\Sancion;
use App\Models\User;
use App\Models\Resolucion;
use App\Models\Pago;
use App\Models\PagoTotal;
use App\Models\Demanda;
use App\Models\Convenio;
use App\Models\Documento;
use App\Services\DomiciliosService;
use App\Services\FoliosService;
use App\Services\GestionCasoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;




class CasoController extends Controller
{
    protected $gestion,$foliador,$domicilio;
    public function __construct()
    {
        $this->gestion = new GestionCasoService();
        $this->foliador = new FoliosService();
        $this->domicilio = new DomiciliosService();
    }

    public function index()
    {
        return view('casos.index');
    }

    public function tablero()
    {
        return view('tablero.index');
    }

    public function reporte(Request $request)
    {
        return view('tablero.reporte');
    }

    public function show(Caso $id)
    {
        $anios = DB::select("select distinct anio as anio from tipo_infracciones t where t.activo=true and t.deleted_at is null order by t.anio desc");
        $caso = $id;
        $anio = $caso->sanciones->count() > 0 ? $caso->sanciones->first()->tipo->anio : null;
        if( Auth::user()->can('registrar_caso') && ( (!isset($caso->id) || $caso->estatus->codigo=='captura') || ( isset($caso) && $caso->estatus->codigo=="rechazado_analista") ) )
            return view('casos.formulario', compact('caso', 'anios', 'anio' ));
        else
            return $this->getResumen($caso->id);
    }


    public function store(Request $request)
    {
        $usuario = User::findOrFail(Auth::id());
        $cat_estatus = Catalogo::whereCodigo('estatus_pgr')->first();
        $en_captura = $cat_estatus->elementos()->whereCodigo('captura')->first();
        $en_revision = $cat_estatus->elementos()->whereCodigo('revision')->first();

        if (isset($request->caso_id)) {
            $caso = Caso::findOrFail($request->caso_id);
            $caso->update([
                'numero_expediente' => @$request->numero_expediente,
                'departamento_id' => @$request->caso_departamento_id,
                'municipio_id' => @$request->caso_municipio_id,
                'fecha_notificacion' => @$request->fecha_notificacion,
                'hora_notificacion' => @$request->hora_notificacion
            ]);
            $descripcionBitacora = 'Se actualiza la información del caso de id '.$caso->id.' con estatus '.$caso->estatus->nombre;
            $data = [
                'numero_expediente' => @$request->numero_expediente,
                'departamento_id' => @$request->caso_departamento_id,
                'municipio_id' => @$request->caso_municipio_id,
                'fecha_notificacion' => @$request->fecha_notificacion,
                'hora_notificacion' => @$request->hora_notificacion
            ];
            registroBitacora($caso,A_ACTUALIZAR,C_REGISTRO_CASO,null,$descripcionBitacora,$data);
        } else {
            $caso = Caso::create([
                'estatus_id' => $en_captura->id,
                'numero_expediente' => @$request->numero_expediente,
                'departamento_id' => @$request->caso_departamento_id,
                'municipio_id' => @$request->caso_municipio_id,
                'fecha_notificacion' => @$request->fecha_notificacion,
                'hora_notificacion' => @$request->hora_notificacion,
                'creador_id' => $usuario->id
            ]);

            $descripcionBitacora = 'Se registra el caso de id '.$caso->id.' '.(@$request->numero_expediente??'Pendiente');
            $data = [
                'estatus_id' => $en_captura->id,
                'numero_expediente' => @$request->numero_expediente,
                'departamento_id' => @$request->caso_departamento_id,
                'municipio_id' => @$request->caso_municipio_id,
                'fecha_notificacion' => @$request->fecha_notificacion,
                'hora_notificacion' => @$request->hora_notificacion,
                'creador_id' => $usuario->id
            ];
            registroBitacora($caso,A_REGISTRAR,C_REGISTRO_CASO,null,$descripcionBitacora,$data);

            $request->merge(['caso_id'=>$caso->id]);
            $this->gestion->asignacion($caso,$usuario->id,$en_captura->id);

        }

        if ($request->tipo_submit == "borrador") {
            $this->guardarInformacion($caso, $request);
            return redirect()->route('casos.informacion', $caso->id)->with('success', 'Información del caso almacenada correctamente.');
        } else {

            $this->guardarInformacion($caso, $request);

            $repetido = Caso::whereNumeroExpediente($request->numero_expediente)->where('id','!=',$caso->id)->first();
            if(isset($repetido) && $repetido->id != $caso->id)
                return redirect()->route('casos.informacion',$caso->id)->with('error','El número de expediente '.$request->numero_expediente.' ya ha sido registrado.')->withInput($request->all());

            $rules = [
                'sanciones' => 'required',
                'numero_expediente' => 'required',
                'fecha_notificacion' => 'required|date|before_or_equal:'.date('Y-m-d')
            ];
            $messages = [
                'sanciones.required' => 'Debe de registrar por lo menos una infracción en la tabla de sanciones.',
                'numero_expediente.required' => 'El número de expediente es requerido.',
                'fecha_notificacion.before_or_equal' => 'La fecha de notificación debe ser menor o igual a la fecha actual ('.date('d/m/Y').').'
            ];

            $validator = Validator::make($request->all(), $rules,$messages);
            $validator->validate();

            if(($request->fecha_notificacion.' '.$request->hora_notificacion)>now())
                return redirect()->route('casos.informacion',$caso->id)->with('error','La fecha y hora de notificación debe de ser menor a la fecha y hora actual')->withInput($request->all());


            $folio_pgr = $caso->folio_registro;
            if (!$folio_pgr) {
                $folio_pgr = 'PGR-' . $this->foliador->generarfolio('pgr');
            }
            $caso->update([
                'folio_registro' => $folio_pgr,
                'estatus_id' => $en_revision->id,
                'fecha_registro' => now()->toDate(),
                'hora_registro' => now()->toTimeString()
            ]);

            $descripcionBitacora = "Se asigna el folio de registro $folio_pgr al caso de id ".$caso->id." y se envía a Revisión";
            registroBitacora($caso,A_ENVIAR,C_REGISTRO_CASO,null,$descripcionBitacora,['folio_registro' => $folio_pgr]);

            $pre_recarga_estatus = precargaEstatus();
            $this->gestion->asignacionRoundRobin($caso,'notificar_pgr_caso',$en_revision->id,true);
            return redirect()->route('casos.index', ['asignado'=>Auth::user()->id, 'not_estatus'=>$pre_recarga_estatus])->with('success', 'Caso turnado a revisión correctamente');
        }
    }

    public function notificarPGR(Request $request)
    {
        $dependencia_id=Auth::user()->dependencia_id;
        $cat_estatus = Catalogo::whereCodigo('estatus_pgr')->first();
        $pendiente = $cat_estatus->elementos()->whereCodigo('pendiente')->first();
        $caso = Caso::findOrFail($request->caso_id);

        ArchivosController::storeSimple($request, 'constancia_firmeza', $caso->getMorphClass(), $caso->id, $dependencia_id);
        ArchivosController::storeSimple($request, 'resolucion_certificada', $caso->getMorphClass(), $caso->id, $dependencia_id);
        $acuse = ArchivosController::storeSimple($request, 'acuse_recibo', $caso->getMorphClass(), $caso->id, $dependencia_id);

        if ($acuse)
            $acuse->update([
                'num_oficio' => $request->numero_oficio_acuse_recibo,
                'fecha_oficio' => $request->fecha_oficio_acuse_recibo
            ]);

        if ($request->tipo_submit == "borrador") {
            return redirect()->route('casos.turno', [$caso->id,'seguimiento-pgr'])->with('success', 'Información del caso almacenada correctamente.');
        } else {
            $rules = [
                'fecha_oficio_acuse_recibo' => 'required|date|before_or_equal:'.date('Y-m-d'),
                'numero_oficio_acuse_recibo' => 'max:256'
            ];
            $messages = [
                'fecha_oficio_acuse_recibo.required' => 'La fecha del acuse de recibo es requerida.',
                'fecha_oficio_acuse_recibo.before_or_equal' => 'La fecha del acuse de recibo debe ser menor o igual a la fecha actual ('.date('d/m/Y').').',
                'numero_oficio_acuse_recibo.max' => 'El campo número expediente pgr no debe contener más de 255 caracteres.',
            ];
            $validator = Validator::make($request->all(), $rules,$messages);
            $validator->validate();
            $this->gestion->asignacionRoundRobin($caso,'asignar_coordinador_caso',$pendiente->id,true);
            return redirect()->route('casos.index')->with('success', 'Caso turnado a PGR correctamente');
        }
    }

    public function getResumen($caso_id,$tab_activa=null)
    {

        if(isset($_GET['tab_activa'])){
            $tab_activa = $_GET['tab_activa'];
        }
        $caso = Caso::findOrFail($caso_id);

        return view('casos.resumen', compact('caso', 'tab_activa'));
    }

    public function actualizarDatosPGR(Request $request)
    {
        $rules = [
            'numero_expediente_pgr' => 'required',
            'fecha_recepcion_pgr' => 'required'
        ];
        $messages = [
            '*.required' => 'Campo obligatorio'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();
        if (isset($request->caso_id)) {
            $caso = Caso::findOrFail($request->caso_id);
            $caso->update([
                'numero_expediente_pgr' => @$request->numero_expediente_pgr,
                'fecha_recepcion_pgr' => @$request->fecha_recepcion_pgr
            ]);
        }
        return redirect()->route('casos.getResumen', $caso->id)->with('success', 'Información del caso almacenada correctamente.');
    }

    public function eliminarCaso(Request $request)
    {
        $rules = [
            'caso_id' => 'required'
        ];
        $messages = [
            '*.required' => 'Campo obligatorio'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();
        if (isset($request->caso_id)) {
            $caso = Caso::findOrFail($request->caso_id);
            $caso->delete();
        }
        $pre_recarga_estatus = precargaEstatus();
        return redirect()->route('casos.index', ['asignado'=>Auth::user()->id, 'not_estatus'=>$pre_recarga_estatus])->with('success', 'Caso eliminado correctamente.');
    }

    public function guardarInformacion($caso, $request)
    {
        $caso->sanciones()->delete();
        if (isset($request->sanciones) && count($request->sanciones) > 0) {
            $total = "0";
            foreach ($request->sanciones as $k => $v) {
                $cantidad_multa = str_replace(',', '', str_replace('L ', '', $v["'monto'"]));
                Sancion::updateOrCreate([
                    'caso_id' => $caso->id,
                    'tipo_id' => $v["'infraccion_id'"],
                ], [
                    'caso_id' => $caso->id,
                    'tipo_id' => $v["'infraccion_id'"],
                    'cantidad_multa' => $cantidad_multa
                ]);
                $total = bcadd( $total ,$cantidad_multa,2);
            }
            $caso->update(['total_multa' => $total]);
        } else
            $caso->update(['total_multa' => '0.00']);

        $empresa = Empresa::updateOrCreate([
            'caso_id' => $caso->id
        ], [
            'caso_id' => $caso->id,
            'nombre_comercial' => $request->nombre_comercial,
            'razon_social' => $request->razon_social,
            'correo' => $request->email_empresa,
            'telefono' => $request->telefono_empresa
        ]);

        RepresentanteLegal::updateOrCreate([
            'empresa_id' => $empresa->id
        ], [
            'empresa_id' => $empresa->id,
            'num_identificacion' => $request->identificacion_representante,
            'nombre' => $request->nombre_representante,
            'correo' => $request->email_representante,
            'telefono' => $request->telefono_representante
        ]);

        $this->domicilio->guardarDomicilio($request, $caso);

        $pgr = CatalogoElemento::whereCodigo('pgr')->first()->id;
        //if(isset($request->documento_archivo_ficha_averiguacion)){
            ArchivosController::storeSimple($request, 'ficha_averiguacion', $caso->getMorphClass(), $caso->id, $pgr);
        /*}else{
            $codigo_ficha_averiguacion = CatalogoElemento::where('codigo', 'ficha_averiguacion')->first()->id;
            $doc_ficha_averiguacion = Documento::where('entidad_id', $caso->id)->where('tipo_documento_id', $codigo_ficha_averiguacion)->first();
            if($doc_ficha_averiguacion != null){
                $doc_ficha_averiguacion->delete();
                Storage::delete($doc_ficha_averiguacion->ruta);
            }

        }*/


        $data = [
            'sanciones'=>[$caso->sanciones->toArray()],
            'empresa'=>[$empresa->toArray()],
            'domicilio'=>[$caso->domicilio->toarray()]
        ];

        $descripcionBitacora = 'Se actualiza la información del caso de id '.$caso->id.' con estatus '.$caso->estatus->nombre;
        registroBitacora($caso,A_ACTUALIZAR,C_REGISTRO_CASO,null,$descripcionBitacora,$data);
    }


    // TURNADO
    public function turno($id, $tipo)
    {
        $data = [];
        $caso = Caso::find($id);
        $data['caso'] = $caso;

        $catalogo = Catalogo::where('codigo', 'estatus_pgr')->first();
        $registrosEstatus = $catalogo->elementos;

        $data['usuarios'] = [];

        $data['estatus'] = $registrosEstatus->where('codigo', 'captura')->first();

        switch ($tipo) {
            case 'coordinador':
                $data['tipo_turno'] = 'Turnar caso a coordinador';
                $data['usuarios'] = User::permission('turnar_procurador_caso')->get();
                $data['estatus'] = $registrosEstatus->where('codigo', 'turnado_coordinador')->first();
                return view('casos.turno.para-coordinador', $data);
            case 'procurador':
                $data['tipo_turno'] = 'Turnar caso a procurador';
                $data['usuarios'] = User::permission('iniciar_proceso_caso')->get();
                $data['estatus'] = $registrosEstatus->where('codigo', 'turnado_procurador')->first();
                return view('casos.turno.para-procurador', $data);
            case 'nuevoprocurador':
                $data['tipo_turno'] = 'Reasignar procurador';
                $data['usuarios'] = User::permission('iniciar_proceso_caso')->get();
                $data['estatus'] = $caso->estatus;
                return view('casos.turno.reasignar-procurador', $data);
            case 'seguimiento-pgr':
                $data['tipo_turno'] = 'Solicitar seguimiento a PGR';
                $data['estatus'] = $caso->estatus;
                return view('casos.turno.seguimiento-pgr', $data);
            default:
                $data['tipo_turno'] = 'Turnar a';
                return view('casos.turno.turno', $data);
        }
    }

    public function rechazo($id, $tipo)
    {
        $data = [];
        $caso = Caso::find($id);

        $catalogo = Catalogo::where('codigo', 'estatus_pgr')->first();
        $registrosEstatus = $catalogo->elementos;

        $data['caso'] = $caso;
        $data['usuarios'] = [];
        $data['estatus'] = null;

        switch ($tipo) {
            case 'analista':

                $estatusAnterior = $registrosEstatus->where('codigo', 'revision')->first();
                $ultimaGestion = $caso->gestion->where('estatus_id', $estatusAnterior->id)->first();
                $autorAnterior = $ultimaGestion ? $ultimaGestion->creador : false;

                $data['tipo_turno'] = 'Regresar a inspector';
                $data['asignado'] = $autorAnterior;
                $data['usuarios'] = $autorAnterior ? false : User::permission('enviar_revision_caso')->get();
                $data['estatus'] = $registrosEstatus->where('codigo', 'rechazado_analista')->first();

                return view('casos.turno.rechazo-analista', $data);

            case 'regional':

                $estatusAnterior = $registrosEstatus->where('codigo', 'turnado_coordinador')->first();
                $ultimaGestion = $caso->gestion->where('estatus_id', $estatusAnterior->id)->first();
                $autorAnterior = $ultimaGestion ? $ultimaGestion->creador : false;
                $catalogoMotivos = Catalogo::whereCodigo('rechazo_coordinador')->first();

                $data['tipo_turno'] = 'Regresar a DNPJ';
                $data['asignado'] = $autorAnterior;
                $data['motivos'] = $catalogoMotivos->elementos;
                $data['usuarios'] = $autorAnterior ? false : User::permission('asignar_coordinador_caso')->get();
                $data['estatus'] = $registrosEstatus->where('codigo', 'rechazado_coordinador')->first();

                return view('casos.turno.rechazo-regional', $data);

            case 'procurador':

                $estatusAnterior = $registrosEstatus->where('codigo', 'turnado_procurador')->first();
                $ultimaGestion = $caso->gestion->where('estatus_id', $estatusAnterior->id)->first();
                $autorAnterior = $ultimaGestion ? $ultimaGestion->creador : false;
                $catalogoMotivos = Catalogo::whereCodigo('rechazo_procurador')->first();

                $data['tipo_turno'] = 'Regresar a Coordinador';
                $data['asignado'] = $autorAnterior;
                $data['motivos'] = $catalogoMotivos->elementos;
                $data['usuarios'] = $autorAnterior ? false : User::permission('turnar_procurador_caso')->get();
                $data['estatus'] = $registrosEstatus->where('codigo', 'rechazado_procurador')->first();

                return view('casos.turno.rechazo-procurador', $data);

            default:
                $data['tipo_turno'] = 'Rechazar';
                return view('casos.turno.turno', $data);
        }
    }

    public function turnar(Request $request)
    {
        $caso_id = $request->input('caso');
        $caso = Caso::find($caso_id);
        $instrucciones = $request->input('instrucciones');
        $usuario = $request->input('usuario');
        $tipoTurno = $request->input('tipo_turno');
        $motivo = $request->has('motivo') ? $request->input('motivo') : null;
        if($motivo != null){
            $instrucciones = CatalogoElemento::where('id', $motivo)->first()->nombre;
        }
        $estatus_id = $request->input('estatus');
        $catalogo = Catalogo::where('codigo', 'estatus_pgr')->first();
        $turnadoCoordinador = $catalogo->elementos->where('codigo', 'turnado_coordinador')->first();

        $rules = [
            'instrucciones_longitud' => 'lt:1700',
            'numero_expediente_pgr' => 'max:256',
            'fecha_recepcion_pgr' => 'before_or_equal:'.date('Y-m-d')
        ];
        $messages = ['instrucciones_longitud.lt' => 'El número de caracteres de las instrucciones debe ser menor a 1700.',
        'numero_expediente_pgr.max' => 'El campo número expediente pgr no debe contener más de 255 caracteres.',
        'fecha_recepcion_pgr.before_or_equal' => 'La fecha debe ser igual o anterior a la actual'
    ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        if ($turnadoCoordinador && $turnadoCoordinador->id == $estatus_id) {
            $rules = [
                'numero_expediente_pgr' => 'required',
                'fecha_recepcion_pgr' => 'required'
            ];
            $messages = [
                '*.required' => 'Campo obligatorio'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            $validator->validate();

            $repetido = Caso::whereNumeroExpedientePgr($request->numero_expediente_pgr)->where('id','!=',$caso->id)->first();
            if(isset($repetido) && $repetido->id != $caso->id)
                return redirect()->back()->withErrors(['numero_expediente_pgr'=>'El número de expediente ya ha sido asignado'])->withInput($request->all());

            $caso->update([
                'numero_expediente_pgr' => @$request->numero_expediente_pgr,
                'fecha_recepcion_pgr' => @$request->fecha_recepcion_pgr
            ]);
        }

        $usuarioDestino = User::find($usuario);
        $this->gestion->asignacion($caso,$usuarioDestino->id,$estatus_id, $instrucciones, $motivo);

        try {
                Mail::to($usuarioDestino->email)->send(new Notificacion($usuarioDestino, $tipoTurno, null, [
                    'autor' => auth()->user()->complete_name,
                    'url' => config('app.url'),
                    'instrucciones' => $instrucciones,
                    'numero_expediente' => $caso->numero_expediente,
                    'numero_expediente_pgr' => $caso->numero_expediente_pgr,
                ]));
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }

        return redirect("/casos")->with('success', 'Información del caso almacenada correctamente.');
    }

    public function resolucionIniciarProceso($caso_id){
        $caso = Caso::where('id',$caso_id)->first();
        $catalogo = Catalogo::where('codigo', 'estatus_pgr')->first();
        $estatus = $catalogo->elementos->where('codigo', 'proceso')->first();

        $this->gestion->asignacion($caso, $caso->usuario_asignado_id, $estatus->id);

        $caso->estatus_id = $estatus->id;
        $caso->save();

        return redirect()->route('casos.getResumen', $caso_id)->with('success', 'Información del caso almacenada correctamente.');
    }

    public function convenioPago(Request $request)
    {
        $pago = Pago::where('convenio_id', $request->input('convenio'))->where('num_pago', $request->input('num_pago'))->first();

        $intereses = str_replace(',','', $request->input('intereses')??'0.00');
        $monto_pagado = str_replace(',','', $request->input('monto_pagado') );

        $pago->fecha_pagado = $request->input('fecha_pagado');
        $pago->num_recibo = $request->input('num_recibo');

        $pago->intereses = $intereses;
        $pago->monto_pagado = $monto_pagado;
        $pago->monto_pagado_intereses = bcadd($intereses,$monto_pagado,2);
        $pago->pagado = true;

        $guardado = $pago->save();

        $total_sin_intereses = "0.00";
        $total_con_intereses = "0.00";

        foreach ($pago->convenio->pagos as $pago){
            $total_sin_intereses = bcadd($total_sin_intereses,$pago->monto_pagado,2);
            $total_con_intereses = bcadd($total_con_intereses,$pago->monto_pagado_intereses,2);
        }

        $caso = $pago->convenio->caso;
        $caso->total_cobrado = $total_sin_intereses;
        $caso->total_cobrado_intereses = $total_con_intereses;
        $convenio = Convenio::where('id',$request->input('convenio'))->first();
        if($request->input('num_pago') == $convenio->num_pagos){
            $catalogo = Catalogo::where('codigo', 'estatus_pgr')->first();
            $estatus = $catalogo->elementos->where('codigo', 'pago_total')->first();
            $caso->estatus_id = $estatus->id;
        }


        if ($guardado && $caso->save()) {
            if ($total_sin_intereses >= $caso->total_multa) {
                return back()->with('success', 'Se ha cubierto el monto total a cobrar ¿desea cerrar el caso?');
            }
            return back()->with('success', 'La información ha sido actualizada correctamente.');

        }
        return back()->with('error', 'Ha ocurrido un error al actualizar la información del pago.');
    }

    public function convenioConcluir(Request $request)
    {
        try {
            $caso = Caso::find($request->input('caso'));

            $catalogo = Catalogo::where('codigo', 'estatus_pgr')->first();
            $estatus = $catalogo->elementos->where('codigo', 'pago_total')->first();

            $this->gestion->asignacion($caso, auth()->user()->id, $estatus->id, 'Se concluye convenio', false);

            return back()->with('success', 'El convenio ha sido concluido correctamente.');

        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Ha ocurrido un error al concluir el convenio.');
        }
    }

    public function reporteMensualPagos(Request $request){
        $meses = [1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre"];
        $encabezados=[0=>$meses[$request->mes]." de ".$request->anio];
        $registros[0]=['Expediente SETRASS','Expediente PGR','Fecha de notificación','Resolución','Fecha del pago','Fecha del registro del pago','Tipo de Pago','Monto (L)','Intereses (L)', 'Monto total (L)'];

        $pagos = DB::select("
            select c.numero_expediente,c.numero_expediente_pgr,c.fecha_notificacion::date as fecha_notificacion,'Pago convenio' as tipo_pago,
               p.fecha_pagado::date as fecha_pago,
               p.fecha::date as fecha_registro,
               'Extrajudicial' as tipo_cobro,
               p.monto_pagado,
               p.intereses,
               p.monto_pagado_intereses as monto_total
            from pagos p inner join convenios co on co.id=p.convenio_id inner join casos c on c.id=co.caso_id where pagado=true and p.deleted_at is null
               and extract(MONTH from fecha_pagado)=$request->mes and extract(YEAR from fecha_pagado)=$request->anio

            union

            select c.numero_expediente,c.numero_expediente_pgr,c.fecha_notificacion::date as fecha_notificacion,'Pago total' as tipo_pago,
               fecha::date as fecha_pago,
               pt.created_at::date as fecha_registro,
               case when pt.tipo_pago_id is null then 'Extrajudicial' else ce.nombre end as tipo_cobro,
               monto as monto_pagado,
               interes as intereses,
               monto_total
            from pagos_totales pt
                inner join casos c on c.id=pt.caso_id
                left join catalogo_elementos ce on ce.id=pt.tipo_pago_id
                where pt.deleted_at is null
                and extract(MONTH from pt.created_at)=$request->mes and extract(YEAR from pt.created_at)=$request->anio

            order by fecha_pago desc");

        $monto_pagado = $intereses = $monto_total=0;

        foreach ($pagos as $i){
            $monto_pagado = bcadd($monto_pagado,$i->monto_pagado,2);
            $i->monto_pagado=lempiras($i->monto_pagado);
            $intereses = bcadd($intereses,$i->intereses,2);
            $i->intereses = lempiras($i->intereses);
            $monto_total = bcadd($monto_total,$i->monto_total,2);
            $i->monto_total=lempiras($i->monto_total);
        }

        $totales = [
            '','','','','','','Total',
            lempiras($monto_pagado),
            lempiras($intereses),
            lempiras($monto_total)
        ];

        $registros = array_merge($registros,$pagos);

        $registros[]=['','','','','', ''];
        $registros[]=$totales;
        registroBitacora(null,A_EXPORTAR,C_BANDEJA_CASOS,"Tablero de información","Exportación de reporte mensual de pagos ".$meses[$request->mes]." de ".$request->anio);
        return Excel::download(new PagosExport($registros,$encabezados), 'pagos_' . $meses[$request->mes]."_".$request->anio . '.xlsx');
    }
    public function no_procedente($caso_id){
        $data['caso'] = Caso::where('id',$caso_id)->first();;
        $catalogo = Catalogo::where('codigo', 'estatus_pgr')->first();
        $registrosEstatus = $catalogo->elementos;
        $data['estatus'] = $registrosEstatus->where('codigo', 'no_procedente')->first();
        return view('casos.turno.no-procedente', $data);

    }

    public function noProcedenteCrear(Request $request){
        $rules = [
            'motivos' => 'required',
            'motivos_longitud' => 'lt:1700'
        ];
        $messages = [
            '*.required' => 'Campo obligatorio',
            'motivos_longitud.lt' => 'El número de caracteres de los motivos debe ser menor a 1700.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();
        $caso = Caso::where('id',$request->caso_id)->first();
        $catalogo = Catalogo::where('codigo', 'estatus_pgr')->first();
        $registrosEstatus = $catalogo->elementos;
        $estatus = $registrosEstatus->where('codigo', 'no_procedente')->first();


        $estatusAnterior = $registrosEstatus->where('codigo', 'revision')->first();
        $ultimaGestion = $caso->gestion->where('estatus_id', $estatusAnterior->id)->first();
        $autorAnterior = $ultimaGestion ? $ultimaGestion->creador : false;
        if($autorAnterior == null){
            $autorAnterior = User::whereHas('roles', function ($query) {
                                $query->where('name', 'admin_setrass');
                            })->first();
        }
        $this->gestion->asignacion($caso,$autorAnterior->id,$estatus->id, $request->motivos);
        return redirect()->route('casos.getResumen', $caso->id)->with('success', 'Información del caso almacenada correctamente.');
    }


    public function showOtroDescargo(Caso $id){
        $caso = $id;
        return view('casos.resolucion.otro-descargo',compact('caso'));
    }

    public function storeOtroDescargo(Request $request){
        $rules = [
            'motivo' => 'required',
            'observaciones_longitud' => 'lt:1700'
        ];
        $messages = [
            '*.required' => 'Campo obligatorio',
            'observaciones_longitud.lt' => 'El número de caracteres de las observaciones debe ser menor a 1700.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();
        $caso = Caso::where('id',$request->caso_id)->first();
        $catalogo = Catalogo::where('codigo', 'estatus_pgr')->first();
        $registrosEstatus = $catalogo->elementos;
        $resolucion = $registrosEstatus->where('codigo', 'otro_descargo')->first();
        $this->gestion->asignacion($caso,Auth::id(),$resolucion->id, $request->observaciones);

        Resolucion::updateOrCreate(
            [
                'caso_id'=>$caso->id,
                'monto'=>'00.0',
                'tipo_resolucion_id'=>$resolucion->id,
                'motivo_id'=>$request->motivo
            ],
            [
                'caso_id'=>$caso->id,
                'monto'=>'00.0',
                'fecha'=>now(),
                'tipo_resolucion_id'=>$resolucion->id,
                'motivo_id'=>$request->motivo,
                'observaciones'=>$request->observaciones
            ]);

        $usuarios_ids = $caso->gestion()->with('asignado')->pluck('usuario_asignado_id')->unique()->toArray();
        $usuarios_activos = User::whereIn('id',$usuarios_ids)->where('activo',true)->get();

        foreach ($usuarios_activos as $usuario){
            try{
                Mail::to($usuario->email)->send(new Notificacion($usuario, 'otro_descargo', null, [
                    'autor' => auth()->user()->complete_name,
                    'url' => config('app.url'),
                    'numero_expediente' => $caso->numero_expediente,
                    'numero_expediente_pgr' => $caso->numero_expediente_pgr,
                ]));
            }
            catch (\Exception $e){
                Log::error($e->getMessage());
            }
        }
        return redirect()->route('casos.getResumen',[$caso->id,'otro_descargo'])->with('success', 'Información del caso almacenada correctamente.');
    }

    public function cambioInfoPendiente(Request $request, $id)
    {
        $caso = Caso::find($id);

        $catalogo = Catalogo::whereCodigo('estatus_pgr')->first();
        $estatus = $catalogo->elementos->where('codigo', 'info_pendiente')->first()->id;

        $caso->estatus_id = $estatus;
        $caso->save();

        $catalogo = Catalogo::whereCodigo('dependencias')->first();
        $setrassId = $catalogo->elementos->where('codigo', 'setrass')->first()->id;

        $usuariosSetrassInvolucrados = $caso->gestion()
            ->whereHas('asignado', function ($query) use ($setrassId) {
                $query->where('dependencia_id', $setrassId);
            })
            ->get();

        foreach ($usuariosSetrassInvolucrados as $usuario){
            try{
                Mail::to($usuario->asignado->email)->send(new Notificacion($usuario->asignado, 'infoPendiente', null, [
                    'autor' => auth()->user()->complete_name,
                    'url' => config('app.url'),
                    'numero_expediente' => $caso->numero_expediente,
                    'numero_expediente_pgr' => $caso->numero_expediente_pgr,
                ]));
            }
            catch (\Exception $e){
                Log::error($e->getMessage());
            }
        }

        return redirect()->route('casos.getResumen',[$caso->id,''])->with('success', 'El estatus del caso ha sido actualizado correctamente.');
    }


}
