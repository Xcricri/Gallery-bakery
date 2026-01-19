<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $galleries = Gallery::where('user_id', $user_id)->latest()->paginate(10);
        return view('galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('galleries.create');
    }

    public function store(Request $request)
    {
        $request->validateWithBag('addGallery', [
            'title' => 'required|string|min:3|max:255',
            'cover' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string|max:255',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
        ]);

        $imagePath = $request->hasFile('cover') ? $request->file('cover')->store('uploads/cover', 'public') : null;

        Gallery::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'cover' => $imagePath,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
        ]);

        return redirect()->route('galleries.index')->with('success', 'Galeri telah ditambahkan');
    }

    public function show(Gallery $gallery)
    {
        $photos = $gallery->photos()->with('comments')->withCount(['likes', 'comments'])->latest()->paginate(12);
        return view('galleries.show', compact('gallery', 'photos'));
    }

    public function edit(Gallery $gallery)
    {
        return view('galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validatedData = $request->validateWithBag('addGallery', [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
        ]);

        if ($request->hasFile('cover')) {
            if ($gallery->cover && Storage::disk('public')->exists($gallery->cover)) {
                Storage::disk('public')->delete($gallery->cover);
            }
            $validatedData['cover'] = $request->file('cover')->store('uploads/cover', 'public');
        }

        $gallery->update($validatedData);

        return redirect()->route('galleries.index')->with('success', 'Galeri telah diubah!');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->cover && Storage::disk('public')->exists($gallery->cover)) {
            Storage::disk('public')->delete($gallery->cover);
        }

        if ($gallery->photos()->exists()) {
            foreach ($gallery->photos as $photo) {
                if ($photo->image && Storage::disk('public')->exists($photo->image)) {
                    Storage::disk('public')->delete($photo->image);
                }
                $photo->delete();
            }
        }

        $gallery->delete();

        return redirect()->route('galleries.index')->with('success', 'Galeri beserta foto di dalamnya telah dihapus!');
    }

    public function changeStatus(Gallery $gallery)
    {
        $gallery->status = $gallery->status === 'active' ? 'inactive' : 'active';
        $gallery->save();

        return redirect()->route('galleries.index')->with('success', 'Status galeri telah diubah!');
    }
}
