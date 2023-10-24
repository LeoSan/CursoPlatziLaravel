<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('seguimiento-providencias')->dailyAt('00:01');
        $schedule->command('pagos-vencidos-convenio')->dailyAt('00:01');
        $schedule->command('seguimiento-solicitud-expediente')->dailyAt('00:01');
        $schedule->command('seguimiento-atencion-denuncia')->dailyAt('00:01');
        $schedule->command('vigencia-planeacion')->yearlyOn('9', '15','00:01');
        $schedule->command('plazo-vencido-auditoria-solicitud-expedientes')->dailyAt('00:01');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}