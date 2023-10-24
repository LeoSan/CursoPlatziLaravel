<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use DateTime;
use App\Models\{Catalogo, CatalogoElemento, Bitacora, User};
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class BandejaBitacora extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'busqueda', 'dependencia','accion', 'fecha_desde','fecha_hasta', 'componente'
    ];

    public $tipo = null,
        $entries = 10,
        $filtrado = false,

        $usuario_id = null,
        $busqueda = null,
        $dependencia = null,
        $usuarios = [],
        $fecha_desde = null,
        $fecha_hasta = null,
        $componente = null,
        $accion = null,

        $cat_dependencia = null,
        $cat_dependencia_array = null,
        $cat_usuarios = null,
        $cat_usuarios_array = null,

        $cat_componente_array = null,
        $cat_accion_array = null;
    /**
     * Description : Permite montar el componenente y estar listo cuando se necesite
     *
     * @return void
     */
    public function mount(){
        $catDependencia    = Catalogo::whereCodigo('dependencias')->orderBy('nombre', 'ASC')->first();
        $catUsuarios       = User::select('users.id', 'users.complete_name')->where('cargo', '<>','Denunciante')->orderBy('name', 'ASC')->get();
        $catUsuarios_array = User::where('cargo', '<>','Denunciante')->orderBy('name', 'ASC')->pluck('complete_name','id')->toArray();

        if (auth()->user()->dependencia_id == CatalogoElemento::where('codigo', 'pgr')->first()->id){
            $catUsuarios = User::select('users.id','users.complete_name')->where('dependencia_id', '=', auth()->user()->dependencia_id)->where('cargo', '<>','Denunciante')->orderBy('name', 'ASC')->get();
            $catUsuarios_array = User::where('dependencia_id', '=', auth()->user()->dependencia_id)->where('cargo', '<>','Denunciante')->orderBy('name', 'ASC')->pluck('complete_name','id')->toArray();
        }

        $this->cat_dependencia = CatalogoElemento::whereCatalogoId($catDependencia->id)->orderBy('nombre', 'ASC')->get();
        $this->cat_dependencia_array = CatalogoElemento::whereCatalogoId($catDependencia->id)->orderBy('orden')->pluck('nombre','id')->toArray();

        $this->cat_usuarios = $catUsuarios;
        $this->cat_usuarios_array = $catUsuarios_array;

        $this->cat_componente_array = $this->getArrayComponenteBitacora();
        $this->cat_accion_array = $this->getArrayAccionBitacora();
    }
    /**
     * Description : Permite renderizar el componente
     *
     * return View
     */
    public function render()
    {
        $this->filtrado=(($this->fecha_desde&&$this->fecha_hasta)|| $this->dependencia||$this->componente||$this->accion||$this->usuarios);

        $filtros =  [
            'dependencia'=>[
                'texto'=>'Dependencia:',
                'valor'=>$this->dependencia ? $this->cat_dependencia_array[$this->dependencia] : null
            ],
            'fecha'=>[
                'texto'=>'Fecha:',
                'valor'=>($this->fecha_desde&&$this->fecha_hasta) ? 'Del '.Carbon::create($this->fecha_desde)->format('d/m/Y').' al '.Carbon::create($this->fecha_hasta)->format('d/m/Y') : null,
                'error'=>false
            ],
            'componente'=>[
                'texto'=>'Componente:',
                'valor'=>$this->componente ? $this->cat_componente_array[$this->componente] : null
            ],
            'accion'=>[
                'texto'=>'Accion:',
                'valor'=>$this->accion ? $this->cat_accion_array[$this->accion] : null
            ],
            'usuarios'=>[
                'texto'=>'Usuario:',
                'valor'=> count($this->usuarios) > 0 ? ( count($this->usuarios) > 2 ? 'Tienes 3 o más Seleccionados' :  implode(  ', ', array_intersect_key($this->cat_usuarios_array, array_flip($this->usuarios)) )) : null
            ],
        ];
        if( !($this->fecha_desde&&$this->fecha_hasta) && ($this->fecha_desde||$this->fecha_hasta) ){
            $filtros['fecha']['error']="Introduzca ambas fechas para filtrar.";
        }elseif(($this->fecha_desde&&$this->fecha_hasta)&&(Carbon::create($this->fecha_desde)>Carbon::create($this->fecha_hasta))){
            $filtros['fecha']['error']="La fecha final es menor a la inicial.";
            $filtros['fecha']['valor']=null;
        }

        $bitacoras = $this->getBitacora();
        return view('livewire.bandeja-bitacora',['bitacoras'=>$bitacoras->paginate($this->entries),'filtrado'=>$this->filtrado,'filtros'=>$filtros]);
    }

    public function getBitacora(){
            $bitacoras = Bitacora::when( ($this->fecha_desde&&$this->fecha_hasta) && (Carbon::create($this->fecha_desde)<=Carbon::create($this->fecha_hasta)),function($q){
                $q->whereRaw("created_at::date >= '$this->fecha_desde' AND created_at::date <= '$this->fecha_hasta'");
            })->when($this->busqueda && strlen($this->busqueda)>2,function($q){
                $q->where(function($q){
                    $q->whereRaw("(
                        translate(lower(componente), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu')
                        OR translate(lower(accion), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu')
                        OR translate(lower(descripcion), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu')
                        OR translate(lower(usuario_ip), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu')
                    )");
                });
            })->when($this->dependencia, function($query){
                $query->where('dependencia_id',$this->dependencia);
            })->when($this->usuario_id, function($query){
                $query->where('usuario_id',$this->usuario_id);
            })->when($this->componente, function($query){
                $query->where('componente',$this->componente);
            })->when($this->accion, function($query){
                $query->where('accion',$this->accion);
            })->when( auth()->user()->dependencia_id , function($query){
                if(auth()->user()->dependencia_id == CatalogoElemento::where('codigo', 'setrass')->first()->id){
                    $dependencia_pgr = CatalogoElemento::where('codigo', 'pgr')->first()->id;
                    $dependencia_setras = CatalogoElemento::where('codigo', 'setrass')->first()->id;
                    $query->whereIn('dependencia_id', [$dependencia_setras , $dependencia_pgr]);
                }else if ($this->usuario_id){
                    $query->where('usuario_id',$this->usuario_id);
                }else if(auth()->user()->dependencia_id == CatalogoElemento::where('codigo', 'pgr')->first()->id){
                    $dependencia_pgr = CatalogoElemento::where('codigo', 'pgr')->first()->id;
                    $query->whereIn('dependencia_id', [$dependencia_pgr]);
                }else{
                    $query->where('usuario_id',Auth::id());
                }
            })->when($this->usuarios, function ($query) {
                return $query->where(function ($query) {
                    //Log::info("arrg_in ->".implode(',',$this->usuarios));
                    $aux = implode(',',$this->usuarios);
                    $aux_arry = explode(',',  $aux);
                    $query->whereIn('usuario_id', $aux_arry);
                });
            });
        return $bitacoras;
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
    public function updatingfechadesde()
    {
        $this->resetPage();
    }
    public function updatingfechahasta()
    {
        $this->resetPage();
    }    
    public function updatingDependencia()
    {
        $this->resetPage();
    }
    public function updatingComponente()
    {
        $this->resetPage();
    }
    public function updatingAccion()
    {
        $this->resetPage();
    }
    public function updatingUsuarios()
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
        $this->busqueda = null;
        $this->usuarios = [];
        $this->dependencia = null;
        $this->fecha_desde = null;
        $this->fecha_hasta = null;
        $this->componente = null;
        $this->accion = null;
    }
    public function removeFiltro($propiedad){
        if($propiedad=='fecha'){
            $this->fecha_desde=null;
            $this->fecha_hasta=null;
        }else{
            $this->$propiedad =  $propiedad == 'usuarios'? [] : null;
        }
    }
    public function change($k,$v){
        $this->$k = $v && $v != "" ? $v : null;
        $this->resetPage();
    }
    public function getArrayComponenteBitacora(){
        $catComponente = Bitacora::groupBy('componente')->orderBy('componente', 'ASC')->pluck('componente')->toArray();
        $tempCatCompo  = [];
        foreach ($catComponente as $key => $value) {
                $tempCatCompo[$value] = $value;
        }
        return $tempCatCompo;
    }
    public function getArrayAccionBitacora(){
        $catAccion = Bitacora::groupBy('accion')->orderBy('accion', 'ASC')->pluck('accion')->toArray();
        $tempCatAccion  = [];
        foreach ($catAccion as $key => $value) {
                $tempCatAccion[$value] = $value;
        }
        return $tempCatAccion;
    }
}
