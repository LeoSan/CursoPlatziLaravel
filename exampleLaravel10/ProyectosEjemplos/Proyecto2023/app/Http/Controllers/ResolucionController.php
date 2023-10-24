<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\{Caso, Catalogo, CatalogoElemento, Convenio, Demanda, Pago, PagoTotal, Resolucion, Sancion};
use App\Services\GestionCasoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;


class ResolucionController extends Controller
{
    protected $gestion,$foliador,$domicilio;
    public function __construct()
    {
        $this->gestion = new GestionCasoService();
    }

    public function registroDenuncia($caso_id){
        $caso = Caso::where('id',$caso_id)->first();
        return view('casos/resolucion/registro_demanda',compact('caso'));
    }
    public function crearDenuncia(Request $request){
        $rules = [
            'fecha_demanda'          => 'required|before_or_equal:'.date('Y-m-d'),
            'numero_expediente' => 'required|max:255',
            'nombre_juzgado'           => 'required|max:255',
            'nombre_juez'        => 'required|max:255',
            'documento_archivo_caratula_expediente' => 'required'
        ];
        $messages = [
            'documento_archivo_caratula_expediente.required' => 'Debe cargar la carátula del expediente.',
            '*.required' => 'Campo obligatorio',
            'fecha_demanda.before_or_equal' => 'La fecha debe ser igual o anterior a la actual'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();
        $resolucion = Catalogo::where('codigo', 'estatus_pgr')->first();
        $tipo_resolucion = CatalogoElemento::where('catalogo_id', $resolucion->id)->where('codigo','=','demanda')->first();
        $sancion = Sancion::where('caso_id','=',$request->caso_id)->first();
        $caso = Caso::where('id',$request->caso_id)->first();
        $resol = Resolucion::create([
            'caso_id' => $request->caso_id,
            'tipo_resolucion_id' => $tipo_resolucion->id,
            'monto' => $caso->total_multa,
            'fecha' => date('Y-m-d H:i:s')
        ]);
        $demanda = Demanda::create([
                'caso_id' => $request->caso_id,
                'resolucion_id' => $resol->id,
                'fecha' => $request->fecha_demanda,
                'num_expediente' => $request->numero_expediente,
                'nom_juzgado' => $request->nombre_juzgado,
                'nom_juez'=> $request->nombre_juez
        ]);
        $files = ArchivosController::storeSimple($request, 'caratula_expediente',$demanda->getMorphClass(), $demanda->id,auth()->user()->dependencia_id, 'num_oficio', $request->numero_expediente);
        $this->gestion->asignacion($caso,Auth::id(),$tipo_resolucion->id);
        $caso->update(['estatus_id'=>$tipo_resolucion->id]);
        $tab_activa = 'demanda';
        return redirect()->route('casos.getResumen',['caso_id'=>$caso->id, 'tab_activa'=>$tab_activa])->with('success','Información del caso almacenada correctamente.');
    }
    public function convenioPago($caso_id){
        $caso = Caso::where('id',$caso_id)->first();
        return view('casos/resolucion/convenio_pago',compact('caso'));
    }
    public function crearConvenioPago(Request $request){

        $rules = [
            'monto_prima' => 'required',
            'num_recibo_prima' => 'required|max:255',
            'fecha_pago' => 'required',
            'fecha_pago.*' => 'required|after_or_equal:'.now()->format('Y-m-d'),
            'fecha_pago_prima' => 'required|before_or_equal:'.now()->format('Y-m-d'),
        ];

        $messages = [
            'fecha_pago.required' => 'Las fechas de los pagos son requeridas.',
            'fecha_pago.*.after_or_equal' => 'Las fechas de los pagos deben ser posteriores a la actual.',
            'fecha_pago.before_or_equal' => 'Las fecha del pago de la prima debe ser menor o igual a la fecha actual.',
        ];

        $validator = Validator::make($request->all(), $rules,$messages);
        $validator->after(function ($validator) use ($request) {
            foreach ($request->fecha_pago as $fecha){
                if(!Carbon::hasFormat($fecha, 'Y-m-d')){
                    $arr = explode('-',$fecha);
                    if(count($arr)==3)
                        $validator->errors()->add('fechas', "El formato de la fecha de pago $arr[2]/$arr[1]/$arr[0] es incorrecto");
                    else
                        $validator->errors()->add('fechas', "El formato de la fecha de pago $fecha es incorrecto");
                }
            }
            $fechasSinRepetir = collect($request->fecha_pago)->unique();
            if ($fechasSinRepetir->count() !== count($request->fecha_pago)) {
                $fechaRepetida = collect($request->fecha_pago)->duplicates()->first();
                $validator->errors()->add('fechas', "La fecha de pago ".Carbon::create($fechaRepetida)->format('d/m/Y')." se encuentra repetida");
            }
        });
        $validator->validate();

        $resolucion = Catalogo::where('codigo', 'estatus_pgr')->first();
        $tipo_resolucion = CatalogoElemento::where('catalogo_id', $resolucion->id)->where('codigo','=','convenio_pago')->first();
        $sancion = Sancion::where('caso_id','=',$request->caso_id)->first();
        $caso = Caso::where('id',$request->caso_id)->first();
        $resol = Resolucion::create([
            'caso_id' => $request->caso_id,
            'tipo_resolucion_id' => $tipo_resolucion->id,
            'monto' => $caso->total_multa,
            'fecha' => date('Y-m-d H:i:s')
        ]);
        $convenio = Convenio::create([
                'caso_id' => $caso->id,
                'resolucion_id' => $resol->id,
                'num_pagos' => $request->numero_pagos
        ]);

        $convenio->pagos()->delete(); //Por si las flyes


        Pago::create([
            'convenio_id' => $convenio->id,
            'monto' => str_replace(',','',$request->monto_prima),
            'monto_pagado' => str_replace(',','',$request->monto_prima),
            'monto_pagado_intereses' => str_replace(',','',$request->monto_prima),
            'intereses' => '00.0',
            'fecha' => $request->fecha_pago_prima,
            'fecha_pagado' => $request->fecha_pago_prima,
            'num_pago' => 0,
            'num_recibo'=>$request->num_recibo_prima,
            'pagado'=>true,
            'prima'=>true//agregué esta línea en string vacío porq el num_recibo está como not null
        ]);

        for ($i=0; $i<sizeof($request->monto); $i++) {
            Pago::create([
                'convenio_id' => $convenio->id,
                'monto' => str_replace(',','',$request->monto[$i]),
                'fecha' => $request->fecha_pago[$i],
                'num_pago' => $i+1,
                'num_recibo'=>'' //agregué esta línea en string vacío porq el num_recibo está como not null
            ]);
        }

        $this->gestion->asignacion($caso,Auth::id(),$tipo_resolucion->id);
        $caso->update([
            'total_cobrado'=>str_replace(',','',$request->monto_prima),
            'total_cobrado_intereses'=>str_replace(',','',$request->monto_prima),
            'estatus_id'=>$tipo_resolucion->id
        ]);
        registroBitacora($caso,A_ACTUALIZAR,'Convenio de pagos',null,"Se crea el convenio de pagos y se registra el pago de la prima por la cantidad de L ".lempiras($request->monto_prima));
        $tab_activa = 'convenio_pago';
        return redirect()->route('casos.getResumen',['caso_id'=>$caso->id, 'tab_activa'=>$tab_activa])->with('success','Información del caso almacenada correctamente.');
    }

    public function pagoTotal($caso_id){
        $caso = Caso::where('id',$caso_id)->first();
        $mostrarTipoPago = false;
        $resAnterior = $this->obtenerResolucionAnterior($caso_id);
        if($resAnterior != null && $resAnterior->tipo->codigo == 'demanda'){
            $mostrarTipoPago = true;
        }
        $tipoPago = Catalogo::where('codigo', 'tipo_pagos')->first();
        $tiposPagos = CatalogoElemento::where('catalogo_id', $tipoPago->id)->orderBy('nombre')->get();
        return view('casos/resolucion/pago_total',compact('caso','mostrarTipoPago','tiposPagos'));
    }

    public function crearPagoTotal(Request $request){
        $caso = Caso::where('id',$request->caso_id)->first();
        $monto = str_replace(',', '', $request->monto);
        $interes = @$request->intereses ? str_replace(',', '', $request->intereses) : 0;

        $rules = [
            'fecha' => 'required|before_or_equal:'.date('Y-m-d'),
            'num_recibo' => 'required|max:150',
            'monto' => 'required'
        ];
        $messages = [
            '*.required' => 'Campo obligatorio',
            'num_recibo.max' => 'El campo número de recibo no debe contener más de 150 caracteres.',
            'fecha.before_or_equal' => 'La fecha debe ser igual o anterior a la actual'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        $fecha_actual = date("Y-m-d");
        if($request->fecha > $fecha_actual){
            return redirect()->back()->with('error','La fecha debe antes a la actual')->withInput($request->all());
        }
        $monto_total = bcadd($monto,$interes,2);

        if( bccomp($monto, $caso->total_multa,2) == -1){
            return redirect()->back()->with('error','El capital del pago debe ser mayor o igual a L '.lempiras($caso->total_multa))->withInput($request->all());
        }

        $resAnterior = $this->obtenerResolucionAnterior($caso->id);
        if($resAnterior != null && $resAnterior->tipo->codigo == 'demanda'){
            $tipoPago = $request->tipoPago;
            if($request->tipoPago == null || $request->tipoPago == ''){
                return redirect()->back()->with('error','Debe seleccionar el tipo de pago')->withInput($request->all());
            }
        }else {
            $tipoPago = null;
        }
        $resolucion = Catalogo::where('codigo', 'estatus_pgr')->first();
        $tipo_resolucion = CatalogoElemento::where('catalogo_id', $resolucion->id)->where('codigo','=','pago_total')->first();
        $caso = Caso::where('id',$request->caso_id)->first();
        $resol = Resolucion::create([
            'caso_id' => $request->caso_id,
            'tipo_resolucion_id' => $tipo_resolucion->id,
            'monto' => $caso->total_multa,
            'fecha' => date('Y-m-d H:i:s')
        ]);
        if($tipoPago == null){
            PagoTotal::create([
                'caso_id' => $request->caso_id,
                'resolucion_id'=> $resol->id,
                'fecha' => $request->fecha,
                'num_recibo' => $request->num_recibo,
                'monto' => $monto,
                'interes' =>$interes,
                'monto_total' =>$monto_total
        ]);
        }else{
            PagoTotal::create([
                'caso_id' => $request->caso_id,
                'resolucion_id'=> $resol->id,
                'fecha' => $request->fecha,
                'num_recibo' => $request->num_recibo,
                'monto' => $monto,
                'interes' =>$interes,
                'monto_total' =>$monto_total,
                'tipo_pago_id' => $tipoPago
        ]);
        }

        $this->gestion->asignacion($caso,Auth::id(),$tipo_resolucion->id);
        $caso->update(['estatus_id'=>$tipo_resolucion->id,'total_cobrado'=>$monto,'total_cobrado_intereses'=>$monto_total]);
        $tab_activa = 'pago_total';
        return redirect()->route('casos.getResumen',['caso_id'=>$caso->id, 'tab_activa'=>$tab_activa])->with('success','Información del caso almacenada correctamente.');
    }
    public function obtenerDetalleResolucion(Request $request)
    {
        if(!$request->ajax()){
            return \Response::json([
                'mensaje' => 'Error',
                'codigo' => 1,
            ], 404);
        }

        $resolucion = Resolucion::find($request->resolucion_id);
        $tipo_resolucion = $resolucion->tipo;
        //dd($tipo_resolucion);
        switch($tipo_resolucion->codigo ){
            case 'convenio_pago':
                $convenio = Convenio::where('resolucion_id','=',$resolucion->id)->first();
                //dd($convenio);
                $caso  = Caso::where('id',$resolucion->caso_id)->first();
                $pagos = Pago::where('convenio_id','=',$convenio->id)->get();
                $view  = View::make('casos.resolucion.detalle.convenio_pago',compact('resolucion','convenio','pagos', 'caso'));
                break;
            case 'pago_total':
                $pago = PagoTotal::where('resolucion_id','=',$resolucion->id)->first();
                $view = View::make('casos.resolucion.detalle.pago_total',compact('pago', 'resolucion'));
                break;
            case 'demanda':
                $demanda = Demanda::where('resolucion_id','=',$resolucion->id)->first();
                $caso    = Caso::where('id',$resolucion->caso_id)->first();
                $view    = View::make('casos.resolucion.detalle.demanda',compact('demanda','caso', 'resolucion'));
                break;
        }

        //$view=View::make('casos.resolucion.detalle.convenio_pago',compact('resolucion'));
        $html = $view->render();
        return \Response::json([
            'mensaje' => '200',
            'html' => $html
        ], 200);

    }

    public function fechasMayorActual($fechas){
        $fecha_actual = date("Y-m-d");
        $fechaMenor = false;
        foreach ($fechas as $fecha) {
            if($fecha < $fecha_actual){
                $fechaMenor = true;
            }
        }
        return $fechaMenor;
    }

    public function obtenerResolucionAnterior($caso_id){
        $resolucion = Resolucion::where('caso_id',$caso_id)->orderBy('created_at', 'desc')->first();
        return $resolucion;
    }
}
