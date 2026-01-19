<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GalleryModal extends Component
{
    public $currentUser;
    /**
     * Create a new component instance.
     */
    public function __construct($currentUser = null)
    {
        $this->currentUser = $currentUser;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.gallery-modal');
    }
}
