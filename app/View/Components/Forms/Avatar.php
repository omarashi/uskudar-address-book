<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Avatar extends Component
{
    public $name;
    public $label;
    public $validate;
    public $image;
    public $crop;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $image = '', $validate = false, $crop = true)
    {
        $this->name = 'files.' . $name;
        $this->label = $label;
        $this->image = $image;
        $this->validate = $validate;
        $this->crop = $crop;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.avatar');
    }
}
