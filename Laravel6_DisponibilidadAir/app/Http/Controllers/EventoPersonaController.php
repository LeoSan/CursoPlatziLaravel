<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventoPersonaRequest;
use App\Models\Evento;
use App\Models\EventoPersona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EventoPersonaController extends Controller
{
    /**
     * Aisgnación de eventos
     * @param Request $request
     * @param EventoPersonaRequest $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function asignarEventos(Request $request,EventoPersonaRequest $validator){
        $plataforma_id=getClient($request);
        $validator = $validator->validarAsignacion($request);
        if ( !empty($validator) ) return response()->json($validator, 400);
        $eventos=Evento::where('plataforma_id',$plataforma_id);
        if(isset($request->tipo))
            $eventos->where('tipo',$request->tipo);
        if(isset($request->evento_ids)){
            $eventos=$eventos->whereIn('id',$request->evento_ids)->get();
            $ids=$eventos->pluck('id')->toArray();
        }
        else{
            $eventos=$eventos->whereIn('evento_id',$request->evento_plataforma_ids)->get();
            $ids=$eventos->pluck('id')->toArray();
        }
        if(isset($request->remplazo)&&$request->remplazo==true){
            $eventosAsignados=EventoPersona::whereIn('evento_id',$ids)->get();
            foreach ($eventosAsignados as $eAsignado)
                $eAsignado->delete();
        }
        foreach ($ids as $evento_id){
            foreach ($request->persona_ids as $persona_id)
            EventoPersona::firstOrcreate([
                'evento_id'=>$evento_id,
                'persona_id'=>$persona_id
            ]);
            Evento::find($evento_id)->update(['estatus'=>'asignado']);
        }
        return Response::json(
            "Se asignaron {$eventos->count()} eventos correctamente"
        , 200);
    }
    /**
     * Desasignación de eventos
     * @param Request $request
     * @param EventoPersonaRequest $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function desasignarEventos(Request $request,EventoPersonaRequest $validator){
        $plataforma_id=getClient($request);
        $validator = $validator->validarDesasignacion($request);
        if ( !empty($validator) ) return response()->json($validator, 400);
        $eventos=Evento::where('plataforma_id',$plataforma_id);
        if($request->evento_ids){
            $pluck=$eventos->whereIn('id',$request->evento_ids)->pluck('id')->toArray();
            $registros=EventoPersona::whereIn('evento_id',$pluck)->where('persona_id',$request->persona_id)->get();
            foreach ($registros as $registro){
                $evento=Evento::where('id',$registro->evento_id)->first();
                $evento->update(['estatus'=>'pendiente']);
                $registro->delete();
            }
        }
        else if($request->evento_plataforma_ids){
            $pluck=$eventos->whereIn('evento_id',$request->evento_plataforma_ids)->pluck('id')->toArray();
            $registros=EventoPersona::whereIn('evento_id',$pluck)->where('persona_id',$request->persona_id)->get();
            foreach ($registros as $registro){
                $evento=Evento::where('id',$registro->evento_id)->first();
                $evento->update(['estatus'=>'pendiente']);
                $registro->delete();
            }
        }
        return Response::json(
            "Eventos desasignados correctamente"
            , 200);
    }
}
