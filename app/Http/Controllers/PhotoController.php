<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Gallery $gallery)
    {
        return view('photos.create', compact('gallery'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Gallery $gallery)
    {
        $request->validate([
            'photos'      => 'required|array',
            'photos.*'    => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {

                $path = $file->store('photos', 'public');
                Photo::create([
                    'gallery_id'  => $gallery->id,
                    'file_path'   => $path,
                    'description' => $request->description
                ]);
            }
        }

        return redirect()->route('galleries.show', $gallery->id)
            ->with('success', 'Foto berhasil dimasukan ke galeri!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery, Photo $photo)
    {
        if ($photo->image && Storage::exists('public/' . $photo->image)) {
            Storage::delete('public/' . $photo->image);
        }
        $photo->delete();

        return redirect()->route('galleries.show', $gallery->id)->with('success', 'Foto berhasil dihapus dari galeri!');
    }
}
