<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;

class PlantillaController extends Controller
{
    public function index(){
        return view('admin.plantillas.index');
    }
    public function create(Plantilla $plantilla){
        $itemsbread = [
            ['nombreComponente' => 'ATI',  'ruta'=> '#', 'value'=>''],
            ['nombreComponente' => 'Plantillas',  'ruta'=> route('plantillas.index'), 'value'=>''],
            ['nombreComponente' => isset($plantilla->id)?$plantilla->nombre:'Crear plantilla',  'ruta'=> route('plantillas.create',@$plantilla->id), 'value'=>'active']
        ];
        return view('admin.plantillas.create',compact('plantilla','itemsbread'));
    }
    public function store(Request $request){
        if(isset($request->plantilla_id)){
            $plantilla = Plantilla::find($request->plantilla_id)->update([
               'nombre'=>$request->nombre,
               'seccion_id'=>$request->seccion_id,
               'contenido'=>$request->contenido
            ]);
            registroBitacora($plantilla,A_ACTUALIZAR,C_PLANTILLAS,null,"Se actualizó la información de la plantilla $request->nombre");
            return redirect()->route('plantillas.create',$request->plantilla_id)->with('success','Información actualizada correctamente');
        }else{
            $plantilla = Plantilla::updateOrCreate([
                'nombre'=>$request->nombre,
                'seccion_id'=>$request->seccion_id,
                'contenido'=>$request->contenido
            ]);
            registroBitacora($plantilla,A_ACTUALIZAR,C_PLANTILLAS,null,"Se creó la plantilla $request->nombre");
            return redirect()->route('plantillas.create',$plantilla->id)->with('success','Plantilla creada correctamente');
        }
    }
    public function destroy(Request $request){
        $plantilla = Plantilla::findOrFail($request->id);
        registroBitacora($plantilla,A_ELIMINAR,C_PLANTILLAS,null,"Se eliminó la plantilla $plantilla->nombre");
        $plantilla->delete();
        return redirect()->route('plantillas.index')->with('success','Plantilla eliminada correctamente');
    }
    public function descargarPdf(Plantilla $plantilla)
    {
        if (!$plantilla) {
            abort(404);
        }
        $contenidoHTML = $plantilla->contenido;
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($contenidoHTML);
        return $pdf->download($plantilla->nombre.".pdf");
    }
    public function descargarDoc(Plantilla $plantilla)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        Html::addHtml($section, $plantilla->contenido, false, false);
        header("Content-type: application/vnd.ms-word");
        header('Content-Disposition: attachment; filename=' . "$plantilla->nombre.docx");
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
    }
}
