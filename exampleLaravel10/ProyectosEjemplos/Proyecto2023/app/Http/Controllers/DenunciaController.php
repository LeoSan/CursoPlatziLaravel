<?php

namespace App\Http\Controllers;

use App\Mail\{Notificacion, NotificacionPublica};
use App\Models\{Catalogo, CatalogoElemento, Denuncia, DenunciaInforme, Documento, GestionDenuncia, User, Role};
use App\Services\{FoliosService, UsuariosService, DenunciasService};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Log, Mail, Validator};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Contracts\Routing\UrlGenerator;
use Carbon\Carbon;


class DenunciaController extends Controller
{
    protected $foliador;
    public $servicio_usuarios;
    public $control_dias_inhabiles;

    public function __construct()
    {
        $this->foliador = new FoliosService();
        $this->servicio_usuarios = new UsuariosService();
        $this->control_dias_inhabiles = new DiasInhabilesController();
    }
    /**
     * Description: Metodo permite mostrar la bandeja de denuncias
     *
     * @param Request $request
     *
     */
    public function index(Request $request)
    {
        return view('denuncias.index');
    }
    /**
     * Description: Metodo permite mostrar el formulario
     *
     * @param Request $request
     */
    public function showFormulario(Request $request)
    {
        $parametros['fecha_actual'] = date("d-m-Y");
        $parametros['id'] = empty(Auth::id()) ? 0 : Auth::id();
        $itemsbread = [
            ['nombreComponente' => 'Denuncias',              'ruta'=> route('denuncias.index'), 'value'=>'null'  ],
            ['nombreComponente' => 'Generar denuncia',       'ruta'=> '#'         , 'value'=>'active' ]
        ];
        return view('denuncias.formulario', compact('parametros', 'itemsbread'));
    }
    /**
     * Description: Metodo permite mostrar el formulario
     *
     * @param Int $id
     */
    public function showAlta(int $id)
    {
        $denuncia  = Denuncia::where('id', $id)->first();
        if (!$denuncia) {
            return redirect()->route('denuncias.index');
        }
        $num_exp = $this->generaNumExpedienteFormato('ATI', 'ROM', $denuncia->region_departamento_id, $denuncia->region_municipio_id);
        $usuario_asignado_id = auth()->id();
        $itemsbread = [
            ['nombreComponente' => 'Denuncias',       'ruta'=> route('denuncias.index'),  'value'=>'null'  ],
            ['nombreComponente' => $denuncia->folio,  'ruta'=> "/denuncias/$id/detalle/", 'value'=>'null' ],
            ['nombreComponente' => 'Alta Denuncia',   'ruta'=> '#',                       'value'=>'active' ]
        ];
        return view('denuncias.formAlta', compact( 'itemsbread', 'denuncia', 'num_exp', 'usuario_asignado_id'));
    }
    /**
     * Description: Metodo permite mostrar el formulario
     *
     * @param Int $id
     */
    public function showProvidencia(int $id)
    {
        $denuncia  = Denuncia::where('id', $id)->first();
        if (!$denuncia) {
            return redirect()->route('denuncias.index');
        }
        $itemsbread = [
            ['nombreComponente' => 'Denuncias',       'ruta'=> route('denuncias.index'),  'value'=>'null'  ],
            ['nombreComponente' =>  $denuncia->folio, 'ruta'=> "/denuncias/$id/detalle/", 'value'=>'null' ],
            ['nombreComponente' => 'Providencia',     'ruta'=> '#',                      'value'=>'active' ]
        ];
        return view('denuncias.formProvidencia', compact( 'itemsbread', 'denuncia' ));
    }
    /**
     * Description: Metodo permite mostrar el formulario
     *
     * @param Int $id
     */
    public function showSolicitarExpediente(int $id)
    {
        $denuncia   = Denuncia::where('id', $id)->first();
        if (!$denuncia) {
            return redirect()->route('denuncias.index');
        }
        $rol_jefe_regional_id = Role::where('name', 'jefe_regional')->first()->id;
        $regi_denuncia_id     = $denuncia->oficina_regional_id;
        $usuario_region_list  = User::select('id', 'name', 'first_name','last_name', 'perfil_id', 'regional_id')->where('activo', 1)->role('jefe_regional')->orderBy('complete_name', 'ASC')->get();
        $itemsbread = [
            ['nombreComponente' => 'Denuncias',            'ruta'=>route('denuncias.index'),             'value'=>'null'  ],
            ['nombreComponente' => $denuncia->folio,       'ruta'=> "/denuncias/$id/detalle/", 'value'=>'null' ],
            ['nombreComponente' => 'Solicitar expediente', 'ruta'=> '#',                      'value'=>'active' ]
        ];
        return view('denuncias.formSolicitarExpediente', compact( 'itemsbread', 'denuncia', 'usuario_region_list', 'rol_jefe_regional_id'));
    }
    /**
     * Description: Metodo permite mostrar el detalle de una denuncia
     *
     * @param  mixed $id
     *
     */
    public function showDetalle(int $id)
    {
        $denuncia       = Denuncia::where('id', $id)->first();
        if (!$denuncia) {
            return redirect()->route('denuncias.index');
        }
        $doc_alta_denun = '';
        $doc_providencia_denuncia = '';
        $itemsbread = [
            ['nombreComponente' => 'Denuncias',        'ruta'=> route('denuncias.index'), 'value'=>'null'  ],
            ['nombreComponente' => $denuncia->folio,   'ruta'=> '#'         , 'value'=>'active' ]
        ];

        $codigo_denuncia_doc          = CatalogoElemento::where('codigo', 'oficio_denuncia')->first()->id;
        $codigo_pruebas_doc           = CatalogoElemento::where('codigo', 'pruebas_denuncia')->first()->id;
        $codigo_alta_denuncia_doc     = CatalogoElemento::where('codigo', 'alta_denuncia')->first()->id;
        $codigo_providencia_doc       = CatalogoElemento::where('codigo', 'providencia_denuncia')->first()->id;
        $codigo_resp_providencia_doc  = CatalogoElemento::where('codigo', 'pruebas_denuncia_resp_providencia')->first()->id;
        $codigo_solicitar_expe_doc    = CatalogoElemento::where('codigo', 'oficio_solicitar_expediente')->first()->id;
        $codigo_desistimiento_doc     = CatalogoElemento::where('codigo', 'desistimiento_denuncia')->first()->id;
        $codigo_oficio_inadmision_doc       = CatalogoElemento::where('codigo', 'oficio_inadmision_denuncia')->first()->id;
        $codigo_acuse_recibo_informe_final_doc       = CatalogoElemento::where('codigo', 'acuse_recibo_informe_final')->first()->id;
        $codigo_informe_final_doc       = CatalogoElemento::where('codigo', 'informe_final')->first()->id;

        $documento                  = Documento::where('entidad_id', $id)->where('tipo_documento_id', $codigo_denuncia_doc)->first();
        $doc_evidencias_denuncia    = Documento::where('entidad_id', $id)->where('tipo_documento_id', $codigo_pruebas_doc)->get();
        $doc_alta_denun             = Documento::where('entidad_id', $denuncia->id)->where('tipo_documento_id', $codigo_alta_denuncia_doc)->first();
        $doc_providencia_denuncia   = Documento::where('entidad_id', $denuncia->id)->where('tipo_documento_id', $codigo_providencia_doc)->first();
        $doc_resp_providencia       = Documento::where('entidad_id', $id)->where('tipo_documento_id', $codigo_resp_providencia_doc)->get();
        $doc_solicitar_expe         = Documento::where('entidad_id', $id)->where('tipo_documento_id', $codigo_solicitar_expe_doc)->first();
        $doc_desistimiento_denuncia = Documento::where('entidad_id', $id)->where('tipo_documento_id', $codigo_desistimiento_doc)->get();

        $doc_acuse_recibo_informe_final_denuncia = Documento::where('entidad_id', $id)->where('tipo_documento_id', $codigo_acuse_recibo_informe_final_doc)->first();
        $doc_informe_final = Documento::where('entidad_id', $id)->where('tipo_documento_id', $codigo_informe_final_doc)->first();


        $doc_oficio_inadmsion_denuncia = Documento::where('entidad_id', $id)->where('tipo_documento_id', $codigo_oficio_inadmision_doc)->first();
        //Calculo numero expediente
        $num_exp = $this->generaNumExpedienteFormato('ATI', 'ROM', $denuncia->region_departamento_id, $denuncia->region_municipio_id);
        $usuario_id_login = auth()->id();
        //Vista
        $descripcionBitacora = 'Se consulta la información de la denuncia con folio ' . $denuncia->folio . ' con estatus ' . $denuncia->estatus->nombre;
        registroBitacora($denuncia, A_CONSULTAR, C_DETALLE_DENUNCIA, null, $descripcionBitacora);
        $codigo_respuesta_solicitud_expediente = CatalogoElemento::where('codigo', 'respuesta_solicitud_expediente')->first()->id;
        $docs_respuesta_solicitud_expediente = Documento::where('entidad_id', $denuncia->id)->where('tipo_documento_id', $codigo_respuesta_solicitud_expediente)->get();

        if(strstr(url()->previous(), 'bandeja')){
             session()->put('url_back_bandeja_denuncia',url()->previous());
        }
        //Redirect a bandeja
        return view('denuncias.detalle', compact('denuncia', 'itemsbread', 'documento', 'doc_evidencias_denuncia', 'doc_alta_denun', 'doc_providencia_denuncia','doc_resp_providencia', 'doc_solicitar_expe','doc_desistimiento_denuncia','doc_oficio_inadmsion_denuncia', 'num_exp', 'usuario_id_login','docs_respuesta_solicitud_expediente', 'doc_acuse_recibo_informe_final_denuncia', 'doc_informe_final' ));
    }
    public function cargarInforme(Request $request, $id)
    {
        $denuncia       = Denuncia::where('id', $id)->first();
        if (!$denuncia) {
            return redirect()->route('denuncias.index');
        }

        $itemsbread = [
            ['nombreComponente' => 'Denuncias',        'ruta'=> route('denuncias.index'), 'value'=>'null'  ],
            ['nombreComponente' => $denuncia->folio,   'ruta'=> route('denuncias.detalle',$denuncia->id), 'value'=>'null' ],
            ['nombreComponente' => 'Cargar informe',   'ruta'=> '#'         , 'value'=>'active' ]
        ];

        return view('denuncias.informe-crear', compact('denuncia', 'itemsbread'));
    }

