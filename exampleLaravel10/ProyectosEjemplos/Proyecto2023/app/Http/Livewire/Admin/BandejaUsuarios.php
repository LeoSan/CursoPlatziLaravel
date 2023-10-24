<?php

namespace App\Http\Livewire\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BandejaUsuarios extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'busqueda', 'perfil'
    ];

    public
        $filtrado = false,
        $busqueda = null,
        $perfil = [],

        $roles = null,
        $roles_array = [],
        $usuario;

    public function mount(){
        $this->usuario = User::find(Auth::id());
        $this->roles = Role::where('dependencia_id','=',$this->usuario->dependencia_id)->where('name','!=','denunciante')->orderBy('show_name','asc')->pluck('show_name','id')->toArray();
        $this->roles[0] = "Todos";
    }
    public function render()
    {
        $this->filtrado= count($this->perfil)>0;
        $filtros =  [
            'perfil'=>[
                'texto'=>'Perfiles:',
                'valor'=> count($this->perfil) > 0 ? ( count($this->perfil) > 2 ? 'Tienes 3 o más Seleccionados' :  implode(  ', ', array_intersect_key($this->roles, array_flip($this->perfil)) )) : null
            ]
        ];
        $usuarios = $this->getUsuarios();
        return view('livewire.admin.bandeja-usuarios',compact('usuarios','filtros'));
    }

    public function getUsuarios(){
        return User::whereDependenciaId($this->usuario->dependencia_id)
            ->when($this->busqueda && strlen($this->busqueda)>2,function($q){
                $q->where(function($q){
                    $q->whereRaw(" translate(lower(complete_name), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu')
                    OR translate(lower(cargo), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') OR email ilike '%{$this->busqueda}%' ");
                });
            })
            ->when( count($this->perfil)>0 && !in_array(0,$this->perfil), function ($query) {
                return $query->where(function ($query) {
                    $query->whereIn('perfil_id', $this->perfil);
                });
            })
            ->paginate(20);
    }
    public function updatingBusqueda()
    {
        $this->resetPage();
    }
    public function updatingPerfil()
    {
        $this->resetPage();
    }
    public function resetFiltros(){
        $this->perfil = [];
        $this->resetPage();
    }

    public function removeFiltro($propiedad){
        if($propiedad=='perfil'){
            $this->perfil=[];
        }else{
            $this->$propiedad = null;
        }
    }
}
