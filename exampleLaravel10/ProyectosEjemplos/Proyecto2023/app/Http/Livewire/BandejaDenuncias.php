<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use DateTime;
use App\Models\{Catalogo, CatalogoElemento, Denuncia, User, DiaNoHabil};
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\error;


class BandejaDenuncias extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = [
        'busqueda', 'fecha_denuncia_desde','fecha_denuncia_hasta','estatus', 'departamento', 'asignado', 'origen', 'recepcion'
    ];
    public $tipo = null,
        $entries = 10,
        $filtrado = false,
        $busqueda = null,
        $fecha_denuncia_desde = null,
        $fecha_denuncia_hasta = null,
        $estatus = null,
        $departamento = null,
        $asignado = null,
        $origen = null,
        $recepcion = null,

        $cat_estatus = null,
        $cat_estatus_array = null,
        $cat_origen = null,
        $cat_origen_array = null,
        $cat_medio_recepcion = null,
        $cat_medio_recepcion_array = null,
        $cat_departa = null,
        $cat_departa_array = null,
        $cat_auditors = null,
        $cat_auditors_array = null,
        $estatus_providencia = null;

    /**
     * Description : Permite montar el componenente y estar listo cuando se necesite
     *
     * @return void
     */
    public function mount(){
        $catEstatus = Catalogo::whereCodigo('estatus_denuncia_ati')->orderBy('nombre', 'ASC')->first();
        $catOrigen  = Catalogo::whereCodigo('origen_denuncia')->orderBy('nombre', 'ASC')->first();
        $catDeparta = Catalogo::whereCodigo('departamentos')->orderBy('nombre', 'ASC')->first();
        $area_adscripcion_id =  CatalogoElemento::where('codigo', '=', 'ati')->value('id');
        $medio_recepcion_id  =  Catalogo::where('codigo', '=', 'medio_recepcion')->first();

        $this->cat_estatus = CatalogoElemento::whereCatalogoId($catEstatus->id)->orderBy('nombre', 'ASC')->get();
        $this->cat_estatus_array = CatalogoElemento::whereCatalogoId($catEstatus->id)->orderBy('orden')->pluck('nombre','id')->toArray();

        $this->cat_origen = CatalogoElemento::whereCatalogoId($catOrigen->id)->orderBy('nombre', 'ASC')->get();
        $this->cat_origen_array = CatalogoElemento::whereCatalogoId($catOrigen->id)->orderBy('orden')->pluck('nombre','id')->toArray();

        $this->cat_medio_recepcion = CatalogoElemento::whereCatalogoId($medio_recepcion_id->id)->orderBy('nombre', 'ASC')->get();
        $this->cat_medio_recepcion_array = CatalogoElemento::whereCatalogoId($medio_recepcion_id->id)->orderBy('orden')->pluck('nombre','id')->toArray();

        $this->cat_departa = CatalogoElemento::whereCatalogoId($catDeparta->id)->orderBy('orden')->get();
        $this->cat_departa_array = CatalogoElemento::whereCatalogoId($catDeparta->id)->orderBy('orden')->pluck('nombre','id')->toArray();

        $this->cat_auditors = User::select('users.id', 'users.complete_name')->where('area_adscripcion_id', $area_adscripcion_id)->where('cargo',"!=","Denunciante")->get();
        $this->cat_auditors_array = User::select('users.id', 'users.complete_name')->where('area_adscripcion_id', $area_adscripcion_id)->pluck('complete_name','id')->toArray();

        $this->estatus_providencia = CatalogoElemento::where('codigo', '=', 'providencia')->value('id');
    }
    /**
     * Description : Permite renderizar el componente
     *
     * return View
     */
    public function render()
    {
        $this->filtrado=(($this->fecha_denuncia_desde&&$this->fecha_denuncia_hasta)||$this->estatus||$this->asignado||$this->busqueda||$this->origen||$this->recepcion||$this->departamento);
        $filtros =  [
            'fecha_denuncia'=>[
                'texto'=>'Fecha de la denuncia:',
                'valor'=>($this->fecha_denuncia_desde&&$this->fecha_denuncia_hasta) ? 'Del '.Carbon::create($this->fecha_denuncia_desde)->format('d/m/Y').' al '.Carbon::create($this->fecha_denuncia_hasta)->format('d/m/Y') : null,
                'error'=>false
            ],
            'estatus'=>[
                'texto'=>'Estatus:',
                'valor'=>$this->estatus ? $this->cat_estatus_array[$this->estatus] : null
            ],
            'departamento'=>[
                'texto'=>'Departamento:',
                'valor'=>$this->departamento ? $this->cat_departa_array[$this->departamento] : null
            ],
            'origen'=>[
                'texto'=>'Origen:',
                'valor'=>$this->origen ? $this->cat_origen_array[$this->origen] : null
            ],
            'recepcion'=>[
                'texto'=>'Medio recepción:',
                'valor'=>$this->recepcion ? $this->cat_medio_recepcion_array[$this->recepcion] : null
            ],
            'asignado'=>[
                'texto'=>'Auditor asignado:',
                'valor'=>$this->asignado ? $this->cat_auditors_array[$this->asignado] : null
            ],
            'busqueda'=>[
                'texto'=>'Texto:',
                'valor'=>$this->busqueda,
            ]
        ];
        if( !($this->fecha_denuncia_desde&&$this->fecha_denuncia_hasta) && ($this->fecha_denuncia_desde||$this->fecha_denuncia_hasta) ){
            $filtros['fecha_denuncia']['error']="Introduzca ambas fechas para filtrar.";
        }elseif(($this->fecha_denuncia_desde&&$this->fecha_denuncia_hasta)&&(Carbon::create($this->fecha_denuncia_desde)>Carbon::create($this->fecha_denuncia_hasta))){
            $filtros['fecha_denuncia']['error']="La fecha final es menor a la inicial.";
            $filtros['fecha_denuncia']['valor']=null;
        }

        $denuncias = $this->getDenuncias();
        return view('livewire.bandeja-denuncias',['denuncias'=>$denuncias->paginate($this->entries),'filtrado'=>$this->filtrado,'filtros'=>$filtros, 'estatus_providencia'=>$this->estatus_providencia]);
    }

    public function getDenuncias(){
        $usuario = User::findOrFail(Auth::id());
        if($usuario->roles()->first()->name == 'jefe_regional'){
                $denuncias = Denuncia::when($this->estatus, function($query){
                $query->where('estatus_id',$this->estatus);
            })->when( ($this->fecha_denuncia_desde&&$this->fecha_denuncia_hasta) && (Carbon::create($this->fecha_denuncia_desde)<=Carbon::create($this->fecha_denuncia_hasta)),function($q){
                    $q->whereRaw("created_at::date >= '$this->fecha_denuncia_desde' AND created_at::date <= '$this->fecha_denuncia_hasta'");
            })->when($this->busqueda, function($query){
                $query->whereRaw(" translate(lower(num_expediente_dgit), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
                $query->whereRaw(" translate(lower(num_expediente), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
                $query->orWhereRaw(" translate(lower(nombre_denunciante), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
                $query->orWhereRaw(" translate(lower(primer_apellido_denunciante), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
                $query->orWhereRaw(" translate(lower(segundo_apellido_denunciante ), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
            })->whereHas('gestion',function($query){
                $query->where('usuario_asignado_id',Auth::id());
            });
        }else{
            $denuncias = Denuncia::when($this->estatus, function($query){
                $query->where('estatus_id',$this->estatus);
            })->when( ($this->fecha_denuncia_desde&&$this->fecha_denuncia_hasta) && (Carbon::create($this->fecha_denuncia_desde)<=Carbon::create($this->fecha_denuncia_hasta)),function($q){
                $q->whereRaw("created_at::date >= '$this->fecha_denuncia_desde' AND created_at::date <= '$this->fecha_denuncia_hasta'");
            })->when($this->asignado, function($query){
                $query->where('usuario_asignado_id',$this->asignado);
            })->when($this->origen, function($query){
                $query->where('origen_id',$this->origen);
            })->when($this->recepcion, function($query){
                $query->where('medio_recepcion_id',$this->recepcion);
            })->when($this->departamento, function($query){
                $query->where('region_departamento_id',$this->departamento);
            })->when($this->busqueda, function($query){
                $query->whereRaw(" translate(lower(folio), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
                $query->orWhereRaw(" translate(lower(nombre_denunciante), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
                $query->orWhereRaw(" translate(lower(sindicato_denunciante), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
                $query->orWhereRaw(" translate(lower(correo_denunciante), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
                $query->orWhereRaw(" translate(lower(num_expediente_dgit), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
                $query->orWhereRaw(" translate(lower(num_expediente), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
                $query->orWhereRaw(" translate(lower(nombre_denunciante), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
                $query->orWhereRaw(" translate(lower(primer_apellido_denunciante), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
                $query->orWhereRaw(" translate(lower(segundo_apellido_denunciante ), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");

            })->when(Auth::id(),function($query){
                if(Auth::user()->hasRole('denunciante'))
                    $query->where('correo_denunciante', Auth::user()->email);
                else if(Auth::user()->can('ver_toda_bandeja_denuncias'))
                    $query->where('usuario_asignado_id', '>', 0);
                else
                    $query->whereHas('gestion',function($q){

                    if(Auth::user()->hasRole('auditor_setrass_ati'))
                        $q->where('usuario_asignado_id',Auth::id());
                });
            });

        }
        return $denuncias;

    }
    /**
     * Description : Permite limpiar el componente un refresh
     *
     * @return void
     */
    public function updatingbusqueda()
    {
        $this->resetPage();
    }
    public function updatingFechadenunciadesde()
    {
        $this->resetPage();
    }
    public function updatingFechadenunciahasta()
    {
        $this->resetPage();
    }
    public function updatingEstatus()
    {
        $this->resetPage();
    }
    public function updatingAsignado()
    {
        $this->resetPage();
    }
    public function updatingOrigen()
    {
        $this->resetPage();
    }
    public function updatingRecepcion()
    {
        $this->resetPage();
    }
    public function updatingDepartamento()
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
        $this->fecha_denuncia_desde = null;
        $this->fecha_denuncia_hasta = null;
        $this->estatus = null;
        $this->asignado = null;
        $this->busqueda = null;
        $this->origen = null;
        $this->recepcion = null;
        $this->departamento = null;
    }

    public function removeFiltro($k){
        if($k=='fecha_denuncia'){
            $this->fecha_denuncia_desde=null;
            $this->fecha_denuncia_hasta=null;
        }
        else
            $this->$k = null;
    }

    public function change($k,$v){
        $this->$k = $v && $v != "" ? $v : null;
        $this->resetPage();
    }


    public function calculoDiasPlazo($denuncia){
        switch ($denuncia->estatus->codigo) {
            case 'solicitud_expediente':
                $plazo = intval(config('app.plazo_solicitud_expediente'));
              break;
            case 'providencia':
                $plazo = intval(config('app.plazo_vencimiento_providencias'));
              break;
            case 'admitida':
                $plazo = intval(config('app.plazo_vencimiento_denuncia'));
              break;
            default:
              $plazo = 0;
        }
        $fecha_estatus = $denuncia->gestion()->whereHas('estatus',function($q)use($denuncia){
            $q->whereCodigo($denuncia->estatus->codigo);
        })->first();

        $fechaInicio = date('Y-m-d', strtotime($fecha_estatus->created_at));
        $inicio = Carbon::create($fechaInicio. ' 00:00:00');
        $fin = Carbon::create(date('Y-m-d'). ' 00:00:00');
        $diasTranscurridos = $inicio->diffInDaysFiltered(function(Carbon $date) {
            $inhabil = DiaNoHabil::whereFecha($date->format('Y-m-d'))->first();
            if(!$inhabil)
                return $date->isWeekday();
        }, $fin);

        $diasFeriados = DiaNoHabil::where('anio', '=',date('Y') )->pluck('fecha')->toArray();
        if (in_array($fin->format('Y-m-d'), $diasFeriados) || $fin->isWeekend()) {
            $diasTranscurridos--;
        }

        $total_dias = $plazo - $diasTranscurridos;
        return ($total_dias == 1)? " $total_dias Día restante ": "$total_dias Días restantes" ;
    }
}