    public function comentarInforme(Request $request, $id)
    {
        $denuncia       = Denuncia::where('id', $id)->first();
        if (!$denuncia) {
            return redirect()->route('denuncias.index');
        }
        $informe = $denuncia->informe;
        $itemsbread = [
            ['nombreComponente' => 'Denuncias',        'ruta'=> route('denuncias.index'), 'value'=>'null'  ],
            ['nombreComponente' => $denuncia->folio,   'ruta'=> route('denuncias.detalle',$denuncia->id), 'value'=>'null' ],
            ['nombreComponente' => 'Comentar informe',   'ruta'=> '#'         , 'value'=>'active' ]
        ];
        return view('denuncias.informe-comentar', compact('denuncia', 'itemsbread', 'informe'));
    }
    /**
     * Description: Metodo permite mostrar el detalle de una denuncia
     *
     * @param  mixed $id
     * return route(denuncias.registro) | view Información adicional de la denuncia
     */
    public function showInformacionAdicional(int $id)
    {
        //Consulta
        $denuncia    = Denuncia::where('id', $id)->first();
        if (!$denuncia) {
            return redirect()->route('denuncias.registro');
        }
        $numero_exp  = Denuncia::whereYear('created_at', date('Y'))->count() + 1;
        $itemsbread = [
            ['nombreComponente' => 'Denuncias',        'ruta'=> route('denuncias.index'), 'value'=>'null'  ],
            ['nombreComponente' => $denuncia->folio,   'ruta'=> '#'         , 'value'=>'active' ]
        ];

        $codigo_denuncia_doc          = CatalogoElemento::where('codigo', 'oficio_denuncia')->first()->id;
        $codigo_pruebas_doc           = CatalogoElemento::where('codigo', 'pruebas_denuncia')->first()->id;
        $codigo_alta_denuncia         = CatalogoElemento::where('codigo', 'alta_denuncia')->first()->id;
        $codigo_providencia_doc       = CatalogoElemento::where('codigo', 'providencia_denuncia')->first()->id;
        $codigo_desistimiento_doc     = CatalogoElemento::where('codigo', 'desistimiento_denuncia')->first()->id;
        $codigo_oficio_inadmision_doc = CatalogoElemento::where('codigo', 'oficio_inadmision_denuncia')->first()->id;
        $codigo_resp_providencia_doc  = CatalogoElemento::where('codigo', 'pruebas_denuncia_resp_providencia')->first()->id;

        $documento                   = Documento::where('entidad_id', $id)->where('tipo_documento_id', $codigo_denuncia_doc)->first();
        $doc_evidencias_denuncia     = Documento::where('entidad_id', $id)->where('tipo_documento_id', $codigo_pruebas_doc)->get();
        $doc_resp_providencia        = Documento::where('entidad_id', $id)->where('tipo_documento_id', $codigo_resp_providencia_doc)->get();
        $doc_providencia_denuncia    = Documento::where('entidad_id', $denuncia->id)->where('tipo_documento_id', $codigo_providencia_doc)->first();
        $doc_desistimiento_denuncia  = Documento::where('entidad_id', $denuncia->id)->where('tipo_documento_id', $codigo_desistimiento_doc)->first();
        $doc_oficio_inadmsion_denuncia  = Documento::where('entidad_id', $denuncia->id)->where('tipo_documento_id', $codigo_oficio_inadmision_doc)->first();
        $doc_alta_denuncia           = Documento::where('entidad_id', $denuncia->id)->where('tipo_documento_id', $codigo_alta_denuncia)->first();

        return view('denuncias.adicional', compact('denuncia', 'documento', 'doc_evidencias_denuncia', 'doc_alta_denuncia', 'doc_providencia_denuncia', 'doc_resp_providencia', 'doc_desistimiento_denuncia','doc_oficio_inadmsion_denuncia',  'itemsbread' ));
    }
    /**
     * Description: Metodo para dar de alta denuncia
     *
     * @param  mixed $request
     *
     */
    public function storeAltaDenuncia(Request $request)
    {
        $rules = [
            'num_expediente' => 'required',
            'observacion_alta' => 'required',
            'observacion_alta_longitud' => 'lt:1701'
        ];
        $messages = [
            'num_expediente' => 'Campo obligatorio',
            '*.required' => 'Campo obligatorio',
            'observacion_alta_longitud.lt' => 'El número de caracteres de las observaciones debe ser menor o igual a 1700.'
        ];
        Validator::make($request->all(), $rules, $messages);
        $denuncia = Denuncia::find($request->denuncia_id);
        $num_exp = $this->generaNumExpedienteFormato('ATI', 'RAM', $denuncia->region_departamento_id, $denuncia->region_municipio_id);
        $dependencia_id = CatalogoElemento::where('codigo', 'setrass')->first()->id;
        $status_id      = CatalogoElemento::where('codigo', 'en_revision')->first()->id;

        //Actualizamos estatus
        $denuncia->estatus_id          = $status_id;
        $denuncia->num_expediente_dgit = $request->num_expediente_dgit;
        $denuncia->num_expediente      = $num_exp;
        $denuncia->correo_dgit         = $request->correo_dgit;
        $denuncia->usuario_asignado_id = $request->expediente_usuario_id;
        $denuncia->save();

        GestionDenuncia::create([
            "denuncia_id" => $request->denuncia_id,
            "estatus_id"  => $status_id,
            "motivo_id"   => null,
            "observacion" => $request->observacion_alta,
            "usuario_asignado_id" => $request->expediente_usuario_id,
            "creador_id" => $request->expediente_usuario_id,
        ]);

        //Carga Archivo Oficio
        $archivo = $request->file('documento_archivo_alta_denuncia');
        if ($archivo) {
            ArchivosController::storeSimple($request, 'alta_denuncia', $denuncia->getMorphClass(), $denuncia->id, $dependencia_id, $request->num_expediente);
        }
        try {
            $extras['numero_expediente'] = $request->num_expediente_dgit;
            $extras['num_expediente_ati'] = $request->num_expediente;
            $usuarioModelo = User::find($request->expediente_usuario_id);

            if ($request->notificacion_dgit && $request->correo_dgit) {
                Mail::to($request->correo_dgit)->send(new Notificacion($usuarioModelo, 'denunciaAltaDgit', 'Denuncia presentada ante la ATI para el expediente ' . $extras['numero_expediente'] . '.', $extras));
            }
             Mail::to($usuarioModelo->email)->send(new Notificacion($usuarioModelo, 'denunciaAlta', 'Notificación a la DGIT de denuncia vinculada a inspección en proceso, num Exp: ' . $extras['numero_expediente'] . '.', $extras['numero_expediente']));

        } catch(\Exception $e){
            Log::info("Error: Se generó un error al enviar el correo durante el proceso de Alta de Expediente:".$e->getMessage());
        }
        registroBitacora($denuncia, A_ACTUALIZAR, C_DENUNCIAS, null, 'Se realizó alta de la denuncia de manera correcta con folio ' . $denuncia->folio. ' y expediente ' . $denuncia->num_expediente_dgit);
        return redirect()->route('denuncias.detalle', ['id'=>$denuncia->id])->with('success', "Se realizó alta de la denuncia de manera correcta.");
    }
    /**
     * Description: Permite generar una Providencia.
     *
     * @param  mixed $request
     *
     */
    public function storeProvidencia(Request $request)
    {
        $denuncia = Denuncia::find($request->denuncia_id);
        $dependencia_id = CatalogoElemento::where('codigo', 'setrass')->first()->id;
        $status_id      = CatalogoElemento::where('codigo', 'providencia')->first()->id;
        $motivo  = CatalogoElemento::where("id", "=", $request->motivo_id)->first();
        $usuario_activo = User::findOrFail(Auth::id());

        $archivo = $request->file('documento_archivo_providencia_denuncia');
        if ($archivo) {
            ArchivosController::storeSimple($request, 'providencia_denuncia', $denuncia->getMorphClass(), $denuncia->id, $dependencia_id, $denuncia->folio);
        }
        $rules = [
            'motivo_id' => 'required',
            'observacion' => 'required',
            'observacion_longitud' => 'lt:1701'
        ];
        $messages = [
            'motivo_id.required' => 'El campo motivo es obligatorio.',
            'observacion.required' => 'El campo observacion es obligatorio.',
            'observacion_longitud.lt' => 'El número de caracteres de las observaciones debe ser menor o igual a 1700.'
        ];
        Validator::make($request->all(), $rules, $messages);

        //Cambio de estatus
        $denuncia->estatus_id = $status_id;
        $denuncia->usuario_asignado_id = Auth::id();
        $denuncia->save();

        //Cargamos GestionCaso
        GestionDenuncia::create([
            "denuncia_id" => $request->denuncia_id,
            "estatus_id"  => $status_id,
            "motivo_id"   => $request->motivo_id,
            "observacion" => $request->observacion,
            "usuario_asignado_id" => $request->expediente_usuario_id,
            "creador_id" => $request->expediente_usuario_id,
        ]);

        //Proceso: Se valida registro del Denunciante y se le envia correo
        $this->envioCorreoUsuarioProvidencia ($denuncia, $usuario_activo, $motivo, $request);
        registroBitacora($denuncia, A_ACTUALIZAR, C_DENUNCIAS, null, 'El auditor considera la denuncia con estatus providencia contiene el siguiente folio:' . $denuncia->folio. ' y expediente' . $denuncia->num_expediente_dgit);
        return redirect()->route('denuncias.index')->with('success', "Se realizó la providencia de la denuncia de manera correcta.");
    }
    /**
     * Description: Metodo para actualizar la denuncia
     *
     * @param  mixed $request
     * @return void
     */
    public function storeInformacionAdicional(Request $request)
    {
        $catalogo_motivos = Catalogo::where('codigo', 'estatus_denuncia_ati')->first();
        $estatus_solventado_id       = CatalogoElemento::where('catalogo_id', $catalogo_motivos->id)->where('codigo', 'solventado')->first()->id;
        $providencia_id  = CatalogoElemento::where('catalogo_id', $catalogo_motivos->id)->where('codigo', 'providencia')->first()->id;
        $denunciante     = "Denunciante";

        $rules = [
            'descripcion_denuncia_adicional_longitud' => 'lt:1701'
        ];
        $messages = [
            'descripcion_denuncia_adicional_longitud.lt' => 'El número de caracteres de la descripción debe ser menor o igual a 1700.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        $denuncia = Denuncia::where('id', $request->denuncia_id)->first();
        $denuncia->descripcion_denuncia_adicional = $request->descripcion_denuncia_adicional;
        $denuncia->estatus_id = $estatus_solventado_id;
        $denuncia->save();

        GestionDenuncia::create([
            "denuncia_id" => $request->denuncia_id,
            "estatus_id"  => $estatus_solventado_id,
            "observacion" => $request->descripcion_denuncia_adicional,
            "usuario_asignado_id" => $denuncia->asignado_a->id,
            "creador_id"  => auth()->id(),
        ]);

        $gestion_denuncia_providencia = GestionDenuncia::where('denuncia_id', $denuncia->id)->where('estatus_id', $providencia_id)->first();

        if ($request->respuesta_fisica) {
            $denuncia->visita = 1;
            $denuncia->save();
            //Almaceno info de la fecha a la respuesta a la providencia
            $gestion_denuncia_providencia->fecha_recepcion = $request->fecha_recepcion_providencia . ' ' . date("H:m:s");
            $gestion_denuncia_providencia->save();
            $denunciante = "Auditor";
        }
        //Carga Archivo Pruebas
            $pruebas_denuncia_id = CatalogoElemento::where('codigo', 'pruebas_denuncia_resp_providencia')->first()->id;
            ArchivosController::storeMultiple($request, 'pruebas_denuncia_resp_providencia', 'denuncias', $denuncia->id, $pruebas_denuncia_id, $denuncia->folio, $denuncia->folio);
        try {
            $extras['url'] = '<a href="' . route('denuncias.index') . '">aquí</a>';
            $extras['fecha_emitida'] = $gestion_denuncia_providencia->created_at->isoFormat('D [de] MMMM [de] YYYY');
            Mail::to($denuncia->asignado_a->email)->send(new Notificacion($denuncia->asignado_a, 'respuestaProvidencia', 'Respuesta a providencia de la denuncia con expediente ' . $denuncia->num_expediente_dgit . '.', $extras));
        } catch(\Exception $e){
            Log::info("Error: Se genero un error al enviar el correo, durante el proceso de Actualizar la denuncia".$e->getMessage());
        }
        registroBitacora($denuncia, A_ACTUALIZAR, C_DENUNCIAS, null, 'El usuario ' . $denunciante . ' actualiza la denuncia contiene el siguiente folio:' . $denuncia->folio. ' y expediente' . $denuncia->num_expediente_dgit);
        return redirect()->route('denuncias.index')->with('success', "Se actualizó la denuncia de manera correcta.");
    }
    /**
     * Description: Metodo para actualizar la denuncia
     *
     * @param  mixed $request
     * @return void
     */
    public function storeSolicitarExpediente(Request $request)
    {
        $rules = [
            'usuario' => 'required',
            'num_expediente_dgit' => 'required',
            'observacion_longitud' => 'lt:1701',
            'observacion' => 'required',
        ];
        $messages = [
            'usuario.required' => 'El campo jefe regional de inspección es obligatorio.',
            'motivo.num_expediente_dgit' => 'El campo número de expediente es obligatorio.',
            'observacion_longitud.lt' => 'El número de caracteres de las observaciones debe ser menor o igual a 1700.',
            'observacion.required' => 'El campo observacion es obligatorio.',
        ];

        Validator::make($request->all(), $rules, $messages);

        $solicitud_expediente = CatalogoElemento::where('codigo', 'solicitud_expediente')->first()->id;
        $dependencia_id = CatalogoElemento::where('codigo', 'setrass')->first()->id;

        $denuncia = Denuncia::where('id', $request->denuncia_id)->first();
        $denuncia->estatus_id = $solicitud_expediente;
        $denuncia->usuario_asignado_id = $request->usuario;
        $denuncia->num_expediente_dgit = $request->num_expediente_dgit;
        $denuncia->save();

        //Cargamos GestionCaso
        GestionDenuncia::create([
            "denuncia_id" => $request->denuncia_id,
            "estatus_id"  => $solicitud_expediente,
            "motivo_id"   => null,
            "observacion" => $request->observacion,
            "usuario_asignado_id" => $request->usuario,
            "creador_id" => auth()->id(),
        ]);
        try {
            ArchivosController::storeSimple($request, 'oficio_solicitar_expediente', $denuncia->getMorphClass(), $denuncia->id, $dependencia_id, $request->num_expediente);
            Mail::to($denuncia->asignado_a->email)->send(new Notificacion($denuncia->asignado_a, 'seguimientoSolicitudExpediente', 'Solicitud de expediente '.$denuncia->num_expediente_dgit . $denuncia->num_expediente_dgit . '.', $denuncia->num_expediente_dgit));
        } catch(\Exception $e){
            Log::info("Error: Se generó un error al enviar el correo, durante el proceso de solicitar expediente".$e->getMessage());
        }
        registroBitacora($denuncia, A_ACTUALIZAR, C_DENUNCIAS, null, 'El usuario auditor solicita expediente para la denuncia con el siguiente folio:' . $denuncia->folio. ' y expediente' . $denuncia->num_expediente_dgit);
        return redirect()->route('denuncias.index')->with('success', "Se solicitó expediente para la denuncia de manera correcta.");
    }
    /**
     * Description: Metodo que permite generar la estructura en formato del número del expediente
     *
     * @param  mixed $tipo
     * @param  mixed $numero
     * @return string NumeroExpedienteFormato
     */
    public function generaNumExpedienteFormato(string $tipo, string $opera, int $departamento_id, int $municipio_id): string
    {
        $numero = $this->foliador->generaConsecutivo(date('Y'), 'ATI', $opera);
        $codigo_municipio    =  CatalogoElemento::where('id', '=', $municipio_id)->first();
        $codigo_departamento =  CatalogoElemento::where('id', '=', $departamento_id)->first();
        $numero_consec = str_pad($numero, "4", "0", STR_PAD_LEFT);
        $numero_departamento = str_pad($codigo_departamento->id, "3", "0", STR_PAD_LEFT);
        $anio_curso = date('Y');
        return "$numero_departamento-$codigo_municipio->codigo-$numero_consec-$anio_curso";
    }
    /**
     * Description: Metodo para  visualizar el formulario para desestimar la denuncia
     *
     * @param  mixed $id
     * @return void
     */
    public function desestimar(Denuncia $id){
        $denuncia=$id;
        $itemsbread = [
            ['nombreComponente' => 'Denuncias',           'value' => '',       'ruta'=>route('denuncias.index')],
            ['nombreComponente' => $denuncia->folio,      'value' => '',       'ruta'=>url()->previous()],
            ['nombreComponente' => 'Desestimar denuncia', 'value' => 'active', 'ruta'=> '#']
        ];

        return view('denuncias.desestimar',compact('denuncia','itemsbread'));
    }
    /**
     * Description: Metodo para actualizar la denuncia con el estatus de desestimación
     *
     * @param  mixed $request
     * @return void
     */
    public function desestimacion(Request $request){
        $rules = [
            'motivo_id'            => 'required',
            'observacion'          => 'required',
            'observacion_longitud' => 'lt:1701'
        ];
        $messages = [
            'motivo_id.required'      => 'El campo de motivo de desestimación es obligatorio.',
            'observacion.required'    => 'El campo observacion es obligatorio.',
            'observacion_longitud.lt' => 'El número de caracteres de las observaciones debe ser menor o igual a 1700.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        $denuncia       = Denuncia::findOrFail($request->denuncia_id);
        $dependencia_id = CatalogoElemento::where('codigo', 'setrass')->first()->id;
        $status_id      = CatalogoElemento::where('codigo', 'desestimado')->first()->id;
        $nom_persona    = $denuncia->sindicato_denunciante == 'N/A' ? $denuncia->nombre_denunciante . ' ' . $denuncia->primer_apellido_denunciante . ' ' . $denuncia->segundo_apellido_denunciante : $denuncia->sindicato_denunciante;
        GestionDenuncia::create([
            "denuncia_id" => $request->denuncia_id,
            "estatus_id"  => $status_id,
            "motivo_id"   => $request->motivo_id,
            "observacion" => @$request->observacion,
            "creador_id" => Auth::id(),
            "usuario_asignado_id" => Auth::id(),
        ]);
        //Cambio de estatus
        $denuncia = Denuncia::find($request->denuncia_id);
        $denuncia->estatus_id = $status_id;
        $denuncia->save();

        $archivo = $request->file('documento_archivo_desistimiento_denuncia');
        if ($archivo) {
            ArchivosController::storeSimple($request, 'desistimiento_denuncia', $denuncia->getMorphClass(), $denuncia->id, $dependencia_id, $denuncia->folio);
        }

        $contenido = "Le informamos que la denuncia con folio <b>$denuncia->folio</b> ha sido desestimada.";
        $link = '<a href="' . route('denuncias.index') . '">aquí</a>';
        $contenido .= "<br>Para conocer mayor detalle ingrese al sistema dando clic $link usando su mismo usuario y contraseña.";
        $contenido .= "<br><br>Auditoría Técnica de la Inspección";

        try{
            Mail::to($denuncia->correo_denunciante)->send(new NotificacionPublica("Denuncia con folio $denuncia->folio desestimada", $contenido, $nom_persona));
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
        }

        registroBitacora($denuncia, A_ACTUALIZAR, C_DENUNCIAS, null, 'Denuncia desestimada contiene el siguiente folio:' . $denuncia->folio. ' y expediente' . $denuncia->num_expediente_dgit);

        return redirect()->route('denuncias.index')->with('success', 'Se realizó la desestimación para la denuncia de manera correcta.');
    }
    /**
     * Description: Metodo para visualizar el formulario para inamizar la denuncia
     *
     * @param  mixed $denuncia_id
     * @return void
     */
    public function showInadmision($denuncia_id){
        $denuncia = Denuncia::where('id',$denuncia_id )->first();
        $itemsbread = [
            ['nombreComponente' => 'Denuncias',           'value' => '',       'ruta'=>route('denuncias.index')],
            ['nombreComponente' => $denuncia->folio,      'value' => '',       'ruta'=>url()->previous()],
            ['nombreComponente' => 'Inadmisión denuncia', 'value' => 'active', 'ruta'=> '#']
        ];
        $usuario = User::where('id',Auth::user()->id)->first();
        $text_boton = '';
        if($usuario->roles()->first()->name == 'jefe_auditoria_setrass_ati'){
            $text_boton = 'Guardar';

        }else{
            $text_boton = 'Enviar a revisión';
        }
        $catalogo_motivos = Catalogo::where('codigo', 'inadmision_denuncia_ati')->first();
        $motivos_inadmision = CatalogoElemento::where('catalogo_id', $catalogo_motivos->id)->orderBy('nombre')->get();
        return view('denuncias.inadmision.crear_inadmision', compact('denuncia','motivos_inadmision','text_boton','itemsbread'));
    }
    /**
     * Description: Metodo para actualiza la denuncia con el estatus de no Procede Inadmision
     *
     * @param  mixed $denuncia_id
     * @return void
     */
    public function noProcedeInadmision($denuncia_id){
        $cat_estatus = Catalogo::where('codigo', 'estatus_denuncia_ati')->first()->id;
        $estatus = CatalogoElemento::where('codigo', 'pendiente')->where('catalogo_id',$cat_estatus)->first();
        $datos = [
            "denuncia_id" => $denuncia_id,
            "estatus_id"  => $estatus->id,
            "creador_id" => Auth::id(),
            "usuario_asignado_id" => Auth::id(),
        ];

        $codigo_oficio_inadmision_doc = CatalogoElemento::where('codigo', 'oficio_inadmision_denuncia')->first()->id;
        $doc_oficio_inadmsion_denuncia = Documento::where('entidad_id', $denuncia_id)->where('tipo_documento_id', $codigo_oficio_inadmision_doc)->first();
        $doc_oficio_inadmsion_denuncia->delete();
        Storage::delete($doc_oficio_inadmsion_denuncia->ruta);

        GestionDenuncia::create($datos);
        $denuncia = Denuncia::find($denuncia_id);
        $denuncia->estatus_id = $estatus->id;
        $denuncia->save();
        registroBitacora($denuncia, A_ACTUALIZAR, C_DENUNCIAS, null, 'Se actualizó el estatus de la denunacia con folio :' . $denuncia->folio. 'a estatus ' . $estatus->nombre);
        return redirect()->route('denuncias.index')->with('success', 'La denuncia se actualizó correctamente.');
    }
    /**
     * Description: Metodo para actualizar la denuncia con el estatus de inadmisión
     *
     * @param  mixed $request
     * @return void
     */
    public function storeInadmision(Request $request){
        $rules = [
            'motivo' => 'required',
            'informacion_adicional_longitud' => 'lt:1701'
        ];
        $messages = [
            'motivo.required' => 'Motivo de inadmision obligatorio.',
            'informacion_adicional_longitud.lt' => 'El número de caracteres de la información adicional debe ser menor o igual a 1700.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        //Actualizamos estatus
        $usuario = User::where('id',Auth::user()->id)->first();
        $denuncia = Denuncia::find($request->denuncia_id);

        $files = ArchivosController::storeSimple($request, 'oficio_inadmision_denuncia',$denuncia->getMorphClass(), $denuncia->id,auth()->user()->dependencia_id);

        $usuario_asignado = User::whereHas('roles', function ($query) {$query->where('name', 'jefe_auditoria_setrass_ati');})->first();
        if($usuario->roles()->first()->name == 'jefe_auditoria_setrass_ati'){
                $nuevo_estatus= CatalogoElemento::where('codigo', 'inadmision')->first();
                $usuario_activo = User::findOrFail(Auth::id());

                $nom_persona = $denuncia->sindicato_denunciante == 'N/A' ? $denuncia->nombre_denunciante . ' ' . $denuncia->primer_apellido_denunciante . ' ' . $denuncia->segundo_apellido_denunciante : $denuncia->sindicato_denunciante;
                $usuario_notificar = $this->servicio_usuarios->registrarUsuario('denunciante', $usuario_activo->dependencia_id, $usuario_activo->area_adscripcion_id, $denuncia->oficina_regional_id, $denuncia->correo_denunciante, $denuncia->telefono_denunciante, $nom_persona, '', '');

                $asunto = "Inadmisión de la denuncia con folio ".$denuncia->folio;
                $saludo = "Estimado C. <strong>$nom_persona</strong>,";
                $contenido = "<p>Le informamos que la denuncia presentada el pasado ".obtenerFormatoFecha($denuncia->created_at)."</strong> la cual se registró con el número de folio <strong>".$denuncia->folio."</strong> ha sido <strong>inadmitida</strong>.</p><p>Para conocer mayor detalle lo invitamos a ingresar a nuestro sistema ";
                if($usuario_notificar->new_password == true){
                    $contenido .= "con los siguientes datos haciendo clic <a href='".route('denuncias.index')."'>aquí</a><p> Usuario: ".$usuario_notificar->email."<p> Contraseña: ".$usuario_notificar->password."</p><p>Agradecemos su confianza,</p><p>Auditoría técnica de la inspección.</p>";
                }else{
                    $contenido .= "con sus datos haciendo clic <a href='".route('denuncias.index')."'>aquí</a><p>Agradecemos su confianza,</p><p>Auditoría técnica de la inspección.</p>";
                }

        }else{
            $nuevo_estatus = CatalogoElemento::where('codigo', 'revision_inadmision')->first();
            $usuario_notificar = $usuario_asignado;
            $asunto = "Revisión de inadmisión para la denuncia con folio ".$denuncia->folio;
            $saludo = "<strong>".Auth::user()->complete_name."</strong>";
            $contenido = "<p>Le informamos que <strong>".Auth::user()->complete_name."</strong> cargó en el sistema una <strong>inadmisión</strong> para su revisión y VoBo.</p><p> Dicha inadmisión corresponde a la denuncia recibida el día <strong>".obtenerFormatoFecha($denuncia->created_at)."</strong> con número de folio <strong>".$denuncia->folio."</strong></p><p>Le invitamos a ingresar al sistema dando clic <a href='".route('denuncias.index')."'>aquí</a> para realizar las acciones que estime pertinentes.</p><p>Saludos.</p>";
        }
        $servio_denuncias = new DenunciasService();
        $servio_denuncias->cambioEstatus($denuncia,$usuario_asignado->id,$nuevo_estatus->id,$request->informacion_adicional,$request->motivo);

        try{
            Mail::to($usuario_notificar->email)->send(new Notificacion($usuario_notificar, 'inadmision', $asunto, [
                    'asunto' => $asunto,
                    'saludo' => $saludo,
                    'contenido' => $contenido
            ]));
            $descripcionBitacora = "Se registra cambio de estatus a la denuncia de id ".$denuncia->id." con estatus ".$nuevo_estatus->nombre." al usuario $usuario_asignado->complete_name";

            }catch (\Exception $e){
                Log::info($e->getMessage());
                $descripcionBitacora = "Error al notificar registro de cambio de estatus de la denuncia con id ".$denuncia->id." con estatus ".$nuevo_estatus->nombre." al usuario $usuario_notificar->nombre_usuario";

            }
        registroBitacora($denuncia,A_NOTIFICAR,C_DENUNCIAS,null,$descripcionBitacora);

        return redirect()->route('denuncias.index')->with('success', 'La denuncia se actualizó correctamente.');

    }
    /**
     * Description: Metodo para  visualizar el formulario para una  Denuncia Limitada
     *
     * @param  mixed $denuncia_id
     * @return void
     */
    public function showDenunciaLimitada(int $denuncia_id){
        $denuncia = Denuncia::where('id',$denuncia_id)->first();
        if (!$denuncia) {
            return redirect()->route('denuncias.index');
        }
        $itemsbread = [
            ['nombreComponente' => 'Denuncias',        'ruta'=> route('denuncias.index'), 'value'=>'null'  ],
            ['nombreComponente' => $denuncia->num_expediente,   'ruta'=> '#'         , 'value'=>'active' ]
        ];
        $codigo_oficio_solicitar_expediente = CatalogoElemento::where('codigo', 'oficio_solicitar_expediente')->first()->id;
        $doc_oficio_solicitar_expediente = Documento::where('entidad_id', $denuncia_id)->where('tipo_documento_id', $codigo_oficio_solicitar_expediente)->first();
        $cat_estatus = Catalogo::where('codigo', 'estatus_denuncia_ati')->first()->id;
        $estatus = CatalogoElemento::where('codigo', 'solicitud_expediente')->where('catalogo_id',$cat_estatus)->first();
        $denuncia_solicitud_expediente = $denuncia->gestion_denuncia->where('estatus_id',$estatus->id)->first();
        $codigo_respuesta_solicitud_expediente = CatalogoElemento::where('codigo', 'respuesta_solicitud_expediente')->first()->id;
        $docs_respuesta_solicitud_expediente = Documento::where('entidad_id', $denuncia_id)->where('tipo_documento_id', $codigo_respuesta_solicitud_expediente)->get();
        return view('denuncias.detalleLimitado', compact('denuncia','itemsbread','doc_oficio_solicitar_expediente','docs_respuesta_solicitud_expediente','denuncia_solicitud_expediente'));
    }
    /**
     * Description: Metodo para actualizar la denuncia con el estatus de Respuesta Solicitud Expediente
     *
     * @param  mixed $request
     * @return void
     */
    public function storeRespuestaSolicitudExpediente(Request $request){
        $rules = [
            'documentos_archivos_respuesta_solicitud_expediente' => 'required'
        ];
        $messages = [
            'documentos_archivos_respuesta_solicitud_expediente.required' => 'Debe cargar al menos un documento.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();
        $denuncia = Denuncia::find($request->denuncia_id);
        $auditor_id = $denuncia->gestion->first()->creador_id;
        $auditor = User::find($auditor_id);

        if($auditor == null){
            $auditor = User::whereHas('roles', function ($query) {
                                    $query->where('name', 'jefe_auditoria_setrass_ati');
                                })->first()->id;
        }
        //Cambio de estatus
        $cat_estatus = Catalogo::where('codigo', 'estatus_denuncia_ati')->first()->id;
        $estatus = CatalogoElemento::where('codigo', 'expediente_recibido')->where('catalogo_id',$cat_estatus)->first();
        $denuncia = Denuncia::find($request->denuncia_id);
        $denuncia->estatus_id = $estatus->id;
        $denuncia->usuario_asignado_id= $auditor->id;
        $denuncia->save();
        ArchivosController::storeMultiple($request, 'respuesta_solicitud_expediente', 'denuncias', $denuncia->id, auth()->user()->dependencia_id);

        $datos = [
            "denuncia_id" => $denuncia->id,
            "estatus_id"  => $estatus->id,
            "creador_id" => Auth::id(),
            "usuario_asignado_id" => $auditor->id,
            "observacion" => $request->detalle_respuesta
        ];
        GestionDenuncia::create($datos);
        $asunto = "Expediente ".$denuncia->num_expediente_dgit." recibido con relación a la denuncia ".$denuncia->num_expediente;
            $saludo = "Estimado(a) ".$auditor->complete_name.",";
            $contenido = "<p>Le informamos que <strong>  el expediente con número ".$denuncia->num_expediente_dgit." ha sido cargado al sistema</strong>.  Por favor ingrese para dar seguimiento a la <strong>denuncia con expediente ".$denuncia->num_expediente."</strong>.<p>Saludos.</p>";

        try{
            Mail::to($auditor->email)->send(new Notificacion($auditor, 'inadmision', $asunto, [
                    'asunto' => $asunto,
                    'saludo' => $saludo,
                    'contenido' => $contenido
            ]));
            $descripcionBitacora = "Se registra la carga del expediente de la DGIT y cambio de estatus a la denuncia de id ".$denuncia->id." con estatus ".$estatus->nombre." al usuario $auditor->complete_name";

            }catch (\Exception $e){
                Log::info($e->getMessage());
                $descripcionBitacora = "Error al notificar la carga del expediente de la DGIT y de cambio de estatus de la denuncia con id ".$denuncia->id." con estatus ".$estatus->nombre." al usuario $auditor->nombre_usuario";

            }
        registroBitacora(null,A_NOTIFICAR,C_DENUNCIAS,null,$descripcionBitacora);
        return redirect()->route('denuncias.index')->with('success', 'La denuncia se actualizó correctamente.');
    }
    /**
     * Description: Metodo para  visualizar el formulario para la Admision de la denuncia
     *
     * @param  mixed $id
     * @return void
     */
    public function showAdmision(Denuncia $id){
        $denuncia=$id;
        $itemsbread = [
            ['nombreComponente' => 'Denuncias',           'value' => '',       'ruta'=>route('denuncias.index')],
            ['nombreComponente' => $denuncia->folio,      'value' => '',       'ruta'=>url()->previous()],
            ['nombreComponente' => 'Admitir denuncia', 'value' => 'active', 'ruta'=> '#']
        ];

        return view('denuncias.admision',compact('denuncia','itemsbread'));
    }
    /**
     * Description: Metodo para actualizar la denuncia con el estatus de Admision
     *
     * @param  mixed $request
     * @return void
     */
    public function storeAdmision(Request $request){
        $rules = [
            'tipo_inspeccion_id' => 'required',
            'caracter_id' => 'required',
            'observaciones' => 'required',
            'observaciones_longitud' => 'lt:1701'
        ];
        $messages = [
            'tipo_inspeccion_id.required' => 'El campo de tipo de inspección es obligatorio.',
            'caracter_id.required' => 'El campo de carácter de la denuncia es obligatorio.',
            'observaciones.required' => 'El campo de observaciones es obligatorio.',
            'observaciones_longitud.lt' => 'El número de caracteres de las observaciones debe ser menor o igual a 1700.'
        ];

        Validator::make($request->all(), $rules, $messages);

        $usuario_activo = User::findOrFail(Auth::id());
        $denuncia = Denuncia::findOrFail($request->denuncia_id);
        $dependencia_id = CatalogoElemento::where('codigo', 'setrass')->first()->id;
        $status_id      = CatalogoElemento::where('codigo', 'admitida')->first()->id;

        $archivo = $request->file('documento_archivo_auto_admision_denuncia');
        if ($archivo) {
            ArchivosController::storeSimple($request, 'auto_admision_denuncia', $denuncia->getMorphClass(), $denuncia->id, $dependencia_id, $denuncia->folio);
        }

        $nom_persona = $denuncia->sindicato_denunciante == 'N/A' ? $denuncia->nombre_denunciante . ' ' . $denuncia->primer_apellido_denunciante . ' ' . $denuncia->segundo_apellido_denunciante : $denuncia->sindicato_denunciante;
        $usuario_notificar = $this->servicio_usuarios->registrarUsuario('denunciante', $usuario_activo->dependencia_id, $usuario_activo->area_adscripcion_id, $denuncia->oficina_regional_id, $denuncia->correo_denunciante, $denuncia->telefono_denunciante, $nom_persona, '', '');

        GestionDenuncia::create([
            "denuncia_id" => $request->denuncia_id,
            "estatus_id"  => $status_id,
            "observacion" => @$request->observaciones,
            "creador_id" => Auth::id(),
            "usuario_asignado_id" => Auth::id(),
        ]);

        $denuncia = Denuncia::find($request->denuncia_id);
        $denuncia->estatus_id = $status_id;
        $denuncia->tipo_inspeccion_id = $request->tipo_inspeccion_id;
        $denuncia->caracter_id = $request->caracter_id;
        $denuncia->save();

        $contenido = "Le informamos que la denuncia con folio <b>$denuncia->folio</b> ha sido admitida a trámite.";
        $link = '<a href="' . route('denuncias.index') . '">aquí</a>';

        $contenido .= "<br>Para conocer mayor detalle ingrese a nuestro sistema dando clic $link ";
        if($usuario_notificar->new_password == true){
            $contenido .= "con los siguientes datos <p> Usuario: ".$usuario_notificar->email."<p> Contraseña: ".$usuario_notificar->password."</p><p>Agradecemos su confianza,</p><p>Auditoría técnica de la inspección.</p>";
        }else{
            $contenido .= "usando su mismo usuario y contraseña <p>Agradecemos su confianza,</p><p>Auditoría técnica de la inspección.</p>";
        }

        try{
            Mail::to($denuncia->correo_denunciante)->send(new NotificacionPublica("Denuncia con folio $denuncia->folio admitida a trámite", $contenido, $nom_persona));
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
        }

        registroBitacora($denuncia, A_ADMITIR, C_DENUNCIAS, null, 'Denuncia con folio ' . $denuncia->folio. ' y expediente' . $denuncia->num_expediente_dgit.' ha sido admitida');

        return redirect()->route('denuncias.index')->with('success', 'Se admitió la denuncia de manera correcta.');
    }

    /**
     * envioCorreoUsuarioProvidencia
     *
     * @param  mixed $denuncia
     * @param  mixed $usuario_activo
     * @param  mixed $motivo
     * @param  mixed $request
     * @return void
     */
    public  function envioCorreoUsuarioProvidencia ($denuncia, $usuario_activo, $motivo, $request) {
        //Valido Primero Si existe el  usuario  pero valido si esta borrado o no en la base de datos
        $usuario = User::withTrashed()->where('email', '=', $denuncia->correo_denunciante)->first();
        $password = $password ?? Str::random(8);
        $nom_persona = $denuncia->sindicato_denunciante == 'N/A' ? $denuncia->nombre_denunciante . ' ' . $denuncia->primer_apellido_denunciante . ' ' . $denuncia->segundo_apellido_denunciante : $denuncia->sindicato_denunciante;

        if ($usuario){
            $usuario->update([
                'deleted_at'=> null
            ]);
            // Envio correo
            $contenido = "Se le informa que para poder dar atención a la denuncia registrada por usted en la plataforma de Auditoría Técnica de la Inspección el pasado " . obtenerFormatoFecha($denuncia->created_at) . " se ha emitido la siguiente providencia:";
            $contenido .= "<br><br><b>Motivo:</b> $motivo->nombre";
            $contenido .= "<br><br><b>Información adicional:</b> <p>$request->observacion</p>";
            $link = '<a href="' . route('denuncias.index') . '">aquí</a>';
            $contenido .= "<br>Para poder dar seguimiento ingrese al sistema dando clic $link con los siguientes datos:";
            $contenido .= "<br><br>Nombre de usuario: <strong>{$usuario->email}</strong>";
            $contenido .= "<br><b>Su contraseña no ha cambiado</b></strong>";
            $contenido .= "<br><br>Finalmente, le recordamos que es de suma importancia responder en un plazo no mayor a 10 días hábiles ya que en caso de que dicho plazo venza, su solicitud será desestimada. ";
            $contenido .= "<br><br>Auditoría Técnica de la Inspección";
        }else{
            $nom_persona = ( $nom_persona ==='N/A')? $denuncia->sindicato_denunciante : $nom_persona;
            $usuario_registrado = $this->servicio_usuarios->registrarUsuario('denunciante', $usuario_activo->dependencia_id, $usuario_activo->area_adscripcion_id, $denuncia->oficina_regional_id, $denuncia->correo_denunciante, $denuncia->telefono_denunciante, $nom_persona, '', '');
            // Envio correo
            $contenido = "Se le informa que para poder dar atención a la denuncia registrada por usted en la plataforma de Auditoría Técnica de la Inspección el pasado " . obtenerFormatoFecha($denuncia->created_at) . " se ha emitido la siguiente providencia:";
            $contenido .= "<br><br><b>Motivo:</b> $motivo->nombre";
            $contenido .= "<br><br><b>Información adicional:</b> <p>$request->observacion</p>";
            $link = '<a href="' . route('denuncias.index') . '">aquí</a>';
            $contenido .= "<br>Para poder dar seguimiento ingrese al sistema dando clic $link con los siguientes datos:";
            $contenido .= "<br><br>Nombre de usuario: <strong>{$usuario_registrado->email}</strong>";
            if($usuario_registrado->new_password==true)
                $contenido .= "<br>Contraseña: <strong>{$usuario_registrado->password}</strong>";
            else
                $contenido .= "<br>Su contraseña no ha cambiado</strong>";
            $contenido .= "<br><br>Finalmente, le recordamos que es de suma importancia responder en un plazo no mayor a 10 días hábiles ya que en caso de que dicho plazo venza, su solicitud será desestimada. ";
            $contenido .= "<br><br>Auditoría Técnica de la Inspección";
        }

        try {
            Mail::to($denuncia->correo_denunciante)->send(new NotificacionPublica("Providencia relacionada a su denuncia con folio $denuncia->folio ", $contenido, $nom_persona));
        } catch(\Exception $e){
            Log::info("Error: Se genero un error al enviar el correo, durante el proceso de Providencia de la denuncia".$e->getMessage());
        }
    }

    public function createInforme(Request $request)
    {
        $catalogoEstatus = Catalogo::whereCodigo('estatus_denuncia_ati')->first();
        $actualizacion = $request->input('actualizacion');
        $estatus = $catalogoEstatus->elementos?->where('codigo', $actualizacion ? 'informe_actualizado' : 'informe_cargado')->first();

        $denuncia = Denuncia::find($request->input('denuncia'));

        $dataSave = [];
        $dataSave['denuncia_id'] = $denuncia->id;
        $dataSave['observaciones'] = $request->input('observaciones');
        $dataSave['visita_campo'] = $request->has('visita_campo');
        $dataSave['comentarios'] = null;

        if ($actualizacion) {
            $informe = $denuncia->informe;
            $informe->update($dataSave);
        } else {
            $informe = DenunciaInforme::create($dataSave);
        }

        $dependencia_id = Auth::user()->dependencia_id;
        ArchivosController::storeSimple($request, 'informe_denuncia', $informe->getMorphClass(), $informe->id, $dependencia_id);

        $usuario_jefe = User::role('jefe_auditoria_setrass_ati')->first();

        $denuncia->estatus_id = $estatus->id;
        $denuncia->save();

        GestionDenuncia::create([
            "denuncia_id" => $denuncia->id,
            "estatus_id"  => $estatus->id,
            "observacion" => $request->input('observaciones'),
            "creador_id" => Auth::id(),
            "usuario_asignado_id" => Auth::id(),
        ]);

        $gestion_admision = $denuncia->gestion()->whereHas('estatus',function($q){$q->whereCodigo('admitida');})->first();

        $datosNotificacion = [
            'denuncia_id'       => $denuncia->id,
            'auditor'           => Auth::user()->complete_name,
            'expediente_ati'    => $denuncia->num_expediente,
            'fecha_vencimiento' => Carbon::create($this->control_dias_inhabiles->calculoPlazo($gestion_admision->created_at, intval(config('app.plazo_vencimiento_denuncia')))),
        ];

        if ($usuario_jefe) {
            Mail::to($usuario_jefe->email)->send(new Notificacion($usuario_jefe, 'cargaInformeDenuncia', "Se ha cargado el informe de la denuncia con expediente $denuncia->num_expediente para revision", $datosNotificacion));
        }

        $descripcionBitacora = 'Se carga informe de la denuncia con folio ' . $denuncia->folio . ' con estatus ' . $estatus->nombre;
        registroBitacora($denuncia, A_ASIGNAR, C_GESTION_INFORMES_DENUNCIAS, null, $descripcionBitacora);

        return redirect("denuncias/{$denuncia->id}/detalle");
    }

    public function commentInforme(Request $request)
    {
        $catalogoEstatus = Catalogo::whereCodigo('estatus_denuncia_ati')->first();
        $estatus = $catalogoEstatus->elementos?->where('codigo', 'observaciones_informe')->first();

        $informe = DenunciaInforme::find($request->input('informe'));
        $denuncia = $informe->denuncia;

        $dataSave = [];
        $dataSave['comentarios'] = $request->input('comentarios');
        $informe->update($dataSave);

        $dependencia_id = Auth::user()->dependencia_id;
        ArchivosController::storeMultiple($request, 'informe_denuncia_comentarios', 'informescomentarios', $informe->id, $dependencia_id);

        $usuario_jefe = $denuncia->asignado_a;

        $denuncia->estatus_id = $estatus->id;
        $denuncia->save();

        $plazo = config('plazo_vencimiento_denuncia',15);
        $fechaVencimiento = Carbon::create((new DiasInhabilesController)->calculoPlazo($denuncia->created_at->format('Y-m-d'),$plazo));

        $datosNotificacion = [
            'denuncia_id' => $denuncia->id,
            'auditor' => Auth::user()->complete_name,
            'expediente_ati' => $denuncia->num_expediente,
            'fecha_vencimiento' => $fechaVencimiento->isoFormat('D [de] MMMM [de] YYYY'),
        ];

        if ($usuario_jefe) {
            Mail::to($usuario_jefe->email)->send(new Notificacion($usuario_jefe, 'cargaInformeDenunciaComentarios', "Se ha revisado el informe de la denuncia con expediente $denuncia->num_expediente", $datosNotificacion));
        }

        $descripcionBitacora = 'Se agregan comentarios al informe de la denuncia con folio ' . $denuncia->folio . ' con estatus ' . $estatus->nombre;
        registroBitacora($denuncia, A_ASIGNAR, C_GESTION_INFORMES_DENUNCIAS, null, $descripcionBitacora);

        return redirect("denuncias/{$denuncia->id}/detalle");
    }

   /**
     * Description: Metodo permite cargar la interfaz para finalizar la denuncia
     *
     * @param  mixed $id
     * @return void
     */
    public function showFinaliza(Denuncia $id){
        $denuncia=$id;
        $itemsbread = [
            ['nombreComponente' => 'Denuncias',           'value' => '',       'ruta'=>route('denuncias.index')],
            ['nombreComponente' => $denuncia->folio,      'value' => '',       'ruta'=>url()->previous()],
            ['nombreComponente' => 'Finalizar denuncia',   'value' => 'active', 'ruta'=> '#']
        ];

        return view('denuncias.formFinaliza',compact('denuncia','itemsbread'));
    }

    /**
     * Description: Metodo permite finalizar la denuncia
     *
     * @param  mixed $request
     * @return void
     */
    public function storeFinaliza(Request $request){
        //Validador
        $rules = [
            'fecha_entrega' => 'required',
        ];
        $messages = [
            'fecha_entrega.required' => 'El campo de fecha entrega es obligatorio.',
        ];

        Validator::make($request->all(), $rules, $messages);

        $denuncia       = Denuncia::findOrFail($request->denuncia_id);
        $status_id      = CatalogoElemento::where('codigo', 'finalizado')->first()->id;
        $dependencia_id = CatalogoElemento::where('codigo', 'setrass')->first()->id;

        $archivo = $request->file('documento_archivo_informe_final');
        if ($archivo) {
            ArchivosController::storeSimple($request, 'informe_final', $denuncia->getMorphClass(), $denuncia->id, $dependencia_id, $denuncia->folio);
        }
        $archivo = $request->file('documento_archivo_acuse_recibo_informe_final');
        if ($archivo) {
            ArchivosController::storeSimple($request, 'acuse_recibo_informe_final', $denuncia->getMorphClass(), $denuncia->id, $dependencia_id, $denuncia->folio);
        }

        $datos_finaliza = [
            "denuncia_id" => $request->denuncia_id,
            "estatus_id"  => $status_id,
            "creador_id"  => Auth::id(),
            "usuario_asignado_id" => Auth::id(),
            "fecha_recepcion" => $request->fecha_entrega,
        ];
        GestionDenuncia::create($datos_finaliza);

        $denuncia = Denuncia::find($request->denuncia_id);
        $denuncia->estatus_id = $status_id;
        $denuncia->save();

        //Envio Correo
        $nom_persona = $denuncia->sindicato_denunciante == 'N/A' ? $denuncia->nombre_denunciante . ' ' . $denuncia->primer_apellido_denunciante . ' ' . $denuncia->segundo_apellido_denunciante : $denuncia->sindicato_denunciante;

        $contenido = "Le informamos que la Auditoría Técnica de la Inspección <strong>ha concluido la atención a la denuncia</strong>";
        $contenido .= " presentada por usted y la cual fue registrada con folio <strong> $denuncia->folio </strong>.";
        $link = '<a href="' . route('denuncias.index') . '">aquí</a>';
        $contenido .= "<br><br>Le invitamos a ingresar al sistema haciendo clic $link .";
        $contenido .= "<br><br>Auditoría Técnica de la Inspección.";

        try{
            Mail::to($denuncia->correo_denunciante)->send(new NotificacionPublica("Denuncia con folio $denuncia->folio", $contenido, $nom_persona));
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
        }

        registroBitacora($denuncia, A_FINALIZAR, C_DENUNCIAS, null, 'Denuncia con folio ' . $denuncia->folio. ' y expediente' . $denuncia->num_expediente_dgit.' ha sido finalizada');

        return redirect()->route('denuncias.index')->with('success', 'Se finalizó la denuncia de manera correcta.');
    }
   /**
     * Description: Metodo permite cargar la interfaz para reasignar auditor
     *
     * @param  mixed $id
     * @return void
     */
    public function showReasignarAuditor(Denuncia $id){
        $denuncia=$id;
        $usu_auditor_list  = User::select('id', 'name', 'first_name','last_name', 'perfil_id', 'regional_id')->where('activo', 1)->role('auditor_setrass_ati')->orderBy('complete_name', 'ASC')->get();
        $itemsbread = [
            ['nombreComponente' => 'Denuncias',           'value' => '',       'ruta'=>route('denuncias.index')],
            ['nombreComponente' => $denuncia->folio,      'value' => '',       'ruta'=>url()->previous()],
            ['nombreComponente' => 'Reasignar auditor',   'value' => 'active', 'ruta'=> '#']
        ];

        return view('denuncias.formReasignarAuditor',compact('denuncia','itemsbread', 'usu_auditor_list'));
    }
    /**
     * Description: Metodo permite actualizar y reasignar auditor
     *
     * @param  mixed $request
     * @return void
     */
    public function storeReasignarAuditor(Request $request){
        //Validador
        $rules = [
            'usuario' => 'required',
        ];
        $messages = [
            'usuario.required' => 'El campo usuario es obligatorio.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        //Variables
        $denuncia           = Denuncia::findOrFail($request->denuncia_id);
        $auditor_reasignado = User::findOrFail($request->usuario);
        $usuario_activo     = User::findOrFail(Auth::id());

        $denuncia = Denuncia::find($request->denuncia_id);
        $denuncia->usuario_asignado_id = $request->usuario;
        $denuncia->save();

        $extras = [
            'folio'            => $denuncia->folio,
            'usu_realizo_asig' => $usuario_activo->complete_name,
            'expediente_ati'   => $denuncia->num_expediente,
            'url'              => route('denuncias.index')
        ];

        try{
            Mail::to($auditor_reasignado->email)->send(new Notificacion($auditor_reasignado, 'denunciaReasignacion', 'Nuevas asignaciones el sistema de la ATI', $extras));
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
        registroBitacora($denuncia, A_REASIGNACION, C_DENUNCIAS, null, 'Denuncia con folio ' . $denuncia->folio. ' y expediente' . $denuncia->num_expediente_dgit.' ha sido reasignada al usuario auditor '.$auditor_reasignado->complete_name);
        return redirect()->route('denuncias.index')->with('success', 'Se reasignó la denuncia de manera correcta.');
    }
}
