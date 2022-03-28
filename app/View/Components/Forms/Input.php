<?php

namespace App\View\Components\Forms;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $type;
    public $label;
    public $value;
    public $placeholder;
    public $validate;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $type, $label, $value = '', $placeholder = false, $validate = false)
    {
        $this->name = Str::contains($name, 'timetable') ? $name : 'props.'.$name;
        $this->type = $type;
        $this->label = $label;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->validate = $validate;
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
