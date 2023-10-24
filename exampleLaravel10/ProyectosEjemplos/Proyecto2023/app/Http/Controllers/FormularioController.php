<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CatalogoElemento;
use App\Models\Formulario;
use App\Models\FormularioSeccion;
use App\Models\FormularioSeccionPregunta;
use Illuminate\Http\Request;

class FormularioController extends Controller
{
    public function index(){
        return view('admin.formularios.index');
    }

    public function create(Formulario $formulario){
        $itemsbread = [
            ['nombreComponente' => 'Formularios',  'ruta'=> route('formularios.index'), 'value'=>''],
            ['nombreComponente' => isset($formulario->id)?$formulario->nombre:'Crear formulario',  'ruta'=> route('formularios.create',@$formulario->id), 'value'=>'active']
        ];
        $formularioActivo = Formulario::whereHas('estatus',function($q){$q->whereCodigo('formulario_activo');})
            ->whereTipoInspeccionId(@$formulario->tipo_inspeccion_id)
            ->first();
        return view('admin.formularios.create',compact('formulario','itemsbread','formularioActivo'));
    }

    public function store(Request $request){
        if(isset($request->formulario_id)){
            $formulario = Formulario::find($request->formulario_id)->update([
                'nombre'=>$request->nombre,
                'tipo_inspeccion_id'=>$request->tipo_inspeccion_id
            ]);
            registroBitacora($formulario,A_ACTUALIZAR,C_FORMULARIOS,null,"Se actualizó la información del formulario $request->nombre");
            return redirect()->route('formularios.create',$request->formulario_id)->with('success','Información actualizada correctamente');
        }else{
            $estatusBorrador = CatalogoElemento::whereCodigo('formulario_borrador')->first()->id;
            $formulario = Formulario::updateOrCreate([
                'nombre'=>$request->nombre,
                'tipo_inspeccion_id'=>$request->tipo_inspeccion_id,
                'estatus_id'=>$estatusBorrador
            ]);
            registroBitacora($formulario,A_REGISTRAR,C_FORMULARIOS,null,"Se creó el formulario $request->nombre");
            return redirect()->route('formularios.create',$formulario->id)->with('success','Formulario creado correctamente');
        }
    }

    public function destroy(Request $request){
        $formulario = Formulario::find($request->formulario_id);
        $formulario->preguntas()->delete();
        $formulario->secciones()->delete();
        registroBitacora($formulario,A_ELIMINAR,C_FORMULARIOS,null,"Se eliminó el formulario ".$formulario->nombre);
        $formulario->delete();
        return redirect()->route('formularios.index')->with('success','Formulario eliminado correctamente');
    }

    public function storeSeccion(Request $request){
        if(isset($request->seccion_id)){
            $seccion = FormularioSeccion::find($request->seccion_id);
            $seccion->update([
                'nombre'=>$request->nombre,
                'formulario_id'=>$request->formulario_id
            ]);
            registroBitacora($seccion,A_ACTUALIZAR,C_FORMULARIOS,null,"Se actualizó la sección $request->nombre del formulario ".$seccion->formulario->nombre);
            return redirect()->route('formularios.create',[$seccion->formulario_id,'seccion_id'=>$seccion->id])->with('success','Sección actualizada correctamente');
        }else{
            $seccion = FormularioSeccion::updateOrCreate([
                'nombre'=>$request->nombre,
                'formulario_id'=>$request->formulario_id
            ]);
            registroBitacora($seccion,A_REGISTRAR,C_FORMULARIOS,null,"Se creó la sección $request->nombre del formulario ".$seccion->formulario->nombre);
            return redirect()->route('formularios.create',[$seccion->formulario_id,'seccion_id'=>$seccion->id])->with('success','Sección creada correctamente');
        }
    }

    public function destroySeccion(Request $request){
            $seccion = FormularioSeccion::find($request->seccion_id);
            $seccion->preguntas()->delete();
            registroBitacora($seccion,A_ELIMINAR,C_FORMULARIOS,null,"Se eliminó la sección $seccion->nombre del formulario ".$seccion->formulario->nombre);
            $seccion->delete();
            return redirect()->route('formularios.create',[$seccion->formulario_id])->with('success','Sección eliminada correctamente');
    }

    public function storePregunta(Request $request){
        if(isset($request->pregunta_id)){
            $pregunta = FormularioSeccionPregunta::find($request->pregunta_id);
            $pregunta->update([
                'pregunta'=>$request->pregunta,
                'descripcion'=>$request->descripcion,
                'seccion_id'=>$request->seccion_id,
                'formulario_id'=>$request->formulario_id
            ]);
            registroBitacora($pregunta,A_ACTUALIZAR,C_FORMULARIOS,null,"Se actualizó la pregunta con id $pregunta->id de la sección ".$pregunta->seccion->nombre." del formulario ".$pregunta->formulario->nombre);
            return redirect()->route('formularios.create',[$pregunta->formulario_id,'seccion_id'=>$pregunta->seccion_id])->with('success','Pregunta actualizada correctamente');
        }else{
            $pregunta = FormularioSeccionPregunta::updateOrCreate([
                'pregunta'=>$request->pregunta,
                'descripcion'=>$request->descripcion,
                'seccion_id'=>$request->seccion_id,
                'formulario_id'=>$request->formulario_id
            ]);
            registroBitacora($pregunta,A_REGISTRAR,C_FORMULARIOS,null,"Se creó una pregunta  con id $pregunta->id de la sección ".$pregunta->seccion->nombre." del formulario ".$pregunta->formulario->nombre);
            return redirect()->route('formularios.create',[$pregunta->formulario_id,'seccion_id'=>$pregunta->seccion_id])->with('success','Pregunta creada correctamente');
        }
    }

    public function destroyPregunta(Request $request){
        $pregunta = FormularioSeccionPregunta::find($request->pregunta_id);
        registroBitacora($pregunta,A_ELIMINAR,C_FORMULARIOS,null,"Se eliminó la pregunta de id $pregunta->id de la sección ".$pregunta->seccion->nombre." del formulario ".$pregunta->formulario->nombre);
        $pregunta->delete();
        return redirect()->route('formularios.create',[$pregunta->formulario_id,'seccion_id'=>$pregunta->seccion_id])->with('success','Pregunta eliminada correctamente');
    }

    public function activar(Formulario $formulario){

        $estatusHistorico = CatalogoElemento::whereCodigo('formulario_historico')->first()->id;
        $estatusActivo = CatalogoElemento::whereCodigo('formulario_activo')->first()->id;
        $formularioActivo = Formulario::whereHas('estatus',function($q){$q->whereCodigo('formulario_activo');})
            ->whereTipoInspeccionId(@$formulario->tipo_inspeccion_id)
            ->first();
        if(isset($formularioActivo->id)){
            $formularioActivo->update(['estatus_id'=>$estatusHistorico]);
            registroBitacora($formulario,A_ACTUALIZAR,C_FORMULARIOS,null,"Se manda a histórico el formulario ".$formularioActivo->nombre);
        }
        $formulario->update(['estatus_id'=>$estatusActivo]);
        registroBitacora($formulario,A_ACTUALIZAR,C_FORMULARIOS,null,"Se activó el formulario ".$formulario->nombre);

        return redirect()->route('formularios.create',[$formulario->id])->with('success','Formulario activado correctamente');
    }
}
