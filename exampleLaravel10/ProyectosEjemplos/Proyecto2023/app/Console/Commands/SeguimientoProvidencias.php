<?php

namespace App\Console\Commands;

use App\Mail\Notificacion;
use App\Models\Denuncia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SeguimientoProvidencias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seguimiento-providencias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica el estatus de denuncias con estatus providencia';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoy = Carbon::now();
        if($hoy->isWeekday()){

            registroBitacora(null,'Eecución cron','CRONS',null,'Se ejecuta el seguimiento de denuncias con providencias activas');
            $dias_plazo = intval(config('app.plazo_vencimiento_providencias'));
            $mitad_plazo = round($dias_plazo / 2);
            $admin = User::Role('admin_setrass')->first();
            $denuncias = Denuncia::whereHas('estatus',function($q){
                $q->whereCodigo('providencia');
            })->get();
            foreach ($denuncias as $denuncia){
                $denunciante = User::whereEmail($denuncia->correo_denunciante)->first();
                $providencia = $denuncia->gestion()->whereHas('estatus',function($q){
                    $q->whereCodigo('providencia');
                })->first();
                $fecha_providencia = Carbon::create($providencia->created_at);
                //$fecha_providencia = $providencia->created_at->format('Y-m-d'); En caso de que se desee contar como día habil independientemente del día de la providencia;
                $fecha_maxima = Carbon::create($providencia->created_at)->addWeekdays($dias_plazo);
                $dias_transcurridos = $fecha_providencia->diffInDaysFiltered(function(Carbon $date) {
                    return $date->isWeekday();
                }, $hoy);
                $extras = (object)[
                    'folio_denuncia' => $denuncia->folio,
                    'fecha_providencia' => $fecha_providencia->isoFormat('D [de] MMMM [de] YYYY'),
                    'fecha_maxima' => $fecha_maxima->isoFormat('D [de] MMMM [de] YYYY'),
                    'url' => route('denuncias.index')
                ];
                if($dias_transcurridos>=$mitad_plazo && !$providencia->notificado){
                    Mail::to($denunciante->email)->send(new Notificacion($denunciante, 'recordatorioProvidencia', "Providencia relacionada a su denuncia con folio $denuncia->folio", $extras ));
                    $providencia->update(['notificado'=>true,'fecha_notificacion_denunciante'=>now()]);
                    registroBitacora($denuncia,A_NOTIFICAR,C_DETALLE_DENUNCIA,null,"Se notifica recordatorio de providencia de la denuncia $denuncia->folio.",['fecha_providencia'=>$fecha_providencia->format('Y-m-d')],$admin->id);
                }elseif($dias_transcurridos>=$dias_plazo && !$providencia->fecha_notificacion_auditor){
                    Mail::to($denuncia->asignado_a->email)->send(new Notificacion($denuncia->asignado_a, 'desestimacionProvidencia', "Providencia vencida de la denuncia con expediente $denuncia->folio", $extras ));
                    $providencia->update(['fecha_notificacion_auditor'=>now(),'vencido'=>true]);
                    registroBitacora($denuncia,A_NOTIFICAR,C_DETALLE_DENUNCIA,null,"Se notifica desestimación de denuncia $denuncia->folio por falta de respuesta al auditor.",['fecha_notificacion_auditor'=>now(),'vencido'=>true],$admin->id);
                }
            }
        }
    }
}
