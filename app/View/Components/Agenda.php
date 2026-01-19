<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Agenda extends Component
{
    public $calendars;

    /**p
     * Create a new component instance.
     */
    public function __construct($calendars = null)
    {
        $this->calendars = $calendars;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.agenda');
    }
}
