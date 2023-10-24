<?php

namespace App\Console\Commands;

use App\Mail\Notificacion;
use App\Models\{Denuncia,User, DiaNoHabil};
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class SeguimientoSolicitudExpediente extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seguimiento-solicitud-expediente';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica el estatus de las denuncias con estatus solicitud expediente plazo de 3 dias para ser notificado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoy           = Carbon::now();
        $dias_tope     = intval(config('app.plazo_solicitud_expediente'));
        $admin_setrass = User::Role('admin_setrass')->first();

        //Valido Lunes a Viernes
        if($hoy->isWeekday() && $this->isFeriado($hoy->format('Y-m-d')) === false ){

            registroBitacora(null,'Eecución cron','CRONS',null,'Se ejecuta el seguimiento de Solicitud Expediente 3 dias habiless');
            //Busco todas las denuncias que han pasado por Estatus [solicitud_expediente]
            $denuncias = Denuncia::whereHas('estatus',function($q){$q->whereCodigo('solicitud_expediente');})->get();

            foreach ($denuncias as $denuncia){
                $solicitud_exp = $denuncia->gestion()->whereHas('estatus',function($q){$q->whereCodigo('solicitud_expediente');})->first();
                if ($solicitud_exp){

                    //Calculos las fechas maximas desde que fue solicitud_expediente
                    $fecha_solicitud_exp = Carbon::create($solicitud_exp->created_at);
                    $fecha_maxima   = Carbon::create($solicitud_exp->created_at)->addWeekdays($dias_tope);
                    $dias_transcurridos = $fecha_solicitud_exp->diffInDaysFiltered(function(Carbon $date) {
                        return $date->isWeekday();
                    }, $hoy);

                    //Valores para el correo
                    $extras = [
                        'folio_denuncia' => isset($denuncia->num_expediente_dgit)?$denuncia->num_expediente_dgit:'',
                        'fecha_admicion' => $fecha_solicitud_exp->isoFormat('D [de] MMMM [de] YYYY'),
                        'fecha_maxima'   => $fecha_maxima->isoFormat('D [de] MMMM [de] YYYY'),
                        'url' => route('denuncias.index')
                    ];

                    if ( $dias_transcurridos > $dias_tope && $solicitud_exp->notificado == false ){//Se envia solo una vez

                        //Usuario Rol Auditor
                        $ids = $denuncia->gestion_denuncia()->pluck('usuario_asignado_id')->toArray();
                        $user_auditor_mail = User::role('auditor_setrass_ati')->whereIn('id',$ids)->first();

                        $user_jefe_auditor_mail = User::role('jefe_auditoria_setrass_ati')->first();
                        $user_region_auditor_mail = User::role('jefe_regional')->whereIn('id',$ids)->first();

                        try {
                            Mail::to($user_auditor_mail->email)->send(new Notificacion($user_auditor_mail, 'seguimientoRecordatorioSolicitudExpediente', "Recordadorio - Solicitud de expediente ".$extras['folio_denuncia'],  $extras ));
                            //Copia Oculta
                            Mail::cc($user_jefe_auditor_mail->email)->send(new Notificacion($user_auditor_mail, 'seguimientoRecordatorioSolicitudExpediente', "Recordadorio - Solicitud de expediente ".$extras['folio_denuncia'],  $extras ));
                            Mail::cc($user_region_auditor_mail->email)->send(new Notificacion($user_auditor_mail, 'seguimientoRecordatorioSolicitudExpediente', "Recordadorio - Solicitud de expediente ".$extras['folio_denuncia'],  $extras ));

                            registroBitacora($denuncia,A_EJECUCION,C_GESTION_DENUNCIAS,SC_DENUNCIA_SOLICITUD_EXP,"Se ejecuta el proceso de seguimiento solicitud de expediemte, para notificar el vencimieto de plazo de 3 días de la denuncia con folio $denuncia->folio.",null,$admin_setrass->id);
                            registroBitacora($denuncia,A_NOTIFICAR,C_GESTION_DENUNCIAS,SC_DENUNCIA_SOLICITUD_EXP,"Se notifica el vencimiento de 3 días habiles para dar seguimiento a la solicitud de expediente, se notificó al usuario $user_auditor_mail->complete_name con folio $denuncia->folio.",null,$user_auditor_mail->id);

                            //Actualizo la gestion
                            $solicitud_exp->update(['notificado'=>true,'fecha_notificacion_auditor'=>now()]);

                        } catch (\Exception $e) {
                            
                        }

                        //Dias restantes 0 Se le acabo el tiempo y fue notificado
                        $denuncia->cont_noti_auditor = 3;
                        $denuncia->save();
                    }else{
                        //Se lleva el contador de cuantos días le quedan para vencer el plazo
                        $denuncia->cont_noti_auditor = $dias_transcurridos;
                        $denuncia->save();
                    }
                }
            }//Fin del for
        }
    }

    /**
     * Metodo: Permite consultar si es feriado
     */
    public function isFeriado($day){
        $is_feriado = DiaNoHabil::where('fecha', '=',$day )->first();

        if ($is_feriado){
            return true;
        }
        return false;
    }
}
