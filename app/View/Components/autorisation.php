<?php

namespace App\View\Components;

use Illuminate\View\Component;

class autorisation extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $autorisation;
     public $type;
     public $id;

     
    public function __construct($type, $autorisation, $id)
    {
        $this->autorisation = $autorisation;
         $this->type = $type;
         $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.autorisation');
    }
}