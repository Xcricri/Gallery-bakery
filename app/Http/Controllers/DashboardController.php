<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->where('status', 'active')->paginate(9);
        return view('dashboard', compact('galleries'));
    }
}
