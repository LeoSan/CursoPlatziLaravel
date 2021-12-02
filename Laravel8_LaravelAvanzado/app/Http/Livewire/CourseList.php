<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;

class CourseList extends Component
{
    public function render()
    {

        //Es  importante señalar que wl with busca funciones declaradas en el modelo para que esto funcione debemos ir al  modelo de curso y declarar la funcion 
        return view('livewire.course-list', [
            'courses' => Course::latest()->with('user')->take(9)->get() 
        ]);
    }
}
