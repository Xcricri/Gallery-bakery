<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GalleryCard extends Component
{
    public $post;
    public $gallery;
    public $title;
    public $desc;
    public $image;
    public $photosJson;

    /**
     * Create a new component instance.
     */
    public function __construct($post)
    {
        $this->post = $post;

        $this->gallery = $post->galleries->first();

        if ($this->gallery) {
            $this->gallery->load([
                'photos' => function ($q) {
                    $q->withCount(['likes', 'comments'])->with(['comments' => fn($c) => $c->latest()]);
                },
            ]);
        }

        $this->title = $this->gallery ? $this->gallery->title : $post->title ?? 'Judul Gallery';
        $this->desc = $this->gallery ? $this->gallery->description : 'Deskripsi belum tersedia.';
        $this->image = $this->gallery && $this->gallery->cover
            ? asset('storage/' . $this->gallery->cover)
            : 'https://dummyimage.com/600x400/9ca3af/fff&text=No+Image';
        $this->photosJson = $this->gallery ? json_encode($this->gallery->photos, JSON_HEX_APOS | JSON_HEX_QUOT) : '[]';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.gallery-card');
    }
}
