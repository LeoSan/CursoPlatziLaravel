<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\EnvioCorreo;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        EnvioCorreo::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /**Comando de prueba */ 
        $schedule->command('inspire')
                 ->evenInMaintenanceMode()
                 ->sendOutputTo(storage_path('logs/inspire.log'))
                 ->daily();

         $schedule->call(function (){
            echo "****Ejecutando comando Diariamente****";
         });
         
         /**Comando desarrollado */ 
         //$schedule->call(EnvioCorreo::class); // Otra forma de ejecutar
         //$schedule->command(EnvioCorreo::class)->onOneServer() // Tambien lo puedo ejecutar asi 
         $schedule->command('command:envio --schedule')->onOneServer() // No me funciono de esta manera 
         ->withoutOverlapping()
         ->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
