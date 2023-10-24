<?php

namespace App\Console\Commands;

use App\Mail\Notificacion;
use App\Models\{Pago, User, Caso, DiaNoHabil};
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ConvenioPagoVencido extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pagos-vencidos-convenio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica el estatus y el convenio de pago si esta vencido del caso';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoy = Carbon::now();
        $admin = User::Role('admin_setrass')->first();
        //Valido Lunes a Viernes
        if($hoy->isWeekday() && $this->isFeriado($hoy->format('d-m-Y')) === false ){
            registroBitacora(null,'Eecución cron','CRONS',null,'Se ejecuta el seguimiento de convenio de pagos');
            /*Busca los casos con pagos de convenio vencidos*/
            $casos = Caso::whereHas('estatus',function($q){
                $q->whereCodigo('convenio_pago');
            })->whereHas('convenio',function($q){
                $q->whereHas('pagos',function($q){
                    $hoy = Carbon::now();
                    if ($hoy->isWeekday())
                        $fecha = $hoy;
                    else
                        $fecha = $hoy->addWeekday();
                    $q->wherePagado(false)->whereDate('fecha','<',$fecha->format('Y-m-d'));
                });
            })->get();
            $casos->load('asignado');
            /*Recupera los responsables de los casos*/
            $responsables = $casos->pluck('asignado')->unique();
            /*Itera los responsables de los casos para notificar a cada uno*/
            foreach ($responsables as $responsable){
                /*Recupera los pagos vencidos de convenios de casos donde el asignado sea el $responsable*/
                $pagosVencidos = Pago::whereHas('convenio.caso', function ($query) use ($responsable) {
                    $query->whereHas('estatus',function($q){
                        $q->whereCodigo('convenio_pago');
                    });
                    $query->where('usuario_asignado_id', $responsable->id);
                })->where(function($q){
                    $hoy = Carbon::now();
                    if ($hoy->isWeekday())
                        $fecha = $hoy;
                    else
                        $fecha = $hoy->addWeekday();
                    $q->wherePagado(false)->whereDate('fecha','<',$fecha->format('Y-m-d'));
                })->get();
                $pagosVencidos->load('convenio.caso');
                $casos = $pagosVencidos->pluck('convenio.caso')->unique();

                foreach ($pagosVencidos as $pago)
                    $pago->update([
                        'vencido' => true,
                        'fecha_vencimiento' => now()
                    ]);

                try {
                    Mail::to($responsable->email)->send(new Notificacion($responsable, 'pagosVencidos', "Pagos vencidos al " . now()->format('d/m/Y'), ['casos'=>$casos, 'fecha_emitida'=>now()->format('d/m/Y')]));
                }catch (\Exception $e){
                    //Log::error('Error al enviar notificación de pagos vencidos. '.$e->getMessage());
                }

                registroBitacora(null,A_NOTIFICAR,C_GESTION_CASOS,SC_CONVENIO_PAGOS_VENCIDOS,"Se notifican vencimiento de pagos al usuario $responsable->complete_name. De los casos: ".$casos->implode('numero_expediente_pgr',', ')." y se marcan como vencidos.",null,$admin->id);
            }
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
