<?php

namespace App\Http\Controllers;

use App\Models\{CatalogoElemento, TipoInfraccion, Catalogo, User, PlaneacionAuditoria};
use Illuminate\Http\Request;
use NumberFormatter;
use Illuminate\Support\Facades\{Log, DB, Response};
use App\Services\DenunciasService;

class ApiController extends Controller
{

    private $message_error = "Error en la petición";
    private $message_success = "Proceso exitoso.";

    public function getMunicipiosByDepartamentoId(Request $request){
        if (!$request->ajax()) {
            return Response::json([
                'mensaje' => 'Error en la petición'
            ], 404);
        }
        $parent_id = CatalogoElemento::find($request->departamento_id)->first()->id;
        $municipios = CatalogoElemento::where('parent_id',$request->departamento_id)->orderBy('orden')->get(['id','nombre','codigo']);
        $html="<option value=''>Selecciona el municipio</option>";
        foreach ($municipios as $i){
            $html.="<option value='{$i->id}' data-codigo='{$i->codigo}'>{$i->nombre}</option>";
        }
        return Response::json([
            'id'=>$parent_id,
            'html'=>$html
        ]);
    }
    public function getOficinaRegionalByMunicipiosId(Request $request){
        if (!$request->ajax()) {
            return Response::json([
                'mensaje' => 'Error en la petición'
            ], 404);
        }
        $cata_munucipio_id = Catalogo::whereCodigo('municipios')->first()->id;
        $oficina_regional = DB::select('SELECT reg.id, reg.nombre region, reg.codigo region_codigo FROM catalogo_elementos mun LEFT JOIN catalogo_elementos reg ON mun.categoria_id = reg.id  WHERE mun.catalogo_id = '.$cata_munucipio_id.'  AND mun.id = ?', [$request->municipio_id]);

        $html="<option selected value='{$oficina_regional[0]->id}' data-codigo='{$oficina_regional[0]->region_codigo}'>{$oficina_regional[0]->region}</option>";
        

        $auditor = User::where('regional_id', $oficina_regional[0]->id)->permission('auditorias_ejecucion')->first();

        return Response::json([
            'id'=>$request->municipio_id,
            'region'=>$oficina_regional[0]->id,
            'auditor'=>$auditor ? $auditor->id : '',
            'html'=>$html
        ]);
    }
    public function getOficinaRegionalIdByMunicipiosId(Request $request){
        if (!$request->ajax()) {
            return Response::json([
                'mensaje' => 'Error en la petición'
            ], 404);
        }
        $cata_munucipio_id = Catalogo::whereCodigo('municipios')->first()->id;
        $oficina_regional = DB::select('SELECT reg.id, reg.nombre region, reg.codigo region_codigo FROM catalogo_elementos mun LEFT JOIN catalogo_elementos reg ON mun.categoria_id = reg.id  WHERE mun.catalogo_id = '.$cata_munucipio_id.'  AND mun.id = ?', [$request->municipio_id]);

        $html="<option selected value='{$oficina_regional[0]->id}' data-codigo='{$oficina_regional[0]->region_codigo}'>{$oficina_regional[0]->region}</option>";

        return Response::json([
            'id'=>$request->municipio_id,
            'html'=>$html
        ]);
    }
    public function getInfraccionesByAnio(Request $request){
        if (!$request->ajax()) {
            return Response::json([
                'mensaje' => 'Error en la petición'
            ], 404);
        }
        $infracciones = TipoInfraccion::whereAnio($request->anio)->whereActivo(true)->orderBy('concepto')->get();
        $html="<option value=''>Selecciona la infracción</option>";
        $amount = new NumberFormatter("es_HN", NumberFormatter::CURRENCY);
        $amount->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
        foreach ($infracciones as $i){
            $monto = $amount->format($i->monto);
            $html.="<option value='{$i->id}' data-concepto='{$i->concepto}' data-monto='$monto' data-editable='".($i->editable?1:0)."'  >{$i->concepto}</option>";
        }
        return Response::json([
            'html'=>$html
        ]);
    }
    public function sendDataDenuncia(Request $request){

        if (!$request->ajax()) {
            return Response::json([
                'message' => $this->message_error,
                'error' =>  'Error Ajax',
            ], 203);
        }
        try {
            $servi_denuncia = new DenunciasService();
            $result = $servi_denuncia->guardarDenuncia( $request );
           
            if ($result['status'] == 203 ){
                return Response::json([
                    'message' => 'Error por validación',
                    'error'   =>  $result['message'],
                ], 203);
            }else{
                return Response::json([
                    'message' => $this->message_success,
                    'folio'   =>  $result['folio'],
                ], 201);
            }
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            $error_exception = "Error try exception";
            return Response::json([
                'message' => $this->message_error,
                'error' =>  $error_exception,
            ], 404);
        }
    }

