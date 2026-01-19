<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validCategories = Category::pluck('id')->toArray();
        $idList = implode(',', $validCategories);

        $request->validateWithBag('addPost', [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'required|in:' . $idList,
            'type' => 'required|in:calendar,gallery',
            'status' => 'required|in:archived,published',
            'position' => 'required|in:1,2,3'
        ]);

        Post::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'type' => $request->type,
            'position' => $request->position,
            'status' => $request->status
        ]);

        return redirect()->route('posts.index')->with('success', 'Posting telah ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return redirect()->route('posts.addGalleries', $post->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('posts.edit', compact('categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validCategories = Category::pluck('id')->toArray();
        $idList = implode(',', $validCategories);

        $request->validateWithBag('addPost', [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'required|in:' . $idList,
            'type' => 'required|in:calendar,gallery',
            'status' => 'required|in:archived,published',
            'position' => 'required|in:1,2,3'
        ]);

        $post->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'type' => $request->type,
            'position' => $request->position,
            'status' => $request->status
        ]);

        return redirect()->route('posts.index')->with('success', 'Post telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->galleries()->detach();

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post telah dihapus');
    }

    public function changeStatus(Post $post)
    {
        if ($post->status === 'published') {
            $post->update(['status' => 'archived']);
            return redirect()->route('posts.index')->with('success', 'Status post telah diarsipkan');
        } else {
            $post->update(['status' => 'published']);
            return redirect()->route('posts.index')->with('success', 'Status post telah dipublikasikan');
        }
    }
}
