<?php

namespace App\Jobs;

use App\Mail\NotificacionPersonalizada;
use App\Models\{Caso, User,PlaneacionAuditoria,Denuncia, GestionCaso, GestionDenuncia};
use App\Services\GestionCasoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class ReasignarExpedientes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $usuario_eliminar;
    private $usuario_reasignar;
    private $usuario_accion;
    protected $gestion;

    /**
     * Create a new job instance.
     */
    public function __construct($usuario_reasignar,$usuario_eliminar,$usuario_accion)
    {
        $this->usuario_reasignar = $usuario_reasignar;
        $this->usuario_eliminar = $usuario_eliminar;
        $this->usuario_accion = $usuario_accion;
        $this->gestion = new GestionCasoService();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $usuario_eliminar = User::find($this->usuario_eliminar);
        $usuario = User::find($this->usuario_eliminar);
        $usuario_reasignado = User::find($this->usuario_reasignar);
        $usuario_accion = User::find($this->usuario_accion);
        $nombre_sistema = getNombreSistema($usuario->id);
        if(($usuario_eliminar->area->codigo == 'dgit' || $usuario_eliminar->area->codigo == 'dnpj') && $usuario_eliminar->perfil->name != 'jefe_regional'){
            $expediente = 'los caso(s)';
            $casos = $usuario_eliminar->casos;
            if(count($casos) >0 ){
                for($i=0; $i<count($casos); $i++){
                    $caso = Caso::findOrFail($casos[$i]->id);
                    $gestionCaso = $caso->gestion->where('estatus_id', $caso->estatus_id)->where('caso_id',$caso->id)->where('usuario_asignado_id',$caso->usuario_asignado_id)->first();
                    $gestionCaso->usuario_asignado_id = $this->usuario_reasignar;
                    $gestionCaso->save();
                    $caso->update(['usuario_asignado_id'=>$this->usuario_reasignar]);
                    $gestionCasoActualizado = GestionCaso::where('id',$gestionCaso->id)->first();

                    $descripcionBitacora = "El usuario ".$usuario_accion->complete_name ." eliminó al usuario ".$usuario_eliminar->complete_name." y reasignó el caso con id ".$caso->id." al usuario ".$usuario_reasignado->complete_name.".";
                    registroBitacora($gestionCasoActualizado,A_ACTUALIZAR,C_GESTION_CASOS,null,$descripcionBitacora);
                    }
                }
            }
        if($usuario_eliminar->area->codigo == 'ati'){
        $denuncias = $usuario_eliminar->denuncias;
        $auditorias= $usuario_eliminar->auditorias;
            if(count($denuncias) >0 ){
                $expediente = 'las denuncia(s)';
                for($i=0; $i<count($denuncias); $i++){
                    $denuncia = Denuncia::findOrFail($denuncias[$i]->id);
                    $gestionDenuncia = $denuncia->gestion->where('estatus_id', $denuncia->estatus_id)->where('denuncia_id',$denuncia->id)->where('usuario_asignado_id',$denuncia->usuario_asignado_id)->first();
                    $gestionDenuncia->usuario_asignado_id = $this->usuario_reasignar;
                    $gestionDenuncia->save();
                    $denuncia->update(['usuario_asignado_id'=>$this->usuario_reasignar]);
                    $gestionDenunciaActualizado = gestionDenuncia::where('id',$gestionDenuncia->id)->first();

                    $descripcionBitacora = "El usuario ".$usuario_accion->complete_name ." eliminó al usuario ".$usuario_eliminar->complete_name." y reasignó la denuncia con id ".$denuncia->id." al usuario ".$usuario_reasignado->complete_name.".";
                    registroBitacora($gestionDenunciaActualizado,A_ACTUALIZAR,C_GESTION_DENUNCIAS,null,$descripcionBitacora);
                }
            }
            if(count($auditorias) >0 ){
                if($expediente != ''){
                    $expediente .= ' y auditoria(s)';
                }else{
                    $expediente = 'las auditoria(s)';
                }
                
                for($i=0; $i<count($auditorias); $i++){
                    $auditoria = PlaneacionAuditoria::find($auditorias[$i]->id);
                    $auditoria->auditor_responsable_id = $this->usuario_reasignar;
                    $auditoria->save();
                }
            }   
        }
        if(($usuario_eliminar->area->codigo == 'dgit' || $usuario_eliminar->area->codigo == 'dnpj') && $usuario_eliminar->perfil->name == 'jefe_regional'){
            $denuncias = $usuario_eliminar->denuncias;
            $casos = $usuario_eliminar->casos;
            $expediente = '';
            if(count($denuncias) >0 ){
                $expediente = 'las denuncia(s)';
                for($i=0; $i<count($denuncias); $i++){
                    $denuncia = Denuncia::findOrFail($denuncias[$i]->id);
                    $gestionDenuncia = $denuncia->gestion->where('estatus_id', $denuncia->estatus_id)->where('denuncia_id',$denuncia->id)->where('usuario_asignado_id',$denuncia->usuario_asignado_id)->first();
                    $gestionDenuncia->usuario_asignado_id = $this->usuario_reasignar;
                    $gestionDenuncia->save();
                    $denuncia->update(['usuario_asignado_id'=>$this->usuario_reasignar]);
                    $gestionDenunciaActualizado = gestionDenuncia::where('id',$gestionDenuncia->id)->first();

                    $descripcionBitacora = "El usuario ".$usuario_accion->complete_name ." eliminó al usuario ".$usuario_eliminar->complete_name." y reasignó la denuncia con id ".$denuncia->id." al usuario ".$usuario_reasignado->complete_name.".";
                    registroBitacora($gestionDenunciaActualizado,A_ACTUALIZAR,C_GESTION_DENUNCIAS,null,$descripcionBitacora);
                }
            }
            if(count($casos) >0 ){
                if($expediente != ''){
                    $expediente .= ' y caso(s)';
                }else{
                    $expediente = 'los caso(s)';
                }
                
                for($i=0; $i<count($casos); $i++){
                    $caso = Caso::findOrFail($casos[$i]->id);
                    $gestionCaso = $caso->gestion->where('estatus_id', $caso->estatus_id)->where('caso_id',$caso->id)->where('usuario_asignado_id',$caso->usuario_asignado_id)->first();
                    $gestionCaso->usuario_asignado_id = $this->usuario_reasignar;
                    $gestionCaso->save();
                    $caso->update(['usuario_asignado_id'=>$this->usuario_reasignar]);
                    $gestionCasoActualizado = GestionCaso::where('id',$gestionCaso->id)->first();

                    $descripcionBitacora = "El usuario ".$usuario_accion->complete_name ." eliminó al usuario ".$usuario_eliminar->complete_name." y reasignó el caso con id ".$caso->id." al usuario ".$usuario_reasignado->complete_name.".";
                    registroBitacora($gestionCasoActualizado,A_ACTUALIZAR,C_GESTION_CASOS,null,$descripcionBitacora);
                }
            }

        }
        
        $mensaje = "Le informamos que se ha eliminado el usuario <strong>".$usuario->nombre_completo ."</strong> del ".$nombre_sistema." y ".$expediente." que tenía en proceso fueron reasignados a <strong>".$usuario_reasignado->nombre_completo."</strong>.<p>Saludos.</p>";
        $usuario->delete();
        Mail::to($usuario_accion->email)->send(new NotificacionPersonalizada($usuario_accion, 'Confirmación de eliminación de usuario', $mensaje));
        $nombre_sistema = getNombreSistema($usuario_reasignado->id);
        $mensaje = "Le informamos que <strong>".$usuario_accion->nombre_completo ."</strong> le ha reasignado los temas que estaban a cargo de <strong>".$usuario->nombre_completo."</strong> en el ".$nombre_sistema.".<p>Por favor ingrese al sistema para conocer más detalle.</p><p>Saludos.</p>";
        Mail::to($usuario_reasignado->email)->send(new NotificacionPersonalizada($usuario_reasignado, 'Nuevas asignaciones el sistema '.$nombre_sistema, $mensaje));
    }
}
