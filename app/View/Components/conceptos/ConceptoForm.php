<?php

namespace App\View\Components\conceptos;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConceptoForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $concepto = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.conceptos.concepto-form');
    }
}
