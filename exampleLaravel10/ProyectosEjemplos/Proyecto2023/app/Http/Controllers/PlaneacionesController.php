<?php

namespace App\Http\Controllers;

use App\Models\Catalogo;
use App\Models\Planeacion;
use App\Models\PlaneacionAuditoria;
use App\Models\PlaneacionAuditoriaEjecucion;
use App\Models\PlaneacionAuditoriaMes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlaneacionesController extends Controller
{
    public function planeaciones()
    {
        $dataView = [];
        $planeaciones = Planeacion::orderByDesc('anio')->get();
        $dataView['planeaciones'] = $planeaciones;

        return view('planeaciones.index', $dataView);
    }

    public function planeacion(Request $request, $id)
    {
        $dataView = [];
        $planeacion = Planeacion::find($id);
        $dataView['planeacion'] = $planeacion;

        return view('planeaciones.planeacion', $dataView);
    }

    public function crear(Request $request)
    {
        $dataView = [];
        $dataView['registrados'] = Planeacion::all()->pluck('anio')->toArray();

        return view('planeaciones.crear-planeacion', $dataView);
    }

    public function editar(Request $request, $id)
    {
        $dataView = [];
        $planeacion = Planeacion::find($id);
        $dataView['planeacion'] = $planeacion;

        return view('planeaciones.crear-planeacion', $dataView);
    }

    public function planeacionAuditorias(Request $request, $id)
    {
        $dataView = [];
        $planeacion = Planeacion::find($id);
        $dataView['planeacion'] = $planeacion;

        return view('planeaciones.planeacion-auditorias', $dataView);
    }

    public function planeacionAuditoriaCrear(Request $request, $id)
    {
        $catalogo = new Catalogo();
        $dataView = [];
        $planeacion = Planeacion::find($id);
        $dataView['planeacion'] = $planeacion;

        $inspeccion = $catalogo->whereCodigo('tipos_inspeccion')->first();
        $dataView['tipos_inspeccion'] = $inspeccion->elementos;

        $actividades_economicas = $catalogo->whereCodigo('actividades_economicas')->first();
        $dataView['actividades_economicas'] = $actividades_economicas->elementos;

        $auditores = User::permission('auditorias_ejecucion')->get();
        $dataView['auditores'] = $auditores;

        return view('planeaciones.planeacion-auditoria-crear', $dataView);
    }

    public function planeacionAuditoriaEditar(Request $request, $id)
    {
        $catalogo = new Catalogo();
        $dataView = [];
        $auditoria = PlaneacionAuditoria::find($id);
        $planeacion = $auditoria->planeacion;

        $dataView['planeacion'] = $planeacion;
        $dataView['auditoria'] = $auditoria;

        $municipios = $catalogo->whereCodigo('municipios')->first();
        $dataView['municipios'] = $municipios->elementos->where('parent_id', $auditoria->departamento_id);

        $inspeccion = $catalogo->whereCodigo('tipos_inspeccion')->first();
        $dataView['tipos_inspeccion'] = $inspeccion->elementos;

        $actividades_economicas = $catalogo->whereCodigo('actividades_economicas')->first();
        $dataView['actividades_economicas'] = $actividades_economicas->elementos;


        $auditores = User::whereHas('roles', function ($query) {
            $query->where('name', 'auditor_setrass_ati');
        })->get();
        $dataView['auditores'] = $auditores;

        return view('planeaciones.planeacion-auditoria-crear', $dataView);
    }

    public function planeacionAuditoriaMensual(Request $request, $id)
    {
        $dataView = [];

        $auditoria = PlaneacionAuditoria::find($id);
        $planeacion = $auditoria->planeacion;

        $dataView['planeacion'] = $planeacion;
        $dataView['auditoria'] = $auditoria;

        return view('planeaciones.planeacion-auditoria-mensual', $dataView);
    }

    public function planeacionRegistro(Request $request, $id)
    {
        $catalogo = Catalogo::whereCodigo('estatus_plan_anual')->first();

        $planeacion = Planeacion::find($id);

        if ($planeacion->anio == date('Y')) {
            $estatus = $catalogo->elementos?->where('codigo', 'vigente')->first();
            PlaneacionesController::ejecucionVigencia($planeacion);
        } else {
            $estatus = $catalogo->elementos?->where('codigo', 'registrado')->first();
        }

        $planeacion->estatus_id = $estatus->id;
        $planeacion->save();



        return redirect("/planeaciones");
    }

    public function create(Request $request)
    {
        $catalogo = Catalogo::whereCodigo('estatus_plan_anual')->first();
        $estatus = $catalogo->elementos?->where('codigo', 'planeacion')->first();

        $dataSave = [];
        $dataSave['anio'] = $request->input('anio');
        $dataSave['objetivo'] = $request->input('objetivo');
        $dataSave['alcance'] = $request->input('alcance');
        $dataSave['criterio'] = $request->input('criterio');
        $dataSave['recursos'] = $request->input('recursos');
        $dataSave['estatus_id'] = $estatus->id;

        if ($request->has('planeacion')) {
            $planeacion = Planeacion::find($request->input('planeacion'));
            $planeacion->update($dataSave);
        } else {
            $planeacion = Planeacion::create($dataSave);
        }

        $dependencia_id = Auth::user()->dependencia_id;
        ArchivosController::storeSimple($request, 'plan_anual_auditorias', $planeacion->getMorphClass(), $planeacion->id, $dependencia_id);

        return redirect("/planeaciones/planeacion/{$planeacion->id}/auditorias");
    }

    public function delete(Request $request)
    {
        $planeacion = Planeacion::find($request->input('planeacion'));
        if ($planeacion->delete()) {
            return back();
        }
    }

    public function createAuditoria(Request $request)
    {
        $catalogo = Catalogo::whereCodigo('estatus_auditorias')->first();
        $estatus = $catalogo->elementos?->where('codigo', 'espera')->first();

        $cata_munucipio_id = Catalogo::whereCodigo('municipios')->first()->id;
        $oficina_regional = DB::select('SELECT reg.id, reg.nombre region, reg.codigo region_codigo FROM catalogo_elementos mun LEFT JOIN catalogo_elementos reg ON mun.categoria_id = reg.id  WHERE mun.catalogo_id = ' . $cata_munucipio_id . '  AND mun.id = ?', [$request->municipio_id]);

        $region_id = $oficina_regional[0]->id;

        // Info para crear registro
        $dataSave = [
            'planeacion_id' => $request->input('planeacion'),
            'departamento_id' => $request->input('departamento_id'),
            'municipio_id' => $request->input('municipio_id'),
            'tipo_inspeccion_id' => $request->input('tipo_inspeccion_id'),
            'cafta' => $request->input('cafta'),
            'actividad_economica_id' => $request->input('actividad_economica_id'),
            'region_id' => $region_id,
            'estatus_id' => $estatus->id,
        ];

        if ($request->has('auditoria')) {
            $auditoria = PlaneacionAuditoria::find($request->input('auditoria'));
            $dataSave['auditor_responsable_id'] = $request->input('auditor_responsable_id');

            $auditoria->update($dataSave);
        } else {
            $auditoria = PlaneacionAuditoria::updateOrCreate($dataSave, ['auditor_responsable_id' => $request->input('auditor_responsable_id')]);
        }

        return redirect("/planeaciones/planeacion/auditoria/{$auditoria->id}/mensual");
    }

    public function createAuditoriaMeses(Request $request)
    {
        $meses = $request->input('no_auditorias');

        $auditoria = PlaneacionAuditoria::find($request->input('auditoria'));
        $auditoria->total_auditorias = $request->input('total_auditorias');
        $auditoria->save();

        $dataSave = [];

        foreach ($meses as $key => $mes) {
            PlaneacionAuditoriaMes::updateOrCreate([
                'planeacion_auditoria_id' => $auditoria->id,
                'mes' => $key + 1,
            ], [
                'num_auditorias' => $mes,
            ]);
        }

        return redirect("/planeaciones/planeacion/{$auditoria->planeacion?->id}/auditorias");
    }

    public function deleteAuditoria(Request $request)
    {
        $auditoria = PlaneacionAuditoria::find($request->input('auditoria'));
        if ($auditoria->delete()) {
            return back();
        }
    }

    public function validateAuditoria(Request $request)
    {
        $auditoria = PlaneacionAuditoria::where('planeacion_id', $request->input('planeacion'))
            ->where('departamento_id', $request->input('departamento'))
            ->where('municipio_id', $request->input('municipio'))
            ->where('tipo_inspeccion_id', $request->input('inspeccion'))
            ->where('cafta', $request->input('cafta'))
            ->where('actividad_economica_id', $request->input('actividad'))
            ->first();

        if ($auditoria) {
            $auditorOriginal = $auditoria->auditor;
            $auditorNuevo = User::find($request->input('auditor'));

            if ($auditorOriginal->id != $auditorNuevo->id) {
                return response()->json(['data' => true, 'message' => "Este grupo de auditorías ya ha sido asignado a $auditorOriginal->complete_name. Si continúa el auditor será actualizado a $auditorNuevo->complete_name. "]);
            }
        }
        return response()->json(['data' => false]);
    }

    public static function ejecucionVigencia($planeacion)
    {
        $grupos = $planeacion->auditorias;
        $catalogo = Catalogo::whereCodigo('estatus_auditorias')->first();
        $estatus = $catalogo->elementos->where('codigo', 'pendiente')->first();
        foreach ($grupos as $grupo) {
            $meses = $grupo->meses->where('num_auditorias', '>', 0);
            $datosRegistro = [
                'estatus_id' => $estatus->id,
                'auditor_asignado_id' => $grupo->auditor_responsable_id,
                'planeacion_auditoria_id' => $grupo->id,
            ];
            foreach ($meses as $mes) {
                $datosRegistro['mes'] = $mes->mes;
                for ($index=1; $index <= $mes->num_auditorias; $index++) {
                    $datosRegistro['num_control'] = $index;
                    PlaneacionAuditoriaEjecucion::create($datosRegistro);
                }
            }
        }
    }
}
