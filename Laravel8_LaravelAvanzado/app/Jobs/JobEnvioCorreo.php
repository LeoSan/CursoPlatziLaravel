<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class JobEnvioCorreo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Login $event)
    {
        //
        $user = $event->user; //
        $user->profile_photo_path = 'https://c8.alamy.com/zoomses/9/d4c59d90389444e3b1166312d2f7fa51/p9mywr.jpg';
        $user->save();

        $email = new WelcomeEmail();

        Mail::to('cuenca623@gmail.com')->send($email);        

    }
}
