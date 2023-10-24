<?php

namespace App\Http\Livewire\Admin;

use App\Models\Catalogo;
use App\Models\CatalogoElemento;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogoElementos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'busqueda','parent_id'
    ];

    public
        $filtrado=false,
        $catalogo_id = null,
        $parent_id = [],
        $padres = [],
        $busqueda = null,
        $catalogo,
        $elemento;

    public function mount(){
        $this->catalogo = Catalogo::find($this->catalogo_id);
        $this->padres = $this->catalogo->padre ? $this->catalogo->padre->elementos()->orderBy('nombre')->pluck('nombre','id')->toArray() : [];
        $this->padres[0]="Todos";
    }

    public function render()
    {
        $this->filtrado= count($this->parent_id)>0;
        $filtros =  [
            'parent_id'=>[
                'texto'=> $this->catalogo->padre ? $this->catalogo->padre->singular.':' : '',
                'valor'=> count($this->parent_id) > 0 ? ( count($this->parent_id) > 2 ? 'Tienes 3 o más seleccionados' :  implode(  ', ', array_intersect_key($this->padres, array_flip($this->parent_id)) )) : null
            ]
        ];
        $elementos = $this->getElementos();
        return view('livewire.admin.catalogo-elementos',compact('elementos','filtros'));
    }

    public function getElementos(){
        return CatalogoElemento::when(count($this->parent_id)>0 && !in_array(0,$this->parent_id),function($q){
                $q->whereIn('parent_id',$this->parent_id);
            })
            ->when($this->busqueda,function($q){
                $q->whereRaw(" (translate(lower(nombre), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') OR translate(lower(codigo), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') )");
            })->whereCatalogoId($this->catalogo_id)->orderBy('nombre')->paginate(20);
    }
    public function updatingBusqueda()
    {
        $this->resetPage();
    }

    public function removeFiltro($propiedad){
        if($propiedad=='parent_id'){
            $this->parent_id=[];
        }else{
            $this->$propiedad = null;
        }
    }

    public function resetFiltros(){
        $this->parent_id = [];
        $this->resetPage();
    }
}
