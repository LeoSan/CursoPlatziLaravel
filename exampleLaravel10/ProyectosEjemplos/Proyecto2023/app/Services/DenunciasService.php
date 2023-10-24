<?php

namespace App\Services;
use App\Http\Controllers\{ArchivosController};
use App\Mail\{NotificacionPersonalizada, NotificacionPublica};
use App\Models\{Catalogo, CatalogoElemento, Denuncia, GestionDenuncia, Role, User, UsuarioJurisdiccion};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Log, Mail, Response};
use Illuminate\Support\Facades\Auth;

class DenunciasService
{
    /**
     * Description: permite guardar la denuncia en conjuntos con los procesos vinculados con el procedo de registro de una denuncia.
     *
     * @param  mixed $request
     * @return void
     */
    public function guardarDenuncia(Request $request)
    {
        //Genero FoliosService
        $logica_creacion = date("Ymdhsi");
        $folio =  "ATI-$logica_creacion";
        //Recibo del Formulario
        $formdata = json_decode($request->formulario);
        $formdata = (array) $formdata;
        $dependencia_id      = CatalogoElemento::where('codigo', 'setrass')->first()->id;
        $linea_recepcion     = CatalogoElemento::where('codigo', 'linea_recepcion')->first()->id;
        $estatus_denuncia    = Catalogo::whereCodigo('estatus_denuncia_ati')->first();

        //Validaciones
        $validate = $this->validacionesDenuncias($formdata);

        if (!$validate['status']){
            return [
                'status' => "203",
                'message' => $validate['message'],
            ];
        }
        //Arreglo para Insert
        $datos = [
            "origen_id"               => $formdata["origen_id"],
            "sindicato_denunciante"   => !empty($formdata["sindicato_denunciante"])?$formdata["sindicato_denunciante"]:'N/A',
            "nombre_denunciante"      => !empty($formdata["nombre_denunciante"])?$formdata["nombre_denunciante"]:'N/A',
            "primer_apellido_denunciante" => !empty($formdata["primer_apellido_denunciante"])?$formdata["primer_apellido_denunciante"]:'N/A',
            "segundo_apellido_denunciante" => $formdata["segundo_apellido_denunciante"],
            "telefono_denunciante"    => !empty($formdata["telefono_denunciante"])?$formdata["telefono_denunciante"]:'N/A',
            "correo_denunciante"      => $formdata["correo_denunciante"],
            "dni_denunciante"         => !empty($formdata["dni_denunciante"])?$formdata["dni_denunciante"]:'N/A',
            "nombre_funcionario"      => $formdata["nombre_funcionario"],
            "oficina_regional_id"     => $formdata["oficina_regional_id"],
            "region_departamento_id"  => $formdata["region_departamento_id"],
            "region_municipio_id"     => $formdata["region_municipio_id"],
            "descripcion_denuncia"    => $formdata["descripcion_denuncia"],
            "folio"                   => $folio,
            "cuenta_con_pruebas"      => (bool)$formdata["cuenta_con_pruebas"],
            "estatus_id"              => CatalogoElemento::where('catalogo_id', '=', $estatus_denuncia->id)->where('codigo', 'pendiente')->first()->id,
            "medio_recepcion_id"      => !empty($formdata["medio_recepcion_id"])?$formdata["medio_recepcion_id"]:$linea_recepcion,
        ];

        //Insert
        $denuncia = Denuncia::create($datos);
        //Inserto valores DomiciliosService
        if ($formdata["departamento_id"] != "" || $formdata["municipio_id"] != "" || $formdata["ciudad"] != "" || $formdata["calle"] != "" || $formdata["num_exterior"] != "" || $formdata["num_exterior"] != "" || $formdata["codigo_postal"] != "" ){
            
            if($formdata["departamento_id"] ==''){
                $formdata["departamento_id"] = null;
            }
            if($formdata["municipio_id"] ==''){
                $formdata["municipio_id"] = null;
            }
            $request->request->add(['departamento_id' => $formdata["departamento_id"]]);
            $request->request->add(['municipio_id' => $formdata["municipio_id"]]);
            $request->request->add(['ciudad' => $formdata["ciudad"]]);
            $request->request->add(['calle' => $formdata["calle"]]);
            $request->request->add(['num_exterior' => $formdata["num_exterior"]]);
            $request->request->add(['num_interior' => $formdata["num_interior"]]);
            $request->request->add(['codigo_postal' => $formdata["codigo_postal"]]);

            $domicilio = new DomiciliosService();
            $domicilio->guardarDomicilio($request,$denuncia);
        }
        //Carga Archivo Oficio
            $files_oficio_denuncia = ArchivosController::storeSimple($request, 'oficio_denuncia', $denuncia->getMorphClass(), $denuncia->id, $dependencia_id, $folio);
        //Carga Archivo Pruebas
            $files_prueba_denuncia = ArchivosController::storeMultiple($request, 'pruebas_denuncia', $denuncia->getMorphClass(), $denuncia->id, $dependencia_id, $folio);
        //Asignación auditor
            $this->asignacionDenuncia($denuncia, $datos);
        //Envio de Correo
            $this->envioCorreoDenuncia($folio, $datos);
        //Bitacora
        if ($request->isValor != 0){
            $usuario = User::where('id',$request->isValor)->first();
            registroBitacora($denuncia, A_REGISTRAR, C_DENUNCIAS, null, 'El usuario ' . $usuario->complete_name. ' registró una denuncia con el folio ' . $denuncia->folio, $formdata,$usuario->id);
        }
        //Respuesta
        return [
            'status' => "201",
            'message' => "Proceso exitoso. ",
            'folio' =>  $folio,
        ];
    }
    /**
     * Description: permite validar los parametros de validaciones para registrar la denuncia
     *
     * @param  mixed $datos
     * @return array
     */
    public function validacionesDenuncias(array $datos):array
    {
        $validate['status'] = true;
        $validate['message'] = "";

        if (empty($datos["origen_id"]) || !is_numeric($datos["origen_id"])){
            $validate['message']  = $validate['message'] ."El campo origen de la denuncia es obligatorio.\n";
            $validate['status'] = false;
        }

        if (empty($datos["sindicato_denunciante"])){
            if (empty($datos["nombre_denunciante"]) ){
                $validate['message']  = $validate['message'] ."El campo nombre del denunciante es obligatorio.</br>";
                $validate['status'] = false;
            }
            if (empty($datos["primer_apellido_denunciante"])){
                $validate['message']  = $validate['message'] ."El campo primer apellido denunciante es obligatorio. </br>";
                $validate['status'] = false;
            }
        }

        if (empty($datos["correo_denunciante"])){
            $validate['message']  = $validate['message'] ."El campo correo electrónico es obligatorio.</br>";
            $validate['status'] = false;
        }
        if ( $datos["inpConfCorreo"] !== $datos["correo_denunciante"] ){
            $validate['message']  = $validate['message'] ."Ambos campos de correo electrónico deben ser iguales.</br>";
            $validate['status'] = false;
        }

        if (empty($datos["nombre_funcionario"])){
            $validate['message']  = $validate['message'] ."El campo nombre funcionario es obligatorio.</br>";
            $validate['status'] = false;
        }

        if (empty($datos["descripcion_denuncia"])){
            $validate['message']  = $validate['message'] ."El campo  Descripción de la denuncia es obligatorio.</br>";
            $validate['status'] = false;
        }

        if (empty($datos["region_departamento_id"]) ||  !is_numeric($datos["region_departamento_id"])){
            $validate['message']  = $validate['message'] ."El campo  Departamento de la denuncia es obligatorio.</br>";
            $validate['status'] = false;
        }

        if (empty($datos["region_municipio_id"]) ||  !is_numeric($datos["region_municipio_id"])){
            $validate['message']  = $validate['message'] ."El campo  Municipio de la denuncia es obligatorio.</br>";
            $validate['status'] = false;
        }

        return $validate;
    }
    /**
     * Description: permite validar y enviar las notificaciones
     *
     * @param  mixed $folio
     * @param  mixed $datos
     * @return void
     */
    public function envioCorreoDenuncia($folio, $datos)
    {
        //Envio de correo
            //Variables
            $nom_persona           = $datos["sindicato_denunciante"] == 'N/A' ? $datos["nombre_denunciante"].' '.$datos["primer_apellido_denunciante"].' '.$datos["segundo_apellido_denunciante"] : $datos["sindicato_denunciante"];
            $role_id_jefe_auditor  = Role::where('name', '=', 'jefe_auditoria_setrass_ati')->value('id');
            $user_jefe_auditor     = User::where('perfil_id', '=', $role_id_jefe_auditor)->first();

            $usu_juridicion_id = UsuarioJurisdiccion::where('municipio_id', '=', $datos["region_municipio_id"])->first();

            //Correo para el denunciante
            $contenido = "Le informamos que su solicitud ha sido registrada con folio $folio. En caso de requerir más información será contactado por este medio o por aquellos proporcionados en su solicitud.<br><br>Auditoría Técnica de Inspección del Trabajo";
            try{
                Mail::to($datos["correo_denunciante"])->send(new NotificacionPublica('Registro de información de denuncia ante la ATI', $contenido, $nom_persona));
            }catch (\Exception $e){
                Log::error($e->getMessage());
            }

            //Auditor por Region
            $contenido = "Le informamos que se le ha asignado para su atención la denuncia con folio ".$folio.". <br><br>Saludos.";

            if ($usu_juridicion_id){
                $user_auditor      = User::find($usu_juridicion_id->usuario_id);
                try{
                    Mail::to($user_auditor->email)->send(new NotificacionPersonalizada($user_auditor, 'Registro de información de denuncia ante la ATI', $contenido));
                }catch (\Exception $e){
                    Log::error($e->getMessage());
                }
                $nombre_auditor = $user_auditor->nombre_completo;
                //Jefe de Auditoria
                $contenido = 'Le informamos que se ha registrado una denuncia con folio '.$folio.' la cual fue asignada para su atención a '.$nombre_auditor.'.<br><br> Saludos.';
                try{
                    Mail::to($user_jefe_auditor->email)->send(new NotificacionPersonalizada($user_jefe_auditor, 'Registro de información de denuncia ante la ATI', $contenido));
                }catch (\Exception $e){
                    Log::error($e->getMessage());
                }
            }else{
                //En caso que no exista Auditor se le envia correo normal pero al jefe de auditorias
                $contenido = "Le informamos que se le ha asignado para su atención la denuncia con folio ".$folio.". <br><br>Saludos.";
                try{
                    Mail::to($user_jefe_auditor->email)->send(new NotificacionPersonalizada($user_jefe_auditor, 'Registro de información de denuncia ante la ATI', $contenido));
                }catch (\Exception $e){
                    Log::error($e->getMessage());
                }
            }
    }
    /**
     * Description: permite asignar de manera automatica la denuncia al auditor correspondiente al municipio
     *
     * @param  mixed $denuncia
     * @return void
     */
    public function asignacionDenuncia($denuncia)
    {
        //Variables
        $usu_juridicion_id = UsuarioJurisdiccion::where('municipio_id', '=', $denuncia->region_municipio_id)->first();
        $datos = [
            'denuncia_id'=>$denuncia->id,
            'estatus_id' =>$denuncia->estatus_id,
            "observacion" =>$denuncia->descripcion_denuncia,
        ];
        if($usu_juridicion_id){
            $datos['usuario_asignado_id'] = $usu_juridicion_id->usuario_id;
            $denuncia->usuario_asignado_id = $usu_juridicion_id->usuario_id;
        }else{
            $role_id_jefe_auditor  = Role::where('name', '=', 'jefe_auditoria_setrass_ati')->value('id');
            $user_jefe_auditor     = User::where('perfil_id', '=', $role_id_jefe_auditor)->first();
            $datos['usuario_asignado_id']   = $user_jefe_auditor->id;
            $denuncia->usuario_asignado_id = $user_jefe_auditor->id;
        }
        //Asigno auditor
        $denuncia->save();
        return GestionDenuncia::create($datos);
    }

    public function cambioEstatus(Denuncia $denuncia,$usuario_id,$estatus_id,$observacion=null,$motivo_id=null){
        $usuario_asignado = User::findOrFail($usuario_id);
        $estatus = CatalogoElemento::findOrFail($estatus_id);
        $asignacion = GestionDenuncia::create([
            'denuncia_id'=>$denuncia->id,
            'estatus_id'=>$estatus->id,
            'usuario_asignado_id'=>$usuario_asignado->id,
            'creador_id'=>Auth::id(),
            'observacion'=>$observacion,
            'motivo_id'=>$motivo_id
        ]);
        $descripcionBitacora = "Se registra cambio de estatus del usuario $usuario_asignado->complete_name a la denuncia de id ".$denuncia->id." con estatus ".$estatus->nombre;
        registroBitacora($asignacion,A_REGISTRAR,C_DENUNCIAS,null,$descripcionBitacora);

        if($asignacion)
            $denuncia->update(['usuario_asignado_id'=>$usuario_id,'estatus_id'=>$estatus_id]);

    }
}
