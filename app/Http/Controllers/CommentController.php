<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Menyimpan komentar baru
    public function store(Request $request)
    {
        $request->validate([
            'photo_id' => 'required|exists:photos,id',
            'name'     => 'nullable|string|max:255',
            'content'  => 'required|string|max:500',
        ]);

        Comment::create([
            'photo_id' => $request->photo_id,
            // Jika nama tidak diisi, gunakan nama pengguna yang sedang login atau 'Guest'
            'name'     => $request->input('name') ?: ($request->user()?->name ?? 'Guest'),
            'content'  => $request->input('content'),
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan komentar');
    }

}
