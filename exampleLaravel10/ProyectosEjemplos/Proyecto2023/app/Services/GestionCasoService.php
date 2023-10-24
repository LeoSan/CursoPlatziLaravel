<?php

namespace App\Services;

use App\Mail\Notificacion;
use App\Models\Caso;
use App\Models\CatalogoElemento;
use App\Models\GestionCaso;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use function config;
use function registroBitacora;

class GestionCasoService
{
    public function asignacionRoundRobin(Caso $caso,$permiso,$estatus_id,$notificacion=false){
        $users = User::permission($permiso)->orderBy('id');
        $ids = $users->pluck('id')->toArray();
        $asignaciones = GestionCaso::whereIn('usuario_asignado_id',$ids)->orderBy('id','desc')->get();
        if($users->count()==1){
            $usuario_asignado = $users->first();
            $this->asignacion($caso,$usuario_asignado->id,$estatus_id);
        }else{
            if(!$asignaciones->count()){
                $usuario_asignado = $users->first();
                $this->asignacion($caso,$usuario_asignado->id,$estatus_id);
            }else{
                $ultimo_asignado = $asignaciones->first()->usuario_asignado_id;
                $siguiente = User::permission($permiso)->where('id','>',$ultimo_asignado)->first();
                if(!$siguiente)
                    $siguiente = User::permission($permiso)->first();
                $usuario_asignado = $siguiente;
                $this->asignacion($caso,$usuario_asignado->id,$estatus_id,null,null,$notificacion);
            }
        }
    }
    public function asignacion(Caso $caso,$usuario_id,$estatus_id,$observacion=null,$motivo_id=null,$notificacion=false){
        $usuario_asignado = User::findOrFail($usuario_id);
        $estatus = CatalogoElemento::findOrFail($estatus_id);
        $asignacion = GestionCaso::create([
            'caso_id'=>$caso->id,
            'estatus_id'=>$estatus->id,
            'usuario_asignado_id'=>$usuario_asignado->id,
            'creador_id'=>Auth::id(),
            'observacion'=>$observacion,
            'motivo_id'=>$motivo_id
        ]);
        $descripcionBitacora = "Se registra la asignación del usuario $usuario_asignado->complete_name al caso de id ".$caso->id." con estatus ".$estatus->nombre;
        registroBitacora($asignacion,A_REGISTRAR,C_GESTION_CASOS,null,$descripcionBitacora);

        if($asignacion)
            $caso->update(['usuario_asignado_id'=>$usuario_id,'estatus_id'=>$estatus_id]);

        if($notificacion){
            try{
                Mail::to($usuario_asignado->email)->send(new Notificacion($usuario_asignado, 'asignacion', "Asignación de caso", [
                    'autor' => Auth::user()->complete_name,
                    'url' => config('app.url'),
                    'numero_expediente' => $caso->numero_expediente,
                    'numero_expediente_pgr' => $caso->numero_expediente_pgr,
                ]));
                $descripcionBitacora = "Se notifica la asignación del caso de id ".$caso->id." con estatus ".$estatus->nombre." al usuario $usuario_asignado->complete_name";

            }catch (\Exception $e){
                Log::info($e->getMessage());
                $descripcionBitacora = "Error al notificar la asignación del caso de id ".$caso->id." con estatus ".$estatus->nombre." al usuario $usuario_asignado->complete_name";

            }
            registroBitacora($asignacion,A_NOTIFICAR,C_GESTION_CASOS,null,$descripcionBitacora);
        }

    }
    public function regresar(Caso $caso,$estatus_id,$observacion=null,$motivo_id=null){
        $ultima_asignacion = GestionCaso::whereCasoId($caso->id)->orderByDesc('id')->first();
        $usuario = $ultima_asignacion->asignado;
        $this->asignacion($caso,$usuario->id,$estatus_id,$observacion,$motivo_id);
    }
}
