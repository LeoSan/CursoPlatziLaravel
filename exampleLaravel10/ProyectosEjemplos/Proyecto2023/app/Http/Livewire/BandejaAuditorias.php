<?php

namespace App\Http\Livewire;

use App\Models\Catalogo;
use App\Models\CatalogoElemento;
use App\Models\Denuncia;
use App\Models\PlaneacionAuditoriaEjecucion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class BandejaAuditorias extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'busqueda','mes', 'estatus', 'departamento', 'municipio', 'region', 'tipo_inspeccion', 'actividad_economica', 'asignado', 'cafta',
    ];

    public $tipo = null,
        $entries = 10,
        $busqueda = null,
        $filtrado = false,
        $mes = null,
        $estatus = null,
        $departamento = null,
        $municipio = null,
        $region = null,
        $tipo_inspeccion = null,
        $actividad_economica = null,
        $asignado = null,
        $cafta = null;

    /**
     * Description : Permite montar el componenente y estar listo cuando se necesite
     *
     * @return void
     */
    public function mount()
    {
        $catEstatus = Catalogo::whereCodigo('estatus_auditorias')->orderBy('id')->first();
        $catDeparta = Catalogo::whereCodigo('departamentos')->orderBy('id')->first();
        $catMunicipios = Catalogo::whereCodigo('municipios')->orderBy('id')->first();
        $catRegion = Catalogo::whereCodigo('regiones_setrass')->orderBy('id')->first();
        $catTipo = Catalogo::whereCodigo('tipos_inspeccion')->orderBy('id')->first();
        $catActividad = Catalogo::whereCodigo('actividades_economicas')->orderBy('id')->first();

        $area_adscripcion_id = CatalogoElemento::where('codigo', '=', 'ati')->value('id');

        $this->cat_departa = $catDeparta->elementos->sortBy('nombre');
        $this->cat_departa_array = $catDeparta->elementos->sortBy('nombre')->pluck('nombre', 'id')->toArray();

        if ($this->departamento) {
            $this->cat_municipio = $catMunicipios->elementos->where('parent_id', $this->departamento)->sortBy('nombre');
            $this->cat_municipio_array = $catMunicipios->elementos->where('parent_id', $this->departamento)->sortBy('nombre')->pluck('nombre', 'id')->toArray();

        } else {
            $this->cat_municipio = $catMunicipios->elementos->sortBy('nombre');
            $this->cat_municipio_array = $catMunicipios->elementos->sortBy('nombre')->pluck('nombre', 'id')->toArray();
        }

        $this->cat_region = $catRegion->elementos->sortBy('nombre');
        $this->cat_region_array = $catRegion->elementos->sortBy('nombre')->pluck('nombre', 'id')->toArray();

        $meses = [];

        for ($i = 1; $i <= 12; $i++) {
            $fecha = \Carbon\Carbon::parse("2023-$i-01");
            $mesTraducido = $fecha->translatedFormat('F');
            $meses[$i] = ucfirst($mesTraducido);
        }
        $this->cat_meses = $meses;

        $this->cat_meses_array = $meses;

        $this->cat_estatus = $catEstatus->elementos->sortBy('nombre');
        $this->cat_estatus_array = $catEstatus->elementos->sortBy('nombre')->pluck('nombre', 'id')->toArray();

        $this->cat_tipo_inspeccion = $catTipo->elementos->sortBy('nombre');
        $this->cat_tipo_inspeccion_array = $catTipo->elementos->sortBy('nombre')->pluck('nombre', 'id')->toArray();

        $this->cat_actividad = $catActividad->elementos->sortBy('nombre');
        $this->cat_actividad_array = $catActividad->elementos->sortBy('nombre')->pluck('nombre', 'id')->toArray();

        $this->cat_asignado = User::select('users.id', 'users.complete_name')->where('area_adscripcion_id', $area_adscripcion_id)->where('cargo', "!=", "Denunciante")->get();
        $this->cat_asignado_array = User::select('users.id', 'users.complete_name')->where('area_adscripcion_id', $area_adscripcion_id)->pluck('complete_name', 'id')->toArray();

        $this->cat_cafta = [
            'No' => 'No',
            'Si' => 'Sí',
        ];

        $this->cat_cafta_array = $this->cat_cafta;
    }

    public function render()
    {
        $this->filtrado = ($this->mes || $this->estatus || $this->departamento || $this->region || $this->tipo_inspeccion || $this->actividad_economica || $this->cafta || $this->asignado||$this->busqueda);
        $filtros = [
            'mes' => [
                'texto' => 'Mes:',
                'valor' => $this->mes ? $this->cat_meses[$this->mes] : null
            ],
            'estatus' => [
                'texto' => 'Estatus:',
                'valor' => $this->estatus ? $this->cat_estatus_array[$this->estatus] : null
            ],
            'departamento' => [
                'texto' => 'Departamento:',
                'valor' => $this->departamento ? $this->cat_departa_array[$this->departamento] : null
            ],
            'municipio' => [
                'texto' => 'Municipio:',
                'valor' => $this->municipio ? $this->cat_municipio_array[$this->municipio] : null
            ],
            'region' => [
                'texto' => 'Región:',
                'valor' => $this->region ? $this->cat_region_array[$this->region] : null
            ],
            'tipo_inspeccion' => [
                'texto' => 'Tipo de inspección',
                'valor' => $this->tipo_inspeccion ? $this->cat_tipo_inspeccion_array[$this->tipo_inspeccion] : null
            ],
            'actividad_economica' => [
                'texto' => 'Actividad económica',
                'valor' => $this->actividad_economica ? $this->cat_actividad_array[$this->actividad_economica] : null
            ],
            'asignado' => [
                'texto' => 'Auditor asignado:',
                'valor' => $this->asignado ? $this->cat_asignado_array[$this->asignado] : null
            ],
            'cafta' => [
                'texto' => 'CAFTA:',
                'valor' => $this->cafta ? $this->cat_cafta_array[$this->cafta] : null
            ],
            'busqueda'=>[
                'texto'=>'Texto:',
                'valor'=>$this->busqueda,
            ]
        ];

        $auditorias = $this->getAuditorias();

        return view('livewire.bandeja-auditorias', [
            'auditorias' => $auditorias->paginate($this->entries),
            'filtrado' => $this->filtrado, 'filtros' => $filtros
        ]);
    }

    public function getAuditorias(){
        $auditorias = PlaneacionAuditoriaEjecucion::with('grupo')->when($this->estatus, function($query){
            $query->where('estatus_id',$this->estatus);
        })->when($this->busqueda, function($query){
            $query->whereRaw(" translate(lower(num_auditoria), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') ");
        })->when($this->mes, function($query){
            $query->where('mes',$this->mes);
        })->whereHas('grupo', function($query){
            if ($this->departamento) {
                $query->where('departamento_id',$this->departamento);
            }
        })->whereHas('grupo', function($query){
            if ($this->municipio) {
                $query->where('municipio_id',$this->municipio);
            }
        })->whereHas('grupo', function($query){
            if ($this->region) {
                $query->where('region_id',$this->region);
            }
        })->whereHas('grupo', function($query){
            if ($this->tipo_inspeccion) {
                $query->where('tipo_inspeccion_id',$this->tipo_inspeccion);
            }
        })->whereHas('grupo', function($query){
            if ($this->actividad_economica) {
                $query->where('actividad_economica_id',$this->actividad_economica);
            }
        })->whereHas('grupo', function($query){
            if ($this->cafta) {
                $query->where('cafta',$this->cafta);
            }
        })->when($this->asignado, function($query){
            $query->where('auditor_asignado_id',$this->asignado);
        })->when(Auth::id(),function($query){
            if(Auth::user()->hasRole('jefe_auditoria_setrass_ati'))
                $query->where('auditor_asignado_id', '>', 0);
            else if(Auth::user()->can('auditorias_ejecucion'))
                $query->where('auditor_asignado_id',Auth::id());
        });
        return $auditorias;
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
    public function updatingDepartamento()
    {
        $this->resetPage();
    }
    public function updatedDepartamento()
    {
        $catMunicipios = Catalogo::whereCodigo('municipios')->orderBy('nombre', 'ASC')->first();
        $this->cat_municipio = [];
        $this->cat_municipio = $catMunicipios->elementos->where('parent_id', $this->departamento)->sortBy('nombre');
        $this->cat_municipio_array = $catMunicipios->elementos->where('parent_id', $this->departamento)->sortBy('nombre')->pluck('nombre', 'id')->toArray();
        $this->municipio = null;
        $this->region = null;
    }
    public function updatingMunicipio()
    {
        $this->resetPage();
    }

    public function updatedMunicipio()
    {
        $catalogo_munucipio_id = Catalogo::whereCodigo('municipios')->first()->id;
        $oficina_regional = DB::select('SELECT reg.id, reg.nombre region, reg.codigo region_codigo FROM catalogo_elementos mun LEFT JOIN catalogo_elementos reg ON mun.categoria_id = reg.id  WHERE mun.catalogo_id = '.$catalogo_munucipio_id.'  AND mun.id = ?', [$this->municipio]);

        $this->region = $oficina_regional[0]->id;
    }

    public function updatedRegion()
    {
        $this->departamento = null;
        $this->municipio = null;
    }

    public function updatingRegion()
    {
        $this->resetPage();
    }

    public function updatingMes()
    {
        $this->resetPage();
    }

    public function updatingEstatus()
    {
        $this->resetPage();
    }

    public function updatingInspeccion()
    {
        $this->resetPage();
    }

    public function updatingActividad()
    {
        $this->resetPage();
    }

    public function updatingAsignado()
    {
        $this->resetPage();
    }

    public function updatingCafta()
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
        $this->mes = null;
        $this->estatus = null;
        $this->departamento = null;
        $this->region = null;
        $this->tipo_inspeccion = null;
        $this->actividad_economica = null;
        $this->asignado = null;
        $this->cafta = null;
        $this->busqueda = null;
    }
    public function removeFiltro($k){
        $this->$k = null;
    }
    public function change($k,$v){
        $this->$k = $v && $v != "" ? $v : null;
        $this->resetPage();
    }
}
