<?php

namespace App\Http\Livewire\Admin;

use App\Models\Catalogo;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Catalogos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'busqueda'
    ];

    public
        $busqueda = null;

    public function render()
    {
        $catalogos = $this->getCatalogos();
        return view('livewire.admin.catalogos',compact('catalogos'));
    }

    public function getCatalogos(){
        return Catalogo::when($this->busqueda,function($q){
            $q->whereRaw(" translate(lower(nombre), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu') OR translate(lower(codigo), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu')");
        })->orderBy('id')->paginate(20);
    }
    public function updatingBusqueda()
    {
        $this->resetPage();
    }

    public function removeFiltro($propiedad){
        $this->$propiedad = null;
    }
}
