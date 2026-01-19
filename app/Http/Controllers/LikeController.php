<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $request, $photoId)
    {
        Like::create([
            'photo_id' => $photoId,
        ]);

        return back()->with('success', 'Photo liked successfully!');
    }
}
