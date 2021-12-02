<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonaRequest;
use App\Models\Evento;
use App\Models\EventoPersona;
use App\Models\Inhabil;
use App\Models\Persona;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Services\DisponibilidadPersonas;

class PersonaController extends Controller
{
    /**
     * Consulta de disponibilidad
     * @param Request $request
     * @param PersonaRequest $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function disponibilidad(Request $request,PersonaRequest $validator)
    {
        $plataforma_id=getClient($request);
        $validator = $validator->validarConsultaDisponibilidad($request);
        if ( !empty($validator) ) return response()->json($validator, 400);

        $disponibilidad = new DisponibilidadPersonas;
        $disponibles = $disponibilidad->fechasDisponibles($request->all(), $plataforma_id);

        return Response::json($disponibles, 200);
    }

    /**
     * Consulta de personas por rango de fechas y/o zona geográfica
     * @param Request $request
     * @param PersonaRequest $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function consulta(Request $request,PersonaRequest $validator){
        $plataforma_id=getClient($request);
        $validator = $validator->validarConsultaPersonas($request);
        if ( !empty($validator) ) return response()->json($validator, 400);
        foreach ($request->fechas as $fecha){
            $result[$fecha]['disponibles']=[];
            $result[$fecha]['asignados']=[];
            foreach ($request->persona_ids as $index=>$id_persona){
                $eventos=Evento::where('plataforma_id',$plataforma_id)->where('fecha',$fecha)
                    ->whereHas('eventoPersonas', function($q) use($id_persona) {
                        $q->where('persona_id',$id_persona);
                    });
                $inhabil=Inhabil::where('plataforma_id',$plataforma_id)->where('fecha',$fecha)
                    ->where(function($query) use($id_persona){
                        return $query->where('persona_id', $id_persona)
                            ->orWhereNull('persona_id');
                    });

                if(isset($request->codigo_estado)&&$request->codigo_estado!="")
                    $eventos->where('codigo_estado',$request->codigo_estado);

                if(!$eventos->count() && !$inhabil->count()){
                    $result[$fecha]['disponibles'][]=$id_persona;
                }else{
                    $result[$fecha]['asignados'][]=$id_persona;
                }
            }
        }
        return Response::json($result, 200);
    }
    /**
     * Consulta de personas por fecha y/o zona geográfica
     * @param Request $request
     * @param PersonaRequest $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function consultaFechaZona(Request $request,PersonaRequest $validator){
        $plataforma_id=getClient($request);
        $validator = $validator->validarFechaZona($request);
        if ( !empty($validator) ) return response()->json($validator, 400);
        $result['disponibles']=[];$result['asignados']=[];
        foreach ($request->persona_ids as $index=>$id_persona){
            $eventos=Evento::where('plataforma_id',$plataforma_id)
                ->where('fecha',$request->fecha)
                ->whereHas('eventoPersonas', function($q) use($id_persona) {
                    $q->where('persona_id',$id_persona);
                });
            if(isset($request->codigo_estado)&&$request->codigo_estado!="")
                $eventos->where('codigo_estado',$request->codigo_estado);
            $eventos=$eventos->get();
            if(!$eventos->count()){
                $result['disponibles'][]=$id_persona;
            }else{
                $result['asignados'][]=$id_persona;
            }
        }
        return Response::json($result, 200);
    }

    public function consultaPeriodoZonas(Request $request,PersonaRequest $validator){
        $plataforma_id=getClient($request);



        $result=[];
        $validator = $validator->validarPeriodoZonas($request);
        if ( !empty($validator) ) return response()->json($validator, 400);
        $periodo = CarbonPeriod::create($request->fecha_inicio, $request->fecha_fin);
        foreach ($periodo as $fecha){
            $disponibilidad=[];
            if(isset($request->codigo_estados)){
                foreach ($request->codigo_estados as $codigo){
                    $eventos=Evento::where('plataforma_id',$plataforma_id)
                        ->where('fecha',$fecha)->where('codigo_estado',$codigo);
                    $eventos=$eventos->pluck('id')->toArray();
                    $personasAsignadas=EventoPersona::whereIn('evento_id',$eventos)->pluck('persona_id')->toArray();
                    foreach ($request->personas[$codigo] as $persona_id){
                        $no_habil = Inhabil::where("plataforma_id", $plataforma_id)
                            ->where('fecha',$fecha)
                            ->where(function($query) use($persona_id){
                            return $query->where('persona_id', $persona_id)
                                ->orWhereNull('persona_id');
                        });
                        if(!$no_habil->count()){
                            if(in_array($persona_id,$personasAsignadas)){
                                $disponibilidad['asignados'][]=$persona_id;
                            }else if($persona_id!=0){
                                $disponibilidad['disponibles'][]=$persona_id;
                            }
                        }

                    }
                }
            }else{
                $eventos=Evento::where('plataforma_id',$plataforma_id)
                    ->where('fecha',$fecha);
                $eventos=$eventos->pluck('id')->toArray();
                $personasAsignadas=EventoPersona::whereIn('evento_id',$eventos)->pluck('persona_id')->toArray();

                foreach ($request->personas as $persona_id){
                    $no_habil = Inhabil::where("plataforma_id", $plataforma_id)
                        ->where('fecha',$fecha)
                        ->where(function($query) use($persona_id){
                            return $query->where('persona_id', $persona_id)
                                ->orWhereNull('persona_id');
                        });
                    if(!$no_habil->count()){
                        if(in_array($persona_id,$personasAsignadas)){
                            $disponibilidad['asignados'][]=$persona_id;
                        }else if($persona_id!=0){
                            $disponibilidad['disponibles'][]=$persona_id;
                        }
                    }
                }
            }
            $result[$fecha->format("Y-m-d")]['disponibles']=$disponibilidad['disponibles']??[];
            $result[$fecha->format("Y-m-d")]['asignados']=$disponibilidad['asignados']??[];

        }
        return Response::json($result, 200);
    }

}
