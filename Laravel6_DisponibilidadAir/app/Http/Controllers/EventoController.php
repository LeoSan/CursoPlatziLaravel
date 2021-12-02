<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventoRequest;
use App\Models\Evento;
use App\Models\EventoPersona;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Services\Eventos;

class EventoController extends Controller
{
    /**
     * Registro de eventos
     * @param Request $request
     * @param EventoRequest $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeEventos(Request $request, EventoRequest $validator)
    {
        $validator = $validator->validarRegistro($request);
        if ( !empty($validator) ) return response()->json($validator, 400);
        $i=0;$asignados=0;
        $plataforma_id = getClient($request);
        foreach ($request->eventos as $evento){
            $create=Evento::where('plataforma_id',$plataforma_id)
                ->where('evento_id',$evento['id'])->first();
            if(!$create){
                $create=Evento::create([
                    'evento_id'=>@$evento['id'],
                    'titulo'=>$evento['titulo'],
                    'tipo'=>$evento['tipo'],
                    'fecha'=>$evento['fecha'],
                    'codigo_estado'=>$evento['codigo_estado'],
                    'municipio_alcaldia'=>$evento['municipio_alcaldia'],
                    'referencia'=>$evento['referencia'],
                    'referencia_id'=>$evento['referencia_id'],
                    'plataforma_id'=>$plataforma_id,
                    'latitud'=>@$evento['latitud'],
                    'longitud'=>@$evento['longitud']
                ]);
            }

            if(isset($evento['persona_ids'])){
                foreach ($evento['persona_ids'] as $persona_id){
                    EventoPersona::firstOrCreate([
                        'persona_id'=>$persona_id,
                        'evento_id'=>$create->id
                    ]);
                    $create->update(['estatus'=>'asignado']);
                }
                $asignados++;
            }
            $i++;
        }
        return Response::json("Se crearon {$i} y asignaron {$asignados}  eventos correctamente", 200);
    }
    /**
     * Consulta de eventos de un periodo, agrupados por persona
     * @param Request $request
     * @param EventoRequest $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventoPersonas(Request $request,EventoRequest $validator){
        $plataforma_id = getClient($request);
        $result=[];
        $validator = $validator->validarConsulta($request);
        if ( !empty($validator) ) return response()->json($validator, 400);
        $personas=$request->persona_ids??EventoPersona::orderBy('persona_id')->groupBy('persona_id')->pluck('persona_id');
        $con_actividad=0;$sin_actividad=0;
        foreach ($personas as $id_persona){
            $e=Evento::where('plataforma_id',$plataforma_id)->whereBetween('fecha',[$request->fecha_inicio,$request->fecha_fin])
                ->whereHas('eventoPersonas', function($q) use($id_persona) {
                    $q->where('persona_id',$id_persona);
                });
            if(isset($request->codigo_estado))
                $e->where('codigo_estado',$request->codigo_estado);
            $e=$e->get();
            if(count($e)){
                $con_actividad++;
                $result['con_actividad']['total']=$con_actividad;
                $result['con_actividad']['personas'][$id_persona]['persona_id']=$id_persona;
                $result['con_actividad']['personas'][$id_persona]['eventos']=$e;
            }else{
                $sin_actividad++;
                $result['sin_actividad']['total']=$sin_actividad;
                $result['sin_actividad']['personas'][$id_persona]=$id_persona;
            }
        }
        return Response::json($result, 200);
    }
    /**
     * Consulta de eventos de un periodo
     * @param Request $request
     * @param EventoRequest $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventos(Request $request,EventoRequest $validator){
        $plataforma_id = getClient($request);
        $validator = $validator->validarConsulta($request);
        if ( !empty($validator) ) return response()->json($validator, 400);
        
        $disponibilidad = new Eventos;
        $result = $disponibilidad->agendados($request->all(), $plataforma_id);

        return Response::json($result, 200);
    }
    /**
     * Consulta de un evento por referencia y referencia_id
     * @param Request $request
     * @param EventoRequest $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReferencia(Request $request,EventoRequest $validator){
        $plataforma_id = getClient($request);
        $validator = $validator->validarConsultaReferencia($request);
        if ( !empty($validator) ) return response()->json($validator, 400);
        $eventos=Evento::where('plataforma_id',$plataforma_id)
            ->where("referencia",$request->referencia)
            ->where("referencia_id",$request->referencia_id)->get();
        foreach ($eventos as $evento) {
            $evento?$evento['personas']=EventoPersona::where('evento_id',$evento->id)->pluck('persona_id'):$evento['personas']=[];
        }
        return Response::json($eventos, 200);
    }
    /**
     * Consulta de un evento por referencia y referencia_id
     * @param Request $request
     * @param EventoRequest $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvento(Request $request,EventoRequest $validator){
        $plataforma_id = getClient($request);
        $validator = $validator->validarConsultaEvento($request);
        if ( !empty($validator) ) return response()->json($validator, 400);
        $e=Evento::where('plataforma_id',$plataforma_id)
            ->where("evento_id",$request->id)->first();
        $e?$e['personas']=EventoPersona::where('evento_id',$e->id)->pluck('persona_id'):$e['personas']=[];
        return Response::json($e, 200);
    }
}
