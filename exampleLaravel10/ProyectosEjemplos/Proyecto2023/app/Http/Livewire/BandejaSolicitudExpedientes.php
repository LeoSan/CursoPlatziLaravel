<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use DateTime;
use App\Models\{Catalogo, CatalogoElemento, PlaneacionSolicitudExpediente, User, DiaNoHabil};
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


class BandejaSolicitudExpedientes extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = [
        'region', 'mes', 'fecha_desde', 'fecha_hasta', 'auditor', 'busqueda'
    ];
    public $tipo = null,
        $entries = 10,
        $filtrado = false,
        $region = null,
        $mes = null,
        $fecha_solicitud = null,
        $fecha_desde = null,
        $fecha_hasta = null,
        $auditor = null,
        $estatus = null,

        $busqueda = null,
        
        $cat_region = null,
        $cat_region_array = null,
        
        $cat_estatus = null,
        $cat_estatus_array = null,

        $cat_auditors = null,
        $cat_auditors_array = null,

        $cat_meses = null, 
        $cat_meses_array = null;
    /**
     * Description : Permite montar el componenente y estar listo cuando se necesite
     *
     * @return void
     */
    public function mount(){
        
        $estatus_solicitud_expediente   = Catalogo::whereCodigo('estatus_solicitud_expediente')->first();
        
        $catregion = Catalogo::whereCodigo('regiones_setrass')->orderBy('nombre', 'ASC')->first();
        $area_adscripcion_id =  CatalogoElemento::where('codigo', '=', 'ati')->value('id');

        $this->cat_estatus = CatalogoElemento::where('catalogo_id', $estatus_solicitud_expediente->id)->orderBy('orden')->get();
        $this->cat_estatus_array = CatalogoElemento::whereCatalogoId($estatus_solicitud_expediente->id)->orderBy('orden')->pluck('nombre','id')->toArray();

        $this->cat_region = CatalogoElemento::whereCatalogoId($catregion->id)->orderBy('orden')->get();
        $this->cat_region_array = CatalogoElemento::whereCatalogoId($catregion->id)->orderBy('orden')->pluck('nombre','id')->toArray();
        
        $this->cat_auditors = User::select('users.id', 'users.complete_name')->where('area_adscripcion_id', $area_adscripcion_id)->where('cargo',"!=","Denunciante")->get();
        $this->cat_auditors_array = User::select('users.id', 'users.complete_name')->where('area_adscripcion_id', $area_adscripcion_id)->pluck('complete_name','id')->toArray();

        $meses = [];

        for ($i = 1; $i <= 12; $i++) {
            $fecha = \Carbon\Carbon::parse("2023-$i-01");
            $mesTraducido = $fecha->translatedFormat('F');
            $meses[$i] = ucfirst($mesTraducido);
        }
        $this->cat_meses = $meses;
        $this->cat_meses_array = $meses;
    }
    /**
     * Description : Permite renderizar el componente
     *
     * return View
     */
    public function render()
    {
        $this->filtrado=(($this->fecha_desde&&$this->fecha_hasta) || $this->region || $this->mes ||  $this->auditor || $this->estatus || $this->busqueda);
        $filtros =  [
            'fecha_solicitud'=>[
                'texto'=>'Fecha:',
                'valor'=>($this->fecha_desde&&$this->fecha_hasta) ? 'Del '.Carbon::create($this->fecha_desde)->format('d/m/Y').' al '.Carbon::create($this->fecha_hasta)->format('d/m/Y') : null,
                'error'=>false
            ],
            'region'=>[
                'texto'=>'Regional:',
                'valor'=>$this->region ? $this->cat_region_array[$this->region] : null
            ],
            'mes'=>[
                'texto'=>'Mes:',
                'valor'=>$this->mes ? $this->cat_meses_array[$this->mes] : null
            ],
            'estatus'=>[
                'texto'=>'Estatus:',
                'valor'=>$this->estatus ? $this->cat_estatus_array[$this->estatus] : null
            ],
            'auditor'=>[
                'texto'=>'Auditor:',
                'valor'=>$this->auditor ? $this->cat_auditors_array[$this->auditor] : null
            ],
        ];

        if( !($this->fecha_desde&&$this->fecha_hasta) && ($this->fecha_desde||$this->fecha_hasta) ){
            $filtros['fecha_solicitud']['error']="Introduzca ambas fechas para filtrar.";
        }elseif(($this->fecha_desde&&$this->fecha_hasta)&&(Carbon::create($this->fecha_desde)>Carbon::create($this->fecha_hasta))){
            $filtros['fecha_solicitud']['error']="La fecha final es menor a la inicial.";
            $filtros['fecha_solicitud']['valor']=null;
        }
       
        $datosAuditorias = $this->getPlaneacionSolicitudExpediente();
        return view('livewire.bandeja-solicitud-expedientes',['datosAuditorias'=>$datosAuditorias->orderBy('fecha_solicitud','desc')->paginate($this->entries),'filtrado'=>$this->filtrado,'filtros'=>$filtros]);
    }

    public function getPlaneacionSolicitudExpediente(){
        $usuario = User::findOrFail(Auth::id());
        $datos = PlaneacionSolicitudExpediente::when($this->estatus, function($query){
            $query->where('estatus_id',$this->estatus);
        })->when($this->region, function($query){
            $query->where('regional_id',$this->region);
        })->when($this->mes, function($query){
            $query->where('mes',$this->mes);
        })->when($this->auditor, function($query){
            $query->where('auditor_realizo_solicitud',$this->auditor);
        })->when( ($this->fecha_desde&&$this->fecha_hasta) && (Carbon::create($this->fecha_desde)<=Carbon::create($this->fecha_hasta)),function($q){
            $q->whereRaw("created_at::date >= '$this->fecha_desde' AND created_at::date <= '$this->fecha_hasta'");
        });
        
        if($usuario->roles()->first()->name == 'jefe_auditoria_setrass_ati'){
            $datos->when($this->busqueda, function($query){
                //$query->where('numero_oficio', 'LIKE', "%{$this->busqueda}%"); 
                $query->whereRaw(" translate(lower(numero_oficio), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') "); 
            });
        }else if($usuario->roles()->first()->name == 'jefe_regional'){
            $datos->where('auditor_jefe_regional_id', Auth::id());
        }else{
            $datos->when($this->busqueda, function($query){
                $query->where('numero_oficio', 'LIKE', "%{$this->busqueda}%");  
            })->where('auditor_asignado_id', Auth::id());
        }
        return $datos;
    }

    /**
     * Description : Permite limpiar el componente un refresh
     *
     * @return void
     */
    public function updatingBusqueda()
    {
        $this->resetPage();
    }
    public function updatingregion()
    {
        $this->resetPage();

    }
    public function updatingmes()
    {
        $this->resetPage();

    }
    public function updatingauditor()
    {
        $this->resetPage();

    }
    public function updatingestatus()
    {
        $this->resetPage();

    }
    public function updatingfecha_desde()
    {
        $this->resetPage();
    }
    public function updatingfecha_hasta()
    {
        $this->resetPage();
    }    

    /**
     * Description : Permite limpiar el componente un refresh
     *
     * @return void
     */
    public function updatingEntries()
    {
        $this->resetPage();
    }
    /**
     * Description : ?
     *
     * @return void
     */
    public function updatingPage()
    {
        $this->dispatchBrowserEvent('initTooltip');
    }
    /**
     * Description : Permite limpiar el componente un refresh
     *
     * @return void
     */
    public function resetFiltros(){
        $this->busqueda = null;
        $this->fecha_desde = null;
        $this->fecha_hasta = null;
        $this->region = null;
        $this->auditor = null;
        $this->estatus = null;
        $this->mes = null;
    }
    /**
     * Description : Permite limpiar el componente un refresh
     *
     * @return void
     */
    public function removeFiltro($k){
        if($k=='fecha_solicitud'){
            $this->fecha_desde=null;
            $this->fecha_hasta=null;
        }
        else
            $this->$k = null;
    }
    /**
     * Description : ?
     *
     * @return void
     */
    public function change($k,$v){
        $this->$k = $v && $v != "" ? $v : null;
        $this->resetPage();
    }

    public function calculoDiasPlazo($fecha_solicitud, $total_plazo){

        $inicio = Carbon::create($fecha_solicitud)->addDay();
        $fin = Carbon::now();
        $diasTranscurridos = 0;
        $diasFeriados = $this->listFeriadoArray();
        while ($inicio->lessThan($fin)) {
            if (!in_array($inicio->format('Y-m-d'), $diasFeriados) && !$inicio->isWeekend()) {
                $diasTranscurridos++;
            }
            $inicio->addDay();
        }
        return  ($total_plazo - $diasTranscurridos);
    }    

    public function listFeriadoArray(){
        return DiaNoHabil::where('anio', '=',date('Y') )->pluck('fecha')->map(function ($dias_no_habile) {
            $date = Carbon::parse($dias_no_habile);
            return $dias_no_habile = $date->format('Y-m-d');             
        })->toArray(); 
    }
}
