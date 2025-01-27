<?php

namespace App\View\Components\conceptos;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConceptoList extends Component
{

    public function __construct(public $conceptos)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.conceptos.concepto-list');
    }
}
