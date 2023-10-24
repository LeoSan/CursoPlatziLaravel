<?php

namespace App\Console\Commands;

use App\Mail\Notificacion;
use App\Models\{Denuncia,User, DiaNoHabil};
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
//use Illuminate\Support\Arr;


class SeguimientoAtencionDenuncia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seguimiento-atencion-denuncia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica el estatus de las denuncias admitidas estas deberan ser atendida en un plazo máximo de 15 días hábiles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoy                = Carbon::now();
        $dias_maximo_plazo  = intval(config('app.plazo_vencimiento_denuncia'));
        $dias_mitad_plazo   = round($dias_maximo_plazo / 2) ;

        //Valido Lunes a Viernes
        if($hoy->isWeekday() && $this->isFeriado($hoy->format('Y-m-d')) === false ){

            registroBitacora(null,'Eecución cron','CRONS',null,'Se ejecuta el seguimiento de la denuncia plazo máximo 15 dias hábiles');

            //Busco todas las denuncias que han pasado por Estatus [admitida]
            $denuncias = Denuncia::whereHas('estatus',function($q){
                $q->whereCodigo('admitida');
            })->get();

            foreach ($denuncias as $denuncia){
                    //Extraigo la fecha de admisión
                    $admitida = $denuncia->gestion()->whereHas('estatus',function($q){$q->whereCodigo('admitida');})->first();

                    //Calculos las fechas maximas desde que fue admitida
                    $fecha_admitida = Carbon::create($admitida->created_at);
                    $fecha_maxima   = Carbon::create($admitida->created_at)->addWeekdays($dias_maximo_plazo);
                    $dias_transcurridos = $fecha_admitida->diffInDaysFiltered(function(Carbon $date) {
                        $inhabil = DiaNoHabil::whereFecha($date->format('Y-m-d'))->first();
                        if(!$inhabil)
                            return $date->isWeekday();
                    }, $hoy);

                    //Valores para el correo
                    $extras = [
                        'folio_denuncia' => $denuncia->folio,
                        'fecha_admicion' => $fecha_admitida->isoFormat('D [de] MMMM [de] YYYY'),
                        'fecha_maxima'   => $fecha_maxima->isoFormat('D [de] MMMM [de] YYYY'),
                        'url' => route('denuncias.index')
                    ];

                    //Maximo 15 - Días
                    if( $dias_transcurridos >= $dias_maximo_plazo && $admitida->notificado == false){
                        //Usuario Jefe Auditor
                        $ids = $denuncia->gestion_denuncia()->pluck('usuario_asignado_id')->toArray();
                        $user_mail = User::role('jefe_auditoria_setrass_ati')->whereIn('id',$ids)->first();
                        if(!$user_mail){
                            $user_mail = User::role('jefe_auditoria_setrass_ati')->first();
                        }
                        try {
                            Mail::to($user_mail->email)->send(new Notificacion($user_mail, 'plazoAtencionDenunciaVencido', "Se ha vencido el plazo para atender la denuncia con expediente ".$denuncia->folio, $extras ));
                            registroBitacora($denuncia,A_EJECUCION,C_GESTION_DENUNCIAS,SC_DENUNCIA_VENCIDO,"Se ejecuta el proceso de seguimiento del plazo atencion denuncia vencido con folio $denuncia->folio.",null,$user_mail->id);
                            registroBitacora($denuncia,A_NOTIFICAR,C_GESTION_DENUNCIAS,SC_DENUNCIA_VENCIDO,"Se notifica el proceso de seguimiento del plazo atencion denuncia vencido con folio $denuncia->folio, se notificó al usuario $user_mail->complete_name.",null,$user_mail->id);
                        } catch (\Exception $e) {
                        }

                        //Actualizo la gestion
                        $admitida->update(['notificado'=>true,'fecha_notificacion_auditor'=>now()]);

                        //Dias restantes 0 Se le acabo el tiempo y fue notificado
                        $denuncia->cont_plazo_maximo = $dias_transcurridos;;
                        $denuncia->save();

                    }else if ( $dias_transcurridos == 7   ){ //llegamos a la mitad del palzo
                        //Usuario Rol  Auditor
                        $ids = $denuncia->gestion_denuncia()->pluck('usuario_asignado_id')->toArray();
                        $user_mail = User::role('auditor_setrass_ati')->whereIn('id',$ids)->first();

                        if(!$user_mail){
                            $user_mail = User::role('jefe_auditoria_setrass_ati')->whereIn('id',$ids)->first();
                        }
                        try {
                            Mail::to($user_mail->email)->send(new Notificacion($user_mail, 'mitadPlazoParaAtencionDenuncia', "Se ha cumplido la mitad del plazo para atender la denuncia con expediente ".$denuncia->folio, $extras ));
                            registroBitacora($denuncia,A_EJECUCION,C_GESTION_DENUNCIAS,SC_DENUNCIA_MITAD_PLAZO,"Se ejecuta el proceso de seguimiento mitad de plazo para atencion denuncia $denuncia->folio.",null,$user_mail->id);
                            registroBitacora($denuncia,A_NOTIFICAR,C_GESTION_DENUNCIAS,SC_DENUNCIA_MITAD_PLAZO,"Se notifica al auditor asignado mitad de plazo para atencion denuncia con folio $denuncia->folio, se notificó al usuario $user_mail->complete_name.",null,$user_mail->id);
                        } catch (\Exception $e) {
                        }


                        //Dias restantes 0 Se le acabo el tiempo y fue notificado
                        $denuncia->cont_plazo_maximo = $dias_transcurridos;;
                        $denuncia->save();
                    }else{
                        //Se lleva el contador de cuantos días le quedan para vencer el plazo
                        $denuncia->cont_plazo_maximo = $dias_transcurridos;
                        $denuncia->save();
                    }

            }//Fin del for
        }
    }

    /**
     * Metodo: Permite consultar si es feriado
     */
    public function isFeriado($day){
        $is_feriado = DiaNoHabil::where('fecha', '=',$day )->first();
        return (bool)$is_feriado;
    }
}
