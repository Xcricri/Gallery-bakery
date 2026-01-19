<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InformasiTerkini extends Component
{
    public $posts;

    /**
     * Create a new component instance.
     */
    public function __construct($posts = null)
    {
        $this->posts = $posts ?? collect();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.informasi-terkini', [
            'posts' => $this->posts
        ]);
    }
}
