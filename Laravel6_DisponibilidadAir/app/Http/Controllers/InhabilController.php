<?php

namespace App\Http\Controllers;

use App\Models\Inhabil;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

use App\Services\InhabilServicio;
use App\Http\Controllers\Controller;
use App\Http\Requests\InhabilRequest;
use Illuminate\Support\Facades\Response;

class InhabilController extends Controller
{
    /**
     * Registra un día inhabil
     * @param Request $request
     * @param InhabilRequest $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request,InhabilRequest $validator){
        $plataforma_id = getClient($request);
        $validator = $validator->validarRegistro($request);
        if ( !empty($validator) ) return response()->json($validator, 400);
        if(isset($request->fecha_inicio)){
            $periodo = CarbonPeriod::create($request->fecha_inicio, $request->fecha_fin);
            foreach ($periodo as $fecha) {
                Inhabil::create([
                    'fecha'=>$fecha,
                    'descripcion'=>@$request->descripcion,
                    'plataforma_id'=>$plataforma_id,
                    'persona_id'=>@$request->persona_id
                ]);
            }
            return Response::json(
                (count($periodo)>1?"Periodo":"Día")." inhabil creado correctamente"
            , 200);
        }
        else if(isset($request->fechas)){
            foreach ($request->fechas as $fecha) {
                Inhabil::create([
                    'fecha'=>$fecha,
                    'descripcion'=>@$request->descripcion,
                    'plataforma_id'=>$plataforma_id,
                    'persona_id'=>@$request->persona_id
                ]);
            }
            return Response::json(
                "Fechas inhabiles creadas correctamente"
            , 200);
        }
    }
    /**
     * Elimina un día inhabil
     * @param Request $request
     * @param InhabilRequest $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request,InhabilRequest $validator)
    {
        $validator = $validator->validarRegistro($request);
        if ( !empty($validator) ) return response()->json($validator, 400);

        $plataforma_id = getClient($request);
        if(isset($request->fecha_inicio)){
            $periodo = CarbonPeriod::create($request->fecha_inicio, $request->fecha_fin);
            foreach ($periodo as $fecha) {
                $f=Inhabil::whereFecha($fecha)->where('plataforma_id',$plataforma_id);
                if(isset($request->persona_id))
                    $f=$f->where('persona_id',$request->persona_id)->first();
                else
                    $f=$f->where('persona_id',null)->first();
                if($f)$f->delete();
            }
            return Response::json((count($periodo)>1?"Periodo":"Día")." inhabil eliminado correctamente", 200);
        }
        else if(isset($request->fechas)){
            foreach ($request->fechas as $fecha) {
                $f=Inhabil::whereFecha($fecha)->where('plataforma_id',$plataforma_id);
                if(isset($request->persona_id))
                    $f=$f->where('persona_id',$request->persona_id);
                else
                    $f=$f->where('persona_id',null);
                $f->first();
                if($f)$f->delete();
            }
            return Response::json("Fechas inhabiles eliminadas correctamente", 200);
        }else if(isset($request->inhabil_id)){
            $inhabil=Inhabil::where('id',$request->inhabil_id);
            $inhabil->delete();
            return Response::json("Fecha inhabil eliminada correctamente", 200);
        }
    }
    
    /*
     * Editar día inhabil
     */
    public function update(Request $request, InhabilRequest $validator)
    {
        $validator = $validator->validarEdicion($request);
        if ( !empty($validator) ) return response()->json($validator, 400);

        $descripcion = $request['descripcion'] ?? '';
        $persona_id = $request['persona_id'] ?? NULL;
        $plataforma_id = getClient($request);

        Inhabil::whereId($request->inhabil_id)
            ->update([
                'fecha' => $request->fecha,
                'descripcion' => $descripcion,
                'persona_id' => $persona_id,
                'plataforma_id' => $plataforma_id
            ]);

        return Response::json("Día inhabil actualizado correctamente", 200);
    }

    /**
     * Consultar Por Persona  Dia No Habiles
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @param InhabilRequest $validator
     */    
    public function getPersonaIdDiasInhabiles(Request $request, InhabilRequest $validator)
    {
        $plataforma_id = getClient($request);
        $request->merge(['plataforma_id' => $plataforma_id]);
        
        $validator = $validator->validarConsultaPersona($request);
        if ( !empty($validator) ) return response()->json($validator, 400);

        $services = new InhabilServicio();
        $inhabil = $services->consultarPersonaIdDiasInhabiles($request);
    
        return response()->json($inhabil,  200);
    }  

    /**
     * Consulta un días inhabiles
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function consultar(Request $request)
    {
        $plataforma_id = getClient($request);
        $request->merge(['plataforma_id' => $plataforma_id]);

        $services = new InhabilServicio();
        $inhabil = $services->consultarDiasInhabiles($request);
    
        return response()->json($inhabil,  200);
    }    
}
