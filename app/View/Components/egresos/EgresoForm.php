<?php

namespace App\View\Components\egresos;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EgresoForm extends Component
{
    /**
     * Create a new component instance.
     */

 
    public function __construct(  public $egreso = null)
    {
       
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.egresos.egreso-form');
    }
}
