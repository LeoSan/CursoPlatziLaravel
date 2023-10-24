<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Catalogo, CatalogoElemento};
use App\Http\Requests\CatalogoRequest;

class CatalogoController extends Controller
{
    /**
     * Muestra la bandeja de catálogos
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
		return view('admin.catalogos.index');
    }

    /**
     * Muestra la vista del catálogo.
     * @param Catalogo $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show(Catalogo $catalogo){
        $elementos = $catalogo->elementos()->paginate(20);
        $regiones = Catalogo::whereCodigo('regiones_setrass')->first()->elementos->sortBy('nombre');
        $itemsbread = [
            ['nombreComponente' => 'Administración',  'ruta'=> '#', 'value'=>''],
            ['nombreComponente' => 'Catálogos',  'ruta'=> route('catalogos.index'), 'value'=>''],
            ['nombreComponente' => $catalogo->nombre,  'ruta'=> route('catalogos.show',$catalogo->id), 'value'=>'active']
        ];
        return view('admin.catalogos.show',compact('catalogo','elementos','itemsbread', 'regiones'));
    }

    /**
     * @param Catalogo $catalogo
     * @param CatalogoElemento $elemento
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function showElemento(Catalogo $catalogo,CatalogoElemento $elemento)
    {
        $catalogo = $elemento->catalogo;
        $elementos = $elemento->hijos()->paginate(20);
        $itemsbread = [
            ['nombreComponente' => 'Administración',  'ruta'=> '#', 'value'=>''],
            ['nombreComponente' => 'Catálogos',  'ruta'=> route('catalogos.index'), 'value'=>''],
            ['nombreComponente' => $elemento->catalogo->nombre,  'ruta'=> route('catalogos.show',$elemento->catalogo->id), 'value'=>''],
            ['nombreComponente' => $elemento->nombre,  'ruta'=> route('catalogos.elementos.show',[$catalogo->id,$elemento->id]), 'value'=>'active']
        ];
        return view('admin.catalogos.show',compact('catalogo','elemento','elementos','itemsbread'));
    }

    /**
     * Almacena la información del formulario de creación/edición de elementos.
     * @param Catalogo $id
     */
    public function store(Catalogo $catalogo,Request $request){
        if(isset($request->id)){
            $msg="Elemento actualizado correctamente";
            $elemento = CatalogoElemento::updateOrCreate(['id'=>$request->id,'catalogo_id'=>$catalogo->id],[
                'nombre'=>$request->nombre,
                'codigo'=>$request->codigo,
                'descripcion'=>@$request->descripcion,
                'parent_id'=>@$request->parent_id,
                'categoria_id'=>@$request->categoria_id,
            ]);
            $descripcion = "Se actualizó la información del elemento $request->nombre del catálogo $catalogo->nombre";
            registroBitacora($elemento,A_ACTUALIZAR,C_CATALOGOS,null,$descripcion,$elemento->toArray());
        }else{
            $msg="Elemento registrado correctamente";
            $elemento = CatalogoElemento::updateOrCreate([
                'catalogo_id'=>$catalogo->id,
                'nombre'=>$request->nombre,
                'codigo'=>$request->codigo,
                'descripcion'=>@$request->descripcion,
                'parent_id'=>@$request->parent_id,
                'categoria_id'=>@$request->categoria_id,
            ]);
            $descripcion = "Se registró el elemento $elemento->nombre del catálogo $catalogo->nombre";
            registroBitacora($elemento,A_REGISTRAR,C_CATALOGOS,null,$descripcion,$elemento->toArray());
        }
        return redirect()->back()->with('success',$msg);
    }
}
