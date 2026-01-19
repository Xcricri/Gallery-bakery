<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuestController extends Controller
{
    public function welcome()
    {
        // Slider utama
        $post1 = Post::with([
            'category',
            'galleries' => function ($q) {
                $q->orderBy('galleries.created_at', 'desc')
                    ->limit(5);
            },
            'galleries.photos',
        ])
            ->where('status', 'published')
            ->where('position', 1)
            ->latest()
            ->first();

        // Semua post gallery lain (untuk loop Informasi Terkini)
        $posts = Post::with(['galleries', 'category'])
            ->where('status', 'published')
            ->where('id', '!=', 1)
            ->latest()
            ->get();

        // Post tambahan (optional)
        $post2 = Post::with(['category', 'galleries.photos'])
            ->where('status', 'published')
            ->where('position', 2)
            ->latest()
            ->first();

        $post3 = Post::with(['category', 'galleries.photos'])
            ->where('status', 'published')
            ->where('position', 3)
            ->latest()
            ->first();

        // Agenda
        $calendars = Post::with(['galleries.photos'])
            ->where('type', 'calendar')
            ->where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        return view('welcome', compact('post1', 'posts', 'post2', 'post3', 'calendars'));
    }
}
