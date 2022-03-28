<?php

namespace App\View\Components\Spinners;

use Illuminate\View\Component;

class Circle extends Component
{
    public $target;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($target = 'submit')
    {
        $this->target = $target;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.spinners.circle');
    }
}
