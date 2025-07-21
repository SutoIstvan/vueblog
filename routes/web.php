<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {

    $posts = Post::with('user')
        ->whereNull('deleted_at')
        ->latest()
        ->paginate(10);

    $categories = Category::withCount('posts')->get();


    return Inertia::render('Dashboard', [
        'posts' => $posts,
        'categories' => $categories,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
