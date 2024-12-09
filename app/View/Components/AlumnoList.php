<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AlumnoList extends Component
{
    public $alumnos;
    public function __construct($alumnos)
    {
       $this->alumnos = $alumnos;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alumno-list');
    }
}
