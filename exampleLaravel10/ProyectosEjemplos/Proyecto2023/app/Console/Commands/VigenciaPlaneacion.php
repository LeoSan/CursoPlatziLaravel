<?php

namespace App\Console\Commands;

use App\Http\Controllers\PlaneacionesController;
use App\Models\Catalogo;
use App\Models\Planeacion;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class VigenciaPlaneacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vigencia-planeacion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambiar vigencia de Planeaciones anuales de auditorías';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        registroBitacora(null,'Eecución cron','CRONS',null,'Se ejecuta el comando para cambio de vigencia');
        $catalogo = Catalogo::whereCodigo('estatus_plan_anual')->first();
        $estatusVigente = $catalogo->elementos?->where('codigo', 'vigente')->first();
        $estatusRegistrado = $catalogo->elementos?->where('codigo', 'registrado')->first();
        $estatusHistorico = $catalogo->elementos?->where('codigo', 'historico')->first();
        $admin = User::Role('admin_setrass')->first();

        Planeacion::where('anio', '<', date('Y'))->update(['estatus_id' => $estatusHistorico->id]);

        $planeacioActual = Planeacion::where('anio', date('Y'))->first();

        if ($planeacioActual && ($planeacioActual->estatus->codigo == 'registrado')) {
            $planeacioActual->estatus_id = $estatusVigente->id;
            $planeacioActual->save();

            registroBitacora($planeacioActual,A_ACTIVAR,C_VIGENCIA_PLANEACION,null,
                "Se desactiva la vigencia de las planeaciones de años anteriores y entra en vigencia la Planeación anual $planeacioActual->anio.",
                [], $admin->id);
        }

        if ($planeacioActual && $planeacioActual->ejecuciones->count() < 1 ) {
            PlaneacionesController::ejecucionVigencia($planeacioActual);
        }

    }
}
