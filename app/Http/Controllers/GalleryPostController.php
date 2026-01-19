<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryPostController extends Controller
{
    public function create(Post $post){
        $galleries = Gallery::latest()->where('status', 'active')->get();
        $attachedGalleryIds = $post->galleries->pluck('id')->toArray();
        return view('posts.manage.galleries', compact('post', 'galleries', 'attachedGalleryIds'));
    }

    public function store(Request $request, Post $post){
        $request->validate([
        'galleries' => 'array',
        'galleries.*' => 'exists:galleries,id',
    ]);

    $post->galleries()->sync($request->galleries ?? []);

    return redirect()->route('posts.index')->with('success', 'Galeri berhasil di posting');
    }
}
