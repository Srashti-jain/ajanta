<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Toggle extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $label;
    public $name;
    public $checked;
    public $helptext;

    public function __construct($label,$name,$checked,$helptext = NULL)
    {
        $this->label    = $label;
        $this->name     = $name;
        $this->checked  = $checked;
        $this->helptext = $helptext;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.toggle');
    }
}
