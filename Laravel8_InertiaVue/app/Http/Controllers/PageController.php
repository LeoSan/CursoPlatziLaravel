<?php

namespace App\Http\Controllers;

use Inertia\Inertia; 
use Illuminate\Http\Request;


class PageController extends Controller
{
    //
    public function dashboard(){

        //Nota: Esto hace referencia a Page-> \resources\js\Pages\Dashboard.vue
        return Inertia::render('Dashboard');  
    }

}
