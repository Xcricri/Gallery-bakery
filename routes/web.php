<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryPostController;

Route::get('/', [GuestController::class, 'welcome'])->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::resource('/galleries', GalleryController::class)->only('show');
});

// route for admin middleware
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/users', UserController::class);
    Route::resource('/posts', PostController::class);
    Route::get('/posts/{post}/changeStatus', [PostController::class, 'changeStatus'])->name('posts.changeStatus');
    Route::get('/posts/{post}/addgalleries', [GalleryPostController::class, 'create'])->name('posts.addGalleries');
    Route::post('/posts/{post}/addgalleries', [GalleryPostController::class, 'store'])->name('posts.storeGalleries');
});

// route for member middleware
Route::middleware(['auth', 'member'])->group(function(){
    Route::resource('/galleries', GalleryController::class);
    Route::get('/galleries/{gallery}/changeStatus', [GalleryController::class, 'changeStatus'])->name('galleries.changeStatus');
    Route::resource('galleries.photos', PhotoController::class);
});

// route for like and comment
Route::post('/photos/{photo}/like', [LikeController::class, 'like'])->name('photos.like');
Route::post('comments', [CommentController::class, 'store'])->name('comments.store');

require __DIR__.'/auth.php';
