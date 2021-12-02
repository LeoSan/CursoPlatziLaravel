<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course; 

use App\Console\Commands\EnvioCorreo;
use Illuminate\Support\Facades\Artisan;


class PageController extends Controller
{
    //
    public function home (){
        return view('index');
    }

    public function course ($id){
        $curso = Course::with(['posts'])->find($id);  
        return view('curso', ['curso'=>$curso]);
    }      
    
    /**
     * Este Metodo permite activar un comando en consola personalizado 
     * */ 
    public function comandoActivo (){
        define('STDIN',fopen("php://stdin","r"));
        //Importamos el artisan
        // Importamos el Commands      
        //$result =  Artisan::call(EnvioCorreo::class, ['manual' => true ]); // No me funciona asi 
        $result =  Artisan::call(EnvioCorreo::class);
        
        return response()->json(['data'=>$result]);

    }    
}
