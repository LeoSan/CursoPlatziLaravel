<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\{DiaNoHabil};
use Illuminate\Support\Facades\{Validator};

class DiasInhabilesController extends Controller
{

    public function index()
    {
        return view('admin.inhabiles.index');
    }

    /**
     * Gestiona el Request del formulario
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $aux = explode('-', $request->fecha);
        if($request->accion == 'crear'){
            $this->validador($request);
            $diaNoHabil = DiaNoHabil::create([
                'fecha'       => $request->fecha ,
                'descripcion' => $request->descripcion,
                'creador_id'  => auth()->id(),
                'anio'        => $aux[0],
                'dependencia_id' => null
            ]);
            registroBitacora($diaNoHabil,A_REGISTRAR,C_DIASINHABILES,null,"Se ha registrado el día inhábil ".$diaNoHabil->fecha->format('d/m/Y'));
            return redirect()->back()->with('success',"Día inhábil registrado correctamente.");
        }else if($request->accion == 'editar'){
            $this->validador($request);
            DiaNoHabil::where('id', $request->id)->update(
                [
                    'id'          => $request->id,
                    'fecha'       => $request->fecha,
                    'descripcion' => $request->descripcion,
                    'creador_id'  => auth()->id(),
                    'anio'        => $aux[0],
                    'dependencia_id' => null
                ]
            );
            $diaNoHabil = DiaNoHabil::find($request->id);
            registroBitacora($diaNoHabil,A_ACTUALIZAR,C_DIASINHABILES,null,"Se ha actualizado el día inhábil ".$diaNoHabil->fecha->format('d/m/Y'));
            return redirect()->back()->with('success',"Día inhábil actualizado correctamente.");
        }
        else if($request->accion == 'eliminar'){
            $diaNoHabil = DiaNoHabil::where('id', $request->id)->first();
            registroBitacora($diaNoHabil,A_ELIMINAR,C_DIASINHABILES,null,"Se ha eliminado el día inhábil ".$diaNoHabil->fecha->format('d/m/Y'));
            $diaNoHabil->delete();
            return redirect()->back()->with('success',"Día inhábil eliminado correctamente.");
        }else{
            return redirect()->back()->with('error',"Ha ocurrido un error, por favor intente más tarde.");
        }
    }

    /**
     * Metodo: Permite validar el request del formulario
     * @param Request $request
     * @return void
     */
    public function validador(Request $request){
        $rules = [
            'fecha' => 'required|unique:dias_no_habiles,fecha',
            'descripcion' => 'required',
        ];
        $messages = [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.unique' => 'Esta fecha ya ha sido registrada.',
            'descripcion.required' => 'La descripción es obligatoria.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();
    }

    /**
     * @param $fecha Fecha a partir de la que se realiza el cálculo
     * @param $plazo Número de días hábiles
     * @return string
     * Realiza el cálculo de un plazo de N días a partir de una fecha tomando en cuenta que sólo sean días hábiles
     */
    public function calculoPlazo($fecha,$plazo){
        $hoy = Carbon::create($fecha);
        $diaSiguiente=$hoy->subDay();
        $i=0;
        while($i<=$plazo){
            $diaSiguiente->addDay();
            if( !(DiaNoHabil::whereFecha($diaSiguiente->format('Y-m-d'))->first() || $diaSiguiente->isWeekend() ))
                $i++;
        }
        return $diaSiguiente->format('Y-m-d');
    }
}
