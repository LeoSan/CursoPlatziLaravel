<?php

namespace App\Services;

use App\Models\Inhabil;
use Illuminate\Support\Facades\Log;

class InhabilServicio 
{
    /**
     * Metodo para consultar  
     */
    public function consultarDiasInhabiles( $request )
    {
        $fecha_inicio = $request->has("fecha_inicio") ? $request->fecha_inicio : '';
        $fecha_fin = $request->has("fecha_fin") ? $request->fecha_fin : '';
        //Consulta        
        $inhabil = Inhabil::where("plataforma_id", $request->plataforma_id )->where('persona_id', null);
        if ($fecha_inicio !='' && $fecha_fin !=''){
            $inhabil =  $inhabil->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
        } 
        return  $inhabil->get(); 
    }
    
    /*
     * Metodo para consultar  por personas sus días inhabiles
     */
    public function consultarPersonaIdDiasInhabiles( $request )
    {
        $fecha_inicio = $request->has("fecha_inicio") ? $request->fecha_inicio :'';
        $fecha_fin = $request->has("fecha_fin") ? $request->fecha_fin:  '';
        //Consulta 
        $inhabil = Inhabil::where("plataforma_id", $request->plataforma_id )->whereIn('persona_id', $request->persona_ids);
        if ($fecha_inicio !='' && $fecha_fin !=''){
            $inhabil =  $inhabil->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
        }   
        return  $inhabil->get(); 
    }

}
