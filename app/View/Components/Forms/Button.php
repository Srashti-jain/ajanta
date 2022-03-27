<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $text;
    public $type;
    public $class;
    public $icon;

    public function __construct($text,$type,$class,$icon = NULL)
    {
        $this->text  = $text;
        $this->type  = $type;
        $this->class = $class;
        $this->icon  = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.button');
    }
}
