<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\EnvioCorreoNotification;

class EnvioCorreo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:envio 
                            {correo?*} : Correos Electronicos a los cuales enviar directamente
                            {--s|schedule : Si debe ser ejecutado directamente o no}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userEmails = $this->argument('correo');
        //$manual = $this->argument('manual');  //No me funciono asi 
        $schedule = $this->option('schedule');

        $builder = User::query();

        if ($userEmails) {
            $builder->whereIn('email', $userEmails);
        }


        $builder->whereNotNull('email_verified_at');

        if ($count = $builder->count()) {
            $this->output->progressStart($count);
            $this->info("Se enviaran {$count} correos");

            //if ($this->confirm('¿Estas de acuerdo?') || $manual) {
                $builder->each(function (User $user) {
                    $user->notify(new EnvioCorreoNotification());
                    $this->output->progressAdvance();
                });

                $this->info('Correos enviados');
                $this->output->progressFinish();
                return true;
           // }
        }
        $this->info('No se enviaron correos');
        return false;
    }
}

