<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $label;
    public $name;
    public $required;
    public $placeholder;
    public $value;
    

    public function __construct($label,$name,$required,$placeholder,$value)
    {
        $this->label       = $label;
        $this->name        = $name;
        $this->required    = $required;
        $this->placeholder = $placeholder;
        $this->value       = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.input');
    }
}
