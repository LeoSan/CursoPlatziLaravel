<?php

namespace App\Services;

use App\Models\Evento;
use App\Models\Inhabil;
use Carbon\CarbonPeriod;
use App\Models\EventoPersona;
use Illuminate\Support\Facades\Log;

class Eventos
{
    /**
     * Consulta de disponibilidad de personas
     */
    public function agendados($atributos, $plataforma_id)
    {
        $e=Evento::where('plataforma_id',$plataforma_id)
            ->whereBetween('fecha',[$atributos['fecha_inicio'],$atributos['fecha_fin']]);
        if(isset($atributos['codigo_estado']))
            $e->where('codigo_estado',$atributos['codigo_estado']);
        $result=$e->get();
        foreach ($result as $index=>$evento){
            $personas=EventoPersona::where('evento_id',$evento->id)->pluck('persona_id');
            $evento['personas']=$personas;
            $result[$index]=$evento;
        }

        $inhabiles = [];
        $mostrar_inhabil = $atributos['mostrar_inhabil'] ?? true;
        if($mostrar_inhabil != false){
            $inhabil = Inhabil::where('plataforma_id',$plataforma_id)
                ->whereBetween('fecha',[$atributos['fecha_inicio'],$atributos['fecha_fin']])
                ->whereNull('persona_id')->get();
            
            foreach ($inhabil as $index=>$evento){
                
                $evento = [
                    'id' => $evento->id,
                    'evento_id' => '',
                    'titulo' => $evento->descripcion,
                    'tipo' => 'dia-inhabil',
                    'fecha' => $evento->fecha,
                    'codigo_estado' => null,
                    'municipio_alcaldia' => null,
                    'cp' => null,
                    'referencia' => null,
                    'referencia_id' => null,
                    'estatus' => null,
                    'latitud' => null,
                    'longitud' => null,
                    'perdonas' => []
                ];
                $inhabiles[] = $evento;
            }
        }

        $result = array_merge($result->toArray(), $inhabiles);

        return $result;
    }
}
