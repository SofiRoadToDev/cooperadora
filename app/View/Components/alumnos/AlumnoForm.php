<?php

namespace App\View\Components\alumnos;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AlumnoForm extends Component
{
    public $cursos;
    public function __construct($cursos)
    {
        $this->cursos = $cursos;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alumnos.alumno-form');
    }
}
