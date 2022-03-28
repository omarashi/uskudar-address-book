<?php

namespace App\View\Components\Forms;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $label;
    public $validate;
    public $options;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $validate = false, $options = [])
    {
        $this->name = Str::contains($name, 'timetable') ? $name : 'props.'.$name;
        $this->label = $label;
        $this->validate = $validate;
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.select');
    }
}