    public function obtenerSolicitudRegionMes(Request $request){
        if (!$request->ajax()) {
            return Response::json([
                'mensaje' => 'Error en la petición'
            ], 404);
        }
        $html=" ";
        $usuario = User::findOrFail($request->valor);
        if($usuario->roles()->first()->name == 'jefe_auditoria_setrass_ati'){
            $datos = PlaneacionAuditoria::with('ejecuciones')->when($request->regional,  function($query)use($request){
                $query->where('region_id',$request->regional);
            })->whereHas('ejecuciones',function($query)use($request){
                
                $query->when($request->mes, function($query)use($request){
                    $query->where('mes',$request->mes)->where('estatus_id', $request->estatus);
                });
            })->get();
        }else{
            $datos = PlaneacionAuditoria::with('ejecuciones')->when($request->regional,  function($query)use($request){
                $query->where('region_id',$request->regional);
            })->whereHas('ejecuciones',function($query)use($request){
                $query->when($request->mes, function($query)use($request){
                    $query->where('mes',$request->mes)->where('estatus_id', $request->estatus);
                });
            })->where('auditor_responsable_id', $usuario->id)->get();
        }
        $sum = 0;
        if (count($datos)){
            foreach ($datos as $i){
                $sum = $sum + $i->ejecuciones->where('mes', $request->mes)->count();
                $html.="<tr>
                        <td class='align-middle'>{$i->inspeccion->nombre}</td>
                        <td class='align-middle'>{$i->actividadeconomica->nombre}</td>
                        <td class='align-middle'>{$i->cafta}</td>
                        <td class='align-middle'>{$i->ejecuciones->where('mes', $request->mes)->count() }</td>
                    </tr>
                    ";
            }
            $is_solicitud = true;
            $html.="<span id='spanTotalExpdiente' class='opacity-0'> {$sum} </span>"; 
        }else{
            $html.="<tr>
                        <td colspan='4' class='bg-white border-0'>
                            Sin resultados encontrados
                        </td>
                </tr>";
            $is_solicitud = false;
        }
        return Response::json([
            'html'=>$html,
            'is_solicitud' => $is_solicitud, 
        ]);
    }

    public function obtenerJefeRegional(Request $request){
        if (!$request->ajax()) {
            return Response::json([
                'mensaje' => 'Error en la petición'
            ], 404);
        }

        $jefe_regional = User::select('id', 'complete_name', 'email')->where('cargo', 'Jefe Regional')->where('regional_id', $request->regional_id)->first(); 
        $inp_id     =  isset($jefe_regional->id)?$jefe_regional->id:0;   
        $inp_nombre =  isset($jefe_regional->complete_name)? $jefe_regional->complete_name : 'No existe auditor para esta regional';   
        $inp_email  =  isset($jefe_regional->email)? $jefe_regional->email : 'No existe auditor para esta regional';  
        return Response::json([
            'datos'=>['inp_nombre'=>$inp_nombre, 'inp_email'=>$inp_email,'inp_id'=>$inp_id]
        ]);
    }    
}
