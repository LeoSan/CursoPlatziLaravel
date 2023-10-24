<?php

namespace App\Console\Commands;

use App\Mail\Notificacion;
use Illuminate\Support\Arr;
use App\Models\{Catalogo,CatalogoElemento, User, PlaneacionSolicitudExpediente, DiaNoHabil, GestionAuditoria, PlaneacionAuditoriaEjecucion};
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class PlazoVencidoAuditoriaSolicitudExpedientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plazo-vencido-auditoria-solicitud-expedientes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica el estatus y tiempo de plazo a cada solicitud de expediente de auditorias';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoy = Carbon::now();
        $admin = User::Role('jefe_regional')->first();

        //Valido Lunes a Viernes Y Día feriado
        if($hoy->isWeekday() && $this->isFeriado($hoy->format('Y-m-d')) === false ){
            registroBitacora(null,'Eecución cron','CRONS',null,'Se ejecuta el plazo vencimiento de solicitud expedientes auditoria');
            /*Estatus Solicitud*/
            $estatus_auditoria = Catalogo::whereCodigo('estatus_solicitud_expediente')->first();
            $status_solicitud_solicitada_id = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('solicitud_solicitada')->first()->id;
            $status_solicitud_plazo_vencido_id = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('solicitud_plazo_vencido')->first()->id;
            $planeacionSolicitudExpediente = PlaneacionSolicitudExpediente::where('estatus_id', '=', $status_solicitud_solicitada_id)->get();
            /*Estaus Auditoria*/
            $estatus_auditoria = Catalogo::whereCodigo('estatus_auditorias')->first();
            $status_en_espera_id = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('espera')->first()->id;
            $status_plazo_vencido_id = CatalogoElemento::where('catalogo_id', '=', $estatus_auditoria->id)->whereCodigo('plazo_vencido')->first()->id;

            foreach ($planeacionSolicitudExpediente as $item){
                    $dias_tope           = $item->plazo_respuesta_solicitud;
                    $fecha_solicitud_exp = Carbon::create($item->fecha_solicitud);
                    $fecha_maxima        = Carbon::create($item->fecha_solicitud)->addWeekdays($dias_tope);
                    $dias_transcurridos = $fecha_solicitud_exp->diffInDaysFiltered(function(Carbon $date) {
                        return $date->isWeekday();
                    }, $hoy);

                    if ( $dias_transcurridos > $dias_tope && ($item->vencido == false || $item->vencido == null )  ){
                        $item->update(['vencido'=>true, 'estatus_id'=>$status_solicitud_plazo_vencido_id]);

                        GestionAuditoria::create([
                            "planeacion_solicitud_expediente_id" => $item->id,
                            "estatus_id"                         => $status_solicitud_plazo_vencido_id,
                            "usuario_asignado_id"                => $item->auditor_asignado_id,
                            "vencido"                            => true,
                            "notificado"                         => true,
                            "fecha_notificacion_auditor"         => now(),
                            "fecha_solicitud"                    => $item->fecha_solicitud,
                        ]);

                        //Actualizo la ejecucion con estatus en plazo vencido
                        $update_planeacion_ejecucion = PlaneacionAuditoriaEjecucion::whereHas('grupo',function($query)use($item){
                            return $query->where('region_id',$item->regional_id);
                        })->where('mes', $item->mes)->where('estatus_id', $status_en_espera_id)->get();

                        foreach ($update_planeacion_ejecucion as $actualizar)
                            $actualizar->update([
                                'estatus_id' => $status_plazo_vencido_id,
                            ]);

                        try {
                            $extras = [
                                'numero_oficio'     => $item->numero_oficio,
                                'fecha_solicitud'   => $fecha_solicitud_exp->isoFormat('D [de] MMMM [de] YYYY'),
                                'fecha_maxima'      => $fecha_maxima->isoFormat('D [de] MMMM [de] YYYY'),
                                'url'               => route('auditorias.listado.solicitar.expediente')
                            ];
                            $user_mail = User::where('id',$item->auditor_jefe_regional_id)->first();
                            Mail::to($user_mail->email)->send(new Notificacion($user_mail, 'plazoVencidoSolicitudExpedientes', "Se ha vencido el plazo para atender la solicitud con número de oficio ".$item->numero_oficio, $extras ));
                        } catch (\Exception $e) {

                        }
                        registroBitacora($item,A_NOTIFICAR,C_GESTION_AUDITORIAS,SC_PLAZO_VENCIDOS_SOL_EXP_AUDITORIA,"Se notifica el vencimiento de solicitud de expediente al usuario: $admin->complete_name con cargo $admin->cargo",null,$admin->id);
                    }
            }
        }
    }
    /**
     * Metodo: Permite consultar si es feriado
     */
    public function isFeriado($day){
        return (DiaNoHabil::where('fecha', '=',$day )->first())?true:false;
    }
}
