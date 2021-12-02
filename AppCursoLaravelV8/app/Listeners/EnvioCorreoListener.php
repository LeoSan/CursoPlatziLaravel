<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\ModelRated;
use App\Models\Rating;
use App\Notifications\EnvioCorreoNotification;


class EnvioCorreoListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event. -> Aqui va la logica de negocio que deseo cuando se ejecuta un evento 
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ModelRated $event)
    {
        //
        $rating = $event->getRating();

        if ($rating instanceof Rating){
            $notification = new EnvioCorreoNotification(); 
            $rating->user_id->notify( $notification);
            return true; 
        }

        return false; 

        
    }
}
