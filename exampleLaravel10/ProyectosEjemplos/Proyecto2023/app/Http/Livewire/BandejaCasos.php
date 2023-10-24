<?php

namespace App\Http\Livewire;

use App\Exports\CasosExport;
use App\Exports\EstadisticaExport;
use App\Models\Caso;
use App\Models\Catalogo;
use App\Models\CatalogoElemento;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
//use Illuminate\Support\Facades\Log;


class BandejaCasos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'busqueda', 'fecha_ingreso_desde','fecha_notificacion_desde','fecha_ingreso_hasta','fecha_notificacion_hasta', 'cobrar_desde', 'estatus',  'cobrar_hasta', 'cobrado_desde', 'cobrado_hasta', 'cobrado_intereses_desde', 'cobrado_intereses_hasta', 'asignado'
    ];

    public $tipo = null,
        $entries = 10,
        $filtrado = false,
        $busqueda = null,
        $fecha_ingreso_desde = null,
        $fecha_ingreso_hasta = null,
        $fecha_notificacion_desde = null,
        $fecha_notificacion_hasta = null,
        $estatus = [],
        $cobrar_desde = null,
        $cobrar_hasta = null,
        $cobrado_desde = null,
        $cobrado_hasta = null,
        $cobrado_intereses_desde = null,
        $cobrado_intereses_hasta = null,
        $asignado = null,


        $cat_estatus = null,
        $cat_estatus_array = null,
        $cat_resoluciones = null,
        $cat_resoluciones_array = null,
        $analistas = null,
        $analistas_array = null,
        $rol_activo = null;


    public function mount(){
        $user = Auth::user();
        $catEstatus = Catalogo::whereCodigo('estatus_pgr')->first();
        $this->rol_activo = $user->roles()->first()->name;
        $this->cat_estatus = CatalogoElemento::whereCatalogoId($catEstatus->id)
            ->when($this->rol_activo!='inspector_setrass',function($q){
                $q->where('codigo','!=','captura');
            })
            ->orderBy('nombre','asc')->get();
        $this->cat_estatus_array = CatalogoElemento::whereCatalogoId($catEstatus->id)
            ->when($this->rol_activo!='inspector_setrass',function($q){
                $q->where('codigo','!=','captura');
            })
            ->orderBy('orden')->pluck('nombre','id')->toArray();

        $this->analistas = User::where('activo',true)->whereDependenciaId($user->dependencia_id)->whereAreaAdscripcionId($user->area_adscripcion_id)->orderBy('name','asc')->get();
        $this->analistas_array = $this->analistas ? $this->analistas->pluck('complete_name','id')->toArray() : [];
    }

    public function render()
    {
        $this->filtrado=( ($this->fecha_ingreso_desde&&$this->fecha_ingreso_hasta)||($this->fecha_notificacion_desde&&$this->fecha_notificacion_hasta)||$this->estatus||$this->cobrar_desde||$this->cobrar_hasta||$this->cobrado_desde||$this->cobrado_hasta||$this->cobrado_intereses_desde||$this->cobrado_intereses_hasta||$this->asignado);
        $filtros =  [
            'fecha_ingreso'=>[
                'texto'=>"Fecha de ingreso:",
                'valor'=> ($this->fecha_ingreso_desde&&$this->fecha_ingreso_hasta) ? 'Del '.Carbon::create($this->fecha_ingreso_desde)->format('d/m/Y').' al '.Carbon::create($this->fecha_ingreso_hasta)->format('d/m/Y') : null,
                'error'=>false
            ],
            'fecha_notificacion'=>[
                'texto'=>'Fecha de notificación:',
                'valor'=> ($this->fecha_notificacion_desde&&$this->fecha_notificacion_hasta) ? 'Del '.Carbon::create($this->fecha_notificacion_desde)->format('d/m/Y').' al '.Carbon::create($this->fecha_notificacion_hasta)->format('d/m/Y') : null,
                'error'=>false
            ],
            'estatus'=>[
                'texto'=>'Estatus:',
                'valor'=> count($this->estatus) > 0 ? ( count($this->estatus) > 2 ? 'Tienes 3 o más Seleccionados' :  implode(  ', ', array_intersect_key($this->cat_estatus_array, array_flip($this->estatus)) )) : null
            ],
            'monto_cobrar'=>[
                'texto'=>'Monto a cobrar:',
                'valor'=> ($this->cobrar_desde||$this->cobrar_hasta) ? ($this->cobrar_desde ? " desde L ".lempiras($this->cobrar_desde) : '') . ($this->cobrar_hasta ? " hasta L ".lempiras($this->cobrar_hasta) : '') : null,
                'error' => false
            ],
            'monto_cobrado'=>[
                'texto'=>'Monto cobrado:',
                'valor'=> ($this->cobrado_desde||$this->cobrado_hasta) ? ($this->cobrado_desde ? " desde L ".lempiras($this->cobrado_desde) : '') . ($this->cobrado_hasta ? " hasta L ".lempiras($this->cobrado_hasta) : '') : null,
                'error' => false
            ],
            'monto_cobrado_intereses'=>[
                'texto'=>'Monto cobrado con intereses:',
                'valor'=> ($this->cobrado_intereses_desde||$this->cobrado_intereses_hasta) ? ($this->cobrado_intereses_desde ? " desde L ".lempiras($this->cobrado_intereses_desde) : '') . ($this->cobrado_intereses_hasta ? " hasta L ".lempiras($this->cobrado_intereses_hasta) : '') : null,
                'error' => false
            ],
            'asignado'=>[
                'texto'=>'Asignado a:',
                'valor'=>$this->asignado ? $this->analistas_array[$this->asignado] : null,
            ]
        ];
        if( !($this->fecha_ingreso_desde&&$this->fecha_ingreso_hasta) && ($this->fecha_ingreso_desde||$this->fecha_ingreso_hasta) ){
            $filtros['fecha_ingreso']['error']="Introduzca ambas fechas para filtrar.";
        }elseif(($this->fecha_ingreso_desde&&$this->fecha_ingreso_hasta)&&(Carbon::create($this->fecha_ingreso_desde)>Carbon::create($this->fecha_ingreso_hasta))){
            $filtros['fecha_ingreso']['error']="La fecha final es menor a la inicial.";
            $filtros['fecha_ingreso']['valor']=null;
        }
        if( !($this->fecha_notificacion_desde&&$this->fecha_notificacion_hasta) && ($this->fecha_notificacion_desde||$this->fecha_notificacion_hasta) ){
            $filtros['fecha_notificacion']['error']="Introduzca ambas fechas para filtrar.";
        }elseif(($this->fecha_notificacion_desde&&$this->fecha_notificacion_hasta)&&(Carbon::create($this->fecha_notificacion_desde)>Carbon::create($this->fecha_notificacion_hasta))){
            $filtros['fecha_notificacion']['error']="La fecha final es menor a la inicial.";
            $filtros['fecha_notificacion']['valor']=null;
        }
        if(isset($this->cobrar_desde) && isset($this->cobrar_hasta) && $this->cobrar_desde!="" && $this->cobrar_hasta!=""){
            if( bccomp( str_replace(',', '', $this->cobrar_hasta) , str_replace(',', '', $this->cobrar_desde) ) < 0)
                $filtros['monto_cobrar']['error']="El monto mínimo es mayor al monto máximo";
        }
        if(isset($this->cobrado_desde) && isset($this->cobrado_hasta) && $this->cobrado_desde!="" && $this->cobrado_hasta!=""){
            if(bccomp( str_replace(',', '', $this->cobrado_hasta) , str_replace(',', '', $this->cobrado_desde) ) < 0 )
                $filtros['monto_cobrado']['error']="El monto mínimo es mayor al monto máximo";
        }
        if(isset($this->cobrado_intereses_desde) && isset($this->cobrado_intereses_hasta) && $this->cobrado_intereses_desde!="" && $this->cobrado_intereses_hasta!=""){
            if(bccomp( str_replace(',', '', $this->cobrado_intereses_hasta) , str_replace(',', '', $this->cobrado_intereses_desde) ) < 0 )
                $filtros['monto_cobrado_intereses']['error']="El monto mínimo es mayor al monto máximo";
        }
        $this->actualizarUrlCasos();
        $casos = $this->getCasos();
        return view('livewire.bandeja-casos',['casos'=>$casos->paginate($this->entries),'filtrado'=>$this->filtrado,'filtros'=>$filtros]);
    }

    public function actualizarUrlCasos(){
        $parametros=[];
        foreach ($this->queryString as $q){
            $parametros[$q]=$this->$q??'';
            if(!$this->$q) unset($parametros[$q]);
        }
        session()->put('url_casos',route('casos.index',$parametros));
        $this->dispatchBrowserEvent('actualiza_bandeja_casos',['url'=>route('casos.index',$parametros)]);
    }

    protected function getCasos(){
            return  Caso::whereRaw("1=1")
                ->when($this->busqueda && strlen($this->busqueda)>2,function($q){
                    $q->where(function($q){
                        $q->whereRaw(" numero_expediente ilike '%{$this->busqueda}%' OR numero_expediente_pgr ilike '%{$this->busqueda}%' ")
                            ->orWhereHas('empresa',function($q){
                                $q->whereRaw(" translate(lower(razon_social), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
                            });
                    });
                })->when( ($this->fecha_ingreso_desde&&$this->fecha_ingreso_hasta) && (Carbon::create($this->fecha_ingreso_desde)<=Carbon::create($this->fecha_ingreso_hasta)) ,function($q){
                    $q->whereRaw("fecha_recepcion_pgr between '$this->fecha_ingreso_desde' AND '$this->fecha_ingreso_hasta'");

                })->when( ($this->fecha_notificacion_desde&&$this->fecha_notificacion_hasta) && (Carbon::create($this->fecha_notificacion_desde)<=Carbon::create($this->fecha_notificacion_hasta)),function($q){
                    $q->whereRaw("fecha_notificacion::date >= '$this->fecha_notificacion_desde' AND fecha_notificacion::date <= '$this->fecha_notificacion_hasta'");
                })->when($this->asignado,function($q){
                    $q->whereUsuarioAsignadoId($this->asignado);
                })->when($this->cobrar_desde && $this->cobrar_desde!="",function($q) {
                    $cobrarD = str_replace(',', '', $this->cobrar_desde);
                    $q->where('total_multa', '>=', $cobrarD);
                })->when($this->cobrar_hasta && $this->cobrar_hasta!="",function($q){
                    $cobrarH = str_replace(',','',$this->cobrar_hasta) ;
                    $q->where('total_multa','<=',$cobrarH);
                })->when($this->cobrado_desde && $this->cobrado_desde!="",function($q) {
                    $cobrarD = str_replace(',', '', $this->cobrado_desde);
                    $q->where('total_cobrado', '>=', $cobrarD);
                })->when($this->cobrado_hasta && $this->cobrado_hasta!="",function($q){
                    $cobrarH = str_replace(',','',$this->cobrado_hasta) ;
                    $q->where('total_cobrado','<=',$cobrarH);
                })->when($this->cobrado_intereses_desde && $this->cobrado_intereses_desde!="",function($q) {
                    $cobrarD = str_replace(',', '', $this->cobrado_intereses_desde);
                    $q->where('total_cobrado_intereses', '>=', $cobrarD);
                })->when($this->cobrado_intereses_hasta && $this->cobrado_intereses_hasta!="",function($q){
                    $cobrarH = str_replace(',','',$this->cobrado_intereses_hasta) ;
                    $q->where('total_cobrado_intereses','<=',$cobrarH);
                })->when($this->estatus, function ($query) {
                    return $query->where(function ($query) {
                            $aux = implode(',',$this->estatus);
                            $aux_arry = explode(',',  $aux);
                            $query->whereIn('estatus_id', $aux_arry);
                    });
                })->whereHas('gestion',function($q){
                    if(!Auth::user()->hasRole('admin_setrass'))
                        $q->where('usuario_asignado_id',Auth::id());
                });


    }

    public function updatingBusqueda()
    {
        $this->resetPage();
    }
    public function updatingFechaIngresoDesde()
    {
        $this->resetPage();
    }
    public function updatingFechaIngresoHasta()
    {
        $this->resetPage();
    }
    public function updatingFechaNotificacionDesde()
    {
        $this->resetPage();
    }
    public function updatingFechaNotificacionHasta()
    {
        $this->resetPage();
    }
    public function updatingEstatus()
    {
        $this->resetPage();
    }
    public function updatingCobrarDesde()
    {
        $this->resetPage();
    }
    public function updatingCobrarHasta()
    {
        $this->resetPage();
    }
    public function updatingCobradoDesde()
    {
        $this->resetPage();
    }
    public function updatingCobradoHasta()
    {
        $this->resetPage();
    }

    public function updatingCobradoInteresesHasta()
    {
        $this->resetPage();
    }
    public function updatingCobradoInteresesDesde()
    {
        $this->resetPage();
    }
    public function updatingAsignado()
    {
        $this->resetPage();
    }

    public function updatingEntries()
    {
        $this->resetPage();
    }
    public function updatingPage()
    {
        $this->dispatchBrowserEvent('initTooltip');
    }

    public function resetFiltros(){
        $this->fecha_ingreso_desde = null;
        $this->fecha_ingreso_hasta = null;
        $this->fecha_notificacion_desde = null;
        $this->fecha_notificacion_hasta = null;
        $this->estatus = [];
        $this->cobrar_desde = null;
        $this->cobrar_hasta = null;
        $this->cobrado_desde = null;
        $this->cobrado_hasta = null;
        $this->asignado = null;
        $this->cobrado_intereses_hasta = null;
        $this->cobrado_intereses_desde = null;
        $this->resetPage();
    }

    public function removeFiltro($propiedad){
        if($propiedad=='fecha_ingreso'){
            $this->fecha_ingreso_desde=null;
            $this->fecha_ingreso_hasta=null;
        }
        elseif($propiedad=='fecha_notificacion'){
            $this->fecha_notificacion_desde=null;
            $this->fecha_notificacion_hasta=null;
        }
        elseif($propiedad=='monto_cobrar'){
            $this->cobrar_desde=null;
            $this->cobrar_hasta=null;
        }
        elseif($propiedad=='monto_cobrado'){
            $this->cobrado_desde=null;
            $this->cobrado_hasta=null;
        }
        elseif($propiedad=='monto_cobrado_intereses'){
            $this->cobrado_intereses_desde=null;
            $this->cobrado_intereses_hasta=null;
        }
        elseif($propiedad=='estatus'){
            $this->estatus=[];
        }else{
            $this->$propiedad = null;
        }
    }
    public function change($propiedad,$valor){
        $this->$propiedad = $valor && $valor != "" ? $valor : null;
        $this->resetPage();
    }
    public function export(){
        $registros = [];
        foreach ($this->getCasos()->get() as $caso){
            $registros[]=[
                $caso->numero_expediente,
                $caso->numero_expediente_pgr??'Pendiente',
                $caso->empresa->razon_social??'Sin información',
                $caso->fecha_notificacion  ? $caso->fecha_notificacion->format('d-m-Y') : '',
                $caso->fecha_recepcion_pgr ? $caso->fecha_recepcion_pgr->format('d-m-Y') : '',
                lempiras($caso->total_multa),
                lempiras($caso->total_cobrado),
                lempiras($caso->total_cobrado_intereses),
                $caso->asignado ? $caso->asignado->nombre_completo : 'Sin asignación',
                $caso->inspector ? $caso->inspector->nombre_completo : 'Sin asignación',
                $caso->estatus->nombre
            ];
        }
        registroBitacora(null,A_EXPORTAR,C_BANDEJA_CASOS,null,"Exportación de información de la bandeja de casos");
        return Excel::download(new CasosExport($registros), 'casos_' . date('y-m-d-H') . '.csv');
    }
}
