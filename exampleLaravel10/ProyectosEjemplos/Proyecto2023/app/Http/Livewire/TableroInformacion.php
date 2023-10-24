<?php

namespace App\Http\Livewire;

use App\Models\Caso;
use App\Models\Catalogo;
use App\Models\CatalogoElemento;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class TableroInformacion extends Component
{
    protected $queryString = [
        'periodo_desde','periodo_hasta', 'estatus'
    ];
    public
    $periodo_desde = null,
    $periodo_hasta = null,
    $estatus = [],
    $filtrado = false,

    $cat_estatus = null,
    $cat_estatus_array = null,
    $catalogo_tipo_pago = null,
    $tipo_pago_extra = null,
    $rango = [];

    public function mount(){

        $catEstatus = Catalogo::whereCodigo('estatus_pgr')->first();
        $this->cat_estatus = Catalogo::whereCodigo('estatus_pgr')->orderBy('nombre')->first()->elementos;
        $this->cat_estatus_array = CatalogoElemento::whereCatalogoId($catEstatus->id)->orderBy('orden')->pluck('nombre','id')->toArray();

        $this->catalogo_tipo_pago = Catalogo::whereCodigo('tipo_pagos')->first();
        $this->tipo_pago_extra = $this->catalogo_tipo_pago->elementos->where('codigo', 'extrajudicial')->first();
        $this->periodo_hasta = now()->format('Y-m-d');
        $this->periodo_desde = now()->subMonths(6)->format('Y-m-d');
        $this->estatus = $this->cat_estatus->whereNotIn('codigo', ['no_procedente', 'captura'])
            ->pluck('id')
            ->toArray();
    }

    public function render()
    {
        $this->filtrado=( ($this->periodo_desde&&$this->periodo_hasta) || count($this->estatus) > 0 );

        $filtros =  [
            'fecha_notificacion'=>[
                'texto'=>'Periodo de notificación:',
                'valor'=> ($this->periodo_desde&&$this->periodo_hasta) ? 'Del '.Carbon::create($this->periodo_desde)->format('d/m/Y').' al '.Carbon::create($this->periodo_hasta)->format('d/m/Y') : null,
                'error'=>false
            ],
            'estatus'=>[
                'texto'=>'Estatus:',
                'valor'=> count($this->estatus) > 0 ? ( count($this->estatus) > 2 ? 'Tienes 3 o más Seleccionados' :  implode(  ', ', array_intersect_key($this->cat_estatus_array, array_flip($this->estatus)) )) : null
            ]
        ];

        if( !($this->periodo_desde&&$this->periodo_hasta) && ($this->periodo_desde||$this->periodo_hasta) ){
            $filtros['periodo']['error']="Introduzca ambas fechas para filtrar.";
        }elseif(($this->periodo_desde&&$this->periodo_hasta)&&(Carbon::create($this->periodo_desde)>Carbon::create($this->periodo_hasta))){
            $filtros['periodo']['error']="La fecha final es menor a la inicial.";
            $filtros['periodo']['valor']=null;
        }
        $dataView = $this->informacionVista();
        return view('livewire.tablero-informacion',['filtrado'=>$this->filtrado,'filtros'=>$filtros,'dataView'=>$dataView]);
    }

    public function informacionVista(){

        $casos = Caso::with(['pagostotales', 'convenio']);

        if (isset($this->estatus) && count($this->estatus)>0 && !in_array('Todos', $this->estatus)) {
            $casos = $casos->whereIn('estatus_id', $this->estatus);
        }

        if ($this->periodo_desde && $this->periodo_hasta) {
            $casos = $casos->whereBetween('fecha_notificacion', [$this->periodo_desde,$this->periodo_hasta]);
        }

        $casos = $casos->get();

        $this->rango = isset($this->periodo_desde) && isset($this->periodo_hasta) ? [0 => Carbon::create($this->periodo_desde)->translatedFormat('j F Y'), 1 => Carbon::create($this->periodo_hasta)->translatedFormat('j F Y')] : [];

        $dataView['deuda'] = 0;

        $pagosConveniosCantidad = 0;
        $pagosTotalesIntereses = 0;
        $pagosConveniosIntereses = 0;
        $pagosTotalesCantidad = 0;

        $totalesJudiciales = 0;
        $totalesExtraJudi = 0;

        $totalPagosConvenio = 0;

        foreach ($casos as $i){
            $dataView['deuda'] = bcadd($dataView['deuda'],$i->total_multa,2);

            $pagosConvenio = $i->convenio ? $i->convenio->pagos : [];
            foreach ($pagosConvenio as $j){
                $totalPagosConvenio = $j->pagado ? $totalPagosConvenio+1 : $totalPagosConvenio;
                $pagosConveniosCantidad = bcadd($pagosConveniosCantidad,$j->monto_pagado,2);
            }

            $pagosTotalesInteres = $i->pagostotales->pluck('interes')->toArray();
            foreach ($pagosTotalesInteres as $j)
                $pagosTotalesIntereses = bcadd($pagosTotalesIntereses,$j,2);

            $pagosConvenioInteres = $i->convenio ? $i->convenio->pagos->pluck('intereses')->toArray() : [];
            foreach ($pagosConvenioInteres as $j)
                $pagosConveniosIntereses = bcadd($pagosConveniosIntereses,$j,2);

            $pagosTotales = $i->pagostotales->count()>0 ? $i->pagostotales : [];
            foreach ($pagosTotales as $j){
                if (!isset($j->tipo_pago_id) || $j->tipo_pago_id == $this->tipo_pago_extra->id) $totalesExtraJudi++;
                else $totalesJudiciales++;
                $pagosTotalesCantidad = bcadd($pagosTotalesCantidad,$j->monto,2);
            }
        }

        $total_pagos = bcadd($pagosTotalesCantidad,$pagosConveniosCantidad, 2);
        $total_intereses = bcadd($pagosTotalesIntereses,$pagosConveniosIntereses, 2);
        $total_pagos_intereses = bcadd($total_pagos,$total_intereses, 2);

        $pagos_extrajudiciales = bcadd($totalPagosConvenio,$totalesExtraJudi, 2);

        $dataView['total_pagos'] = $total_pagos;
        $dataView['total_intereses'] = $total_intereses;
        $dataView['total_pagos_intereses'] = $total_pagos_intereses;

        $dataView['pagos_extrajudiciales'] = $pagos_extrajudiciales;
        $dataView['pagos_judiciales'] = $totalesJudiciales;
        $dataView['total_conteo_pagos'] = bcadd($pagos_extrajudiciales, $totalesJudiciales);
        $dataView['estatus_elementos'] = $this->cat_estatus->where('codigo', '!=', 'no_procedente')->where('codigo', '!=', 'captura')->sortBy('nombre');
        return $dataView;
    }

    public function removeFiltro($propiedad){
        if($propiedad=='periodo'){
            $this->periodo_desde=null;
            $this->periodo_hasta=null;
        }
        elseif($propiedad=='estatus'){
            $this->estatus=[];
        }else{
            $this->$propiedad = null;
        }
    }

    public function resetFiltros(){
        $this->periodo_desde = null;
        $this->periodo_hasta = null;
        $this->estatus = [];
    }

}
