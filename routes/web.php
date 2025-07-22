<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('news', function () {

    $posts = Post::with('user')
        ->whereNull('deleted_at')
        ->latest()
        ->withCount('comments')
        ->paginate(10);

    $categories = Category::withCount('posts')->get();


    return Inertia::render('Dashboard', [
        'posts' => $posts,
        'categories' => $categories,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/news/category/{slug}', [PostController::class, 'byCategory'])->name('news.category');

Route::get('/news/{slug}', [PostController::class, 'show'])->name('post.show');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::get('/search-posts', [PostController::class, 'search']);

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
