<?php

namespace App\View\Components;

use Illuminate\View\Component;

class modifierPretDemand extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $pret;

    public function __construct($pret)
    {
        $this->pret = $pret;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modifier-pret-demand');
    }
}
