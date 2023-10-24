<?php

namespace App\Http\Livewire\Admin;

use App\Models\Catalogo;
use App\Models\{Role, User, DiaNoHabil};
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Inhabiles extends Component
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
        $inhabiles = $this->getInhabiles();
        return view('livewire.admin.inhabiles',compact('inhabiles'));
    }

    public function getInhabiles(){
        return DiaNoHabil::when($this->busqueda,function($q){
            $q->whereRaw(" translate(lower(descripcion), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu')");
            $q->orWhereRaw("TO_CHAR(fecha, 'DD/MM/YYYY') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu')");
        })->orderBy('fecha','ASC')->paginate(20);
    }
    public function updatingBusqueda()
    {
        $this->resetPage();
    }

    public function removeFiltro($propiedad){
        $this->$propiedad = null;
    }
}
