<?php

namespace App\Http\Controllers;

use App\Mail\Notificacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\{Catalogo, CatalogoElemento, DiaNoHabil};
//use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function index()
    {

        $area = Catalogo::where('codigo', 'areas_adscripcion')->first();
        $area_ati = CatalogoElemento::where('catalogo_id', $area->id)->where('codigo','ati')->first();
        $area_pgr = CatalogoElemento::where('catalogo_id', $area->id)->where('codigo','dnpj')->first();
        $area_dgit =CatalogoElemento::where('catalogo_id', $area->id)->where('codigo','dgit')->first();

        $usuario = User::select('users.*','catalogo_elementos.codigo as area')->join('catalogo_elementos', 'users.area_adscripcion_id', '=', 'catalogo_elementos.id')->where('users.id','=', Auth::user()->id)->first();

        $pre_recarga_estatus = precargaEstatus();

        if($usuario->area_adscripcion_id == $area_dgit->id || $usuario->area_adscripcion_id == $area_pgr->id){
            switch ($usuario->PosicionRol) {
                case 'admin_setrass':
                case 'analista_setrass':
                case 'inspector_setrass':
                case 'administrador_dnpj':
                case 'auxiliar_dnpj':
                case 'coordinador':
                case 'procurador':
                    session()->put('url_casos',route('casos.index', ['asignado'=>Auth::user()->id, 'estatus'=>$pre_recarga_estatus]));
                    return redirect(route('casos.index', ['asignado'=>Auth::user()->id, 'estatus'=>$pre_recarga_estatus]));
                case 'auditor_setrass_ati':
                case 'jefe_regional':
                    return redirect(route('denuncias.index'));
                default:
                    abort(403);
               }

        }
        if($usuario->area_adscripcion_id == $area_ati->id){
            switch ($usuario->PosicionRol) {
                case 'jefe_auditoria_setrass_ati':
                case 'denunciante':
                case 'jefe_regional':
                case 'auditor_setrass_ati':
                    return redirect(route('denuncias.index'));
                default:
                    abort(403);
               }
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function files()
    {
        return view('files');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function load(Request $request)
    {
        $files = ArchivosController::storeMultiple($request, 'acuse_recibo', 2,10, null, '1');
        return view('files');
    }


    public function mailable()
    {
        $usuario = User::first();
        $contenido = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam at eveniet ex, fugiat hic id illum laudantium nesciunt sed ut, voluptate voluptates.';
        Mail::to($usuario->email)->send(new Notificacion($usuario, 'test', 'Titulo de la notificación'));
        return 'ok';
    }

    public function updateSidebarCollapse(Request $request)
    {
        $nuevoEstado = $request->input('nuevoEstado'); // Puedes recibir el estado como 'true' o 'false'
        session(['sidebar_collapse' => $nuevoEstado]);
        return response()->json(['mensaje' => 'Estado actualizado correctamente']);
    }

    public function getDiasInhabiles(){
        $inhabiles = DiaNoHabil::whereNull('dependencia_id')->orWhere(function($q){
            $q->when(Auth::check(),function($q){
                $q->whereDependenciaId(Auth::user()->dependencia_id);
            });
        })->pluck('fecha')->toArray();
        return response()->json(['inhabiles' => $inhabiles]);
    }
}
