<?php

namespace App\Http\Controllers;

use App\Models\Catalogo;
use App\Models\CatalogoElemento;
use App\Models\Documento;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArchivosController extends Controller
{
    public static function storeSimple(Request $request, $codigo, $tipo_entidad, $entidad_id, $dependencia_id = null, $oficio = null, $expediente = null)
    {
        $archivo = $request->file('documento_archivo_'. $codigo);
        $mimes = $request->input('accept_'. $codigo);
        $catalogo = Catalogo::where('codigo', 'documentos')->first();
        $tipo_documento = $catalogo->elementos->where('codigo', $codigo)->first();
        if ($archivo){
            // Guardar el archivo en la carpeta 'archivos' dentro de la carpeta 'storage'
            $rules = [
                "documento_archivo_$codigo" => "mimes:".$mimes, // Agrega las extensiones permitidas aquí
            ];
            $validator = Validator::make($request->all(), $rules);
            if ( ! $validator->fails()) {

                $rutaArchivo = $archivo->store("archivos/$dependencia_id/$tipo_entidad/$entidad_id/$tipo_documento->codigo");
                $pesoArchivo = round($archivo->getSize() / 1024, 2);
                // Guardar el registro en la base de datos
                $datosArchivo = [
                    'dependencia_id' => $dependencia_id,
                    'ruta' => $rutaArchivo,
                    'nombre' => $archivo->getClientOriginalName(),
                    'descripcion' => $tipo_documento ? $tipo_documento->nombre : '',
                    'fecha_recepcion' => date('Y-m-d'),
                    'num_oficio' => $oficio,
                    'num_expediente' => $expediente,
                    'extension' => $archivo->extension(),
                    'peso' => $pesoArchivo . ' KB',
                ];

                $existente = Documento::whereTipoEntidad($tipo_entidad)->whereEntidadId($entidad_id)->whereTipoDocumentoId($tipo_documento->id)->first();
                if(isset($existente->id)){
                    $accion = A_ACTUALIZAR;
                    $descripcionBitacora = "Se actualiza el documento $tipo_documento->nombre de la entidad $tipo_entidad y entidad_id $entidad_id";
                }else{
                    $accion = A_REGISTRAR;
                    $descripcionBitacora = "Se registra el documento $tipo_documento->nombre de la entidad $tipo_entidad y entidad_id $entidad_id";
                }

                $documento = Documento::updateOrCreate([
                    'tipo_entidad' => $tipo_entidad,
                    'entidad_id' => $entidad_id,
                    'tipo_documento_id' => $tipo_documento->id,
                ], $datosArchivo);

                registroBitacora($documento,$accion,C_DOCUMENTOS,null,$descripcionBitacora,$datosArchivo);

                return $documento;
            }
            return false;
        }
        return Documento::where('tipo_entidad',$tipo_entidad)->where('entidad_id',$entidad_id)->where('tipo_documento_id',$tipo_documento->id)->first();
    }


    public static function storeMultiple(Request $request, $codigo, $tipo_entidad, $entidad_id, $dependencia_id = null, $oficio = null, $expediente = null)
    {
        $archivos = $request->file('documentos_archivos_'. $codigo);
        $mimes = $request->input('accept_'. $codigo);

        if($archivos){
            $descripciones = $request->input('documentos_textos_'. $codigo);
            $carga = [];

            foreach ($archivos as $key => $archivo) {

                $catalogo = Catalogo::where('codigo', 'documentos')->first();
                $tipo_documento = $catalogo->elementos->where('codigo', $codigo)->first();

                // Guardar el archivo en la carpeta 'archivos' dentro de la carpeta 'storage'
                $rules = [
                    "documento_archivo_$codigo" => "mimes:".$mimes, // Agrega las extensiones permitidas aquí
                ];
                $validator = Validator::make($request->all(), $rules);
                if ( ! $validator->fails()) {
                    // Guardar el archivo en la carpeta 'archivos' dentro de la carpeta 'storage'
                    $rutaArchivo = $archivo->store("archivos/$dependencia_id/$tipo_entidad/$entidad_id/$tipo_documento->codigo");

                    $pesoArchivo = round($archivo->getSize() / 1024, 2);

                    // Guardar el registro en la base de datos
                    $datosArchivo = [
                        'tipo_entidad' => $tipo_entidad,
                        'entidad_id' => $entidad_id,
                        'tipo_documento_id' => $tipo_documento->id,
                        'dependencia_id' => $dependencia_id,
                        'ruta' => $rutaArchivo,
                        'nombre' => $archivo->getClientOriginalName(),
                        'descripcion' => $descripciones[$key],
                        'fecha_recepcion' => date('Y-m-d'),
                        'num_oficio' => $oficio ?? '',
                        'num_expediente' => $expediente ?? '',
                        'extension' => $archivo->extension(),
                        'peso' => $pesoArchivo . ' KB',
                    ];

                    $carga[] = Documento::create($datosArchivo);
                }

            }
            return !in_array(false, $carga);
        }

        return false;

    }

    public function descarga($carpeta,$dependencia_id,$tipo_entidad,$entidad_id,$tipo_documento,$archivo){
        $ruta = "$carpeta/$dependencia_id/$tipo_entidad/$entidad_id/$tipo_documento/$archivo";
        $archivo = Documento::whereRuta($ruta)->first();
        try{
            $descripcionBitacora = "Se descarga el documento $archivo->nombre de la entidad $tipo_entidad y entidad_id $entidad_id";
            registroBitacora($archivo,A_DESCARGAR,C_DOCUMENTOS,null,$descripcionBitacora);
            return response()->file(Storage::path($archivo->ruta),[
                'Content-Disposition' => 'inline; filename="' . $archivo->nombre . '"',
            ]);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return redirect()->back()->with('error',"Error al descargar el archivo");
        }
    }

    public function eliminar(Request $request){
        $archivo = Documento::find($request->archivo_id);
        $eliminacion = false;
        if($archivo){
            registroBitacora($archivo,A_ELIMINAR,C_DOCUMENTOS,null,"Se elimina el documento ".$archivo->categoria->nombre." de la entidad $archivo->tipo_entidad");
            $eliminacion = $archivo->delete() && Storage::delete($archivo->ruta);
        }
        return Response::json([
            'eliminacion'=>$eliminacion
        ]);
    }
}
