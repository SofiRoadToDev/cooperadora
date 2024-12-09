<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IngresosList extends Component
{
    public $ingresos;
    public function __construct($ingresos)
    {
        $this->ingresos = $ingresos;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ingresos-list');
    }
}
