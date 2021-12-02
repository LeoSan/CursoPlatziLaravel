<?php

namespace App\Services;

use App\Models\Evento;
use App\Models\Inhabil;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Log;

class DisponibilidadPersonas
{
    /**
     * Consulta de disponibilidad de personas
     */
    public function fechasDisponibles($atributos, $plataforma_id)
    {
        $disponibilidad = []; $disponibles = []; $no_disponibles = [];

        $eventos=Evento::where('plataforma_id',$plataforma_id)
            ->whereBetween('fecha',[$atributos['fecha_inicio'], $atributos['fecha_fin']])
            ->whereHas('eventoPersonas', function($q) use($atributos) {
                $q->where('persona_id',$atributos['persona_id']);
            })->groupBy('fecha')->pluck('fecha')
            ->map(function ($model) {
                return date('Y-m-d', strtotime($model));
            })->toArray();

        $no_habil = Inhabil::where("plataforma_id", $plataforma_id)  
            ->whereBetween('fecha',[$atributos['fecha_inicio'], $atributos['fecha_fin']]) 
            ->where(function($query) use($atributos){
                return $query->where('persona_id', $atributos['persona_id'])
                    ->orWhereNull('persona_id');
            })
            ->groupBy('fecha')->pluck('fecha')
            ->map(function ($model) {
                return date('Y-m-d', strtotime($model));
            })->toArray();

        $noDisponibles = array_merge($eventos, $no_habil);

        $periodo = CarbonPeriod::create($atributos['fecha_inicio'], $atributos['fecha_fin']);
        foreach ($periodo as $fecha) {
            $disponibilidad[$fecha->format('Y-m-d')]=!in_array($fecha->format('Y-m-d'), $noDisponibles);
            if(!in_array($fecha->format('Y-m-d'), $noDisponibles)) array_push($disponibles, $fecha->format('Y-m-d'));
            if(in_array($fecha->format('Y-m-d'), $noDisponibles)) array_push($no_disponibles, $fecha->format('Y-m-d'));
        }

        return [
            'disponibilidad' => $disponibilidad,
            'no_disponibles' => [
                'total' => count($no_disponibles),
                'fechas' => $no_disponibles
            ],
            'disponibles' => [
                'total' => count($disponibles),
                'fechas' => $disponibles
            ]
        ];
    }
}
