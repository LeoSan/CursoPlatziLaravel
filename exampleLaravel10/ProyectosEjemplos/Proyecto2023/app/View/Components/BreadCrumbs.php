<?php

namespace App\View\Components;


use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BreadCrumbs extends Component
{

    public $itemsbread;
    /**
     * Create a new component instance.
     */
    public function __construct($itemsbread)
    {

        $this->itemsbread = $itemsbread;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.bread-crumbs');
    }
}
