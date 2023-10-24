<?php

namespace App\Http\Controllers;

use App\Models\Catalogo;
use App\Models\User;
use App\Models\UsuarioJurisdiccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JurisdiccionController extends Controller
{
    public function index()
    {
        $catalogo = Catalogo::with('elementos.hijos')->whereCodigo('departamentos')->first();
        $departamentos = $catalogo->elementos->sortBy('nombre');
        $auditores = User::permission('auditorias_ejecucion')->orderBy('complete_name')->get();
        return view('admin.jurisdiccion.index', compact('departamentos', 'auditores'));
    }

    /**
     * Gestiona el Request del formulario
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        try{
            UsuarioJurisdiccion::updateOrCreate([
                'municipio_id' => $request->municipio_id,
                'usuario_id' => $request->usuario_id,
            ]);
            return redirect()->back()->with('success', "Jurisdicción actualizada correctamente.");
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return redirect()->back()->with('error', "Ha ocurrido un error, por favor intente más tarde.");
        }

    }
}
