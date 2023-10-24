<?php

namespace App\Http\Controllers;

use App\Models\Caso;
use App\Models\TipoInfraccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TipoInfraccionController extends Controller
{
    public function index(Request $request){
        $anios = DB::select("select distinct anio as anio from tipo_infracciones t where t.deleted_at is null order by t.anio asc");
        $filtros = [];
        $infracciones = TipoInfraccion::whereRaw("1=1")
            ->when(isset($request->busqueda) && $request->busqueda!="",function($q) use($request){
                $q->where('concepto','ilike',"%$request->busqueda%");
            })
            ->when(isset($request->anio) && $request->anio!="",function($q) use($request){
                $q->whereAnio($request->anio);
            })
            ->when(isset($request->estatus) && $request->estatus!="",function($q) use($request){
                $q->whereActivo($request->estatus);
            })
            ->when(isset($request->editable) && $request->editable!="",function($q) use($request){
                $q->whereEditable($request->editable);
            })
            ->when($request->minimo && $request->minimo!="",function($q) use($request){
                $monto = str_replace(',','',$request->minimo) ;
                $q->where('monto','>=',$monto);
            })
            ->when($request->maximo && $request->maximo!="",function($q) use($request){
                $monto = str_replace(',','',$request->maximo) ;
                $q->where('monto','<=',$monto);
            })
            ->orderBy('anio')->orderBy('concepto')->paginate(10);

        $filtrado = isset($request->anio) || isset($request->minimo) || isset($request->maximo) || isset($request->estatus) || isset($request->editable) ;
        if($filtrado){
            $filtros =  [
                'anio'=>[
                    'texto'=>"Año:",
                    'valor'=>$request->anio
                ],
                'minimo'=>[
                    'texto'=>'Monto mínimo:',
                    'valor'=> $request->minimo ? "desde L ".$request->minimo : '',
                    'error' => false
                ],
                'maximo'=>[
                    'texto'=>'Monto máximo:',
                    'valor'=> $request->maximo ? "hasta L ".$request->maximo : '',
                    'error' => false
                ],
                'estatus'=>[
                    'texto'=>'Estatus:',
                    'valor'=> isset($request->estatus) ? ($request->estatus==1 ? "Activos" : 'Inactivos') : '',
                    'error' => false
                ],
                'editable'=>[
                    'texto'=>'Editable:',
                    'valor'=> isset($request->editable) ? ($request->editable==1 ? "Sí" : 'No') : '',
                    'error' => false
                ],
            ];
        }
        if(isset($request->minimo) && isset($request->maximo) && $request->minimo!="" && $request->maximo!=""){
            if(floatval(str_replace(',', '', $request->maximo)) < floatval(str_replace(',', '', $request->minimo)))
                $filtros['monto']['error']="El monto mínimo es mayor al monto máximo";
        }
        return view('admin.tipos_infraccion.index',compact('anios','filtros','filtrado','infracciones'));
    }

    public function deshabilitarEliminar(Request $request){
        $tipoInfraccion = TipoInfraccion::findOrFail($request->tipo_id);
        $tipo = (object) $tipoInfraccion->toArray();
        switch ($request->accion){
            case 'deshabilitar':
                $tipoInfraccion->update(['activo'=>false]);
                registroBitacora($tipoInfraccion,A_ACTUALIZAR,C_CATALOGOS,SC_TIPOS_INFRACCION,'Se ha deshabilitado la infracción '.$tipo->concepto. ' del año '.$tipo->anio);
                return redirect()->back()->with('success',"Tipo de infracción deshabilitada correctamente");
                break;
            case 'eliminar':
                if($tipoInfraccion->sanciones->count()>0)
                    return redirect()->back()->with('error',"No es posible eliminar este tipo de infracción, tiene sanciones vinculadas");
                else{
                    $tipoInfraccion->delete();
                    registroBitacora($tipoInfraccion,A_ACTUALIZAR,C_CATALOGOS,SC_TIPOS_INFRACCION,'Se ha eliminado la infracción '.$tipo->concepto. ' del año '.$tipo->anio);
                    return redirect()->back()->with('success',"Tipo de infracción eliminada correctamente");
                }
                break;
            case 'habilitar':
                $tipoInfraccion->update(['activo'=>true]);
                registroBitacora($tipoInfraccion,A_ACTUALIZAR,C_CATALOGOS,SC_TIPOS_INFRACCION,'Se ha habilitado la infracción '.$tipo->concepto. ' del año '.$tipo->anio);
                return redirect()->back()->with('success',"Tipo de infracción habilitada correctamente");
                break;
            default:
                return redirect()->back()->with('error',"No es posible realizar alguna acción");
                break;
        }
    }
    public function create(){
        return view('admin.tipos_infraccion.create');
    }

    public function store(Request $request){
        $rules = [
            'anio' => 'required|numeric|min:2017|max:2050',
            'concepto' => 'required',
            'monto' => 'required',
            'editable' => 'required',
        ];
        $messages = [
            'anio.required' => 'El año del tipo de infracción es requerido.',
            'anio.numeric' => 'El año debe de ser numerico.',
            'anio.min' => 'El año debe de ser mayor a 2017.',
            'anio.max' => 'El año debe de ser mayor a igual o menor a 2050.',
            'concepto.required' => 'El concepto del tipo de infracción es requerido.',
            'monto.required' => 'El monto del tipo de infracción es requerido.',
            'editable.required' => 'El tipo de edición del tipo de infracción es requerido.',
        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        $validator->validate();

        $tipo = TipoInfraccion::updateOrCreate([
           'anio'=>$request->anio,
           'concepto'=>$request->concepto,
           'monto' => str_replace(',','',$request->monto),
           'editable' => intval($request->editable) > 0
        ]);
        registroBitacora($tipo,A_REGISTRAR,C_CATALOGOS,SC_TIPOS_INFRACCION,"Se registró el tipo de infracción {$request->concepto} del año {$request->anio}");
        return redirect()->route('tiposInfraccion.index')->with('success','Tipo de Infracción registrado correctamente');


    }
}
