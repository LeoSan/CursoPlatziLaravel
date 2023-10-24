<?php

namespace App\Http\Livewire\Admin;

use App\Models\Plantilla;
use Livewire\Component;
use Livewire\WithPagination;

class Plantillas extends Component
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
        $plantillas = Plantilla::when($this->busqueda,function($q){
            $q->whereRaw(" translate(lower(nombre), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu')")
                ->orWhereHas('seccion',function($q){
                    $q->whereRaw(" translate(lower(nombre), 'áàéèíìóòúù', 'aaeeiioouu') LIKE translate(lower('%".trim(strtolower($this->busqueda))."%'), 'áàéèíìóòúù', 'aaeeiioouu')");
                });
        })->orderBy('nombre','ASC')->paginate(20);
        return view('livewire.admin.plantillas',compact('plantillas'));
    }

    public function updatingBusqueda()
    {
        $this->resetPage();
    }

    public function removeFiltro($propiedad){
        $this->$propiedad = null;
    }
}
