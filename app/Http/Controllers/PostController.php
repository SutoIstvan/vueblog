<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Inertia\Inertia;

class PostController extends Controller
{
    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Post::with('user')
            ->where('category_id', $category->id)
            ->whereNull('deleted_at')
            ->latest()
            ->paginate(10);

        $categories = Category::withCount('posts')->get();

        return Inertia::render('Dashboard', [
            'posts' => $posts,
            'categories' => $categories,
            'selectedCategory' => $category->name,
        ]);
    }

    public function show($slug)
    {
        // $post = Post::with('user')->where('slug', $slug)->firstOrFail();
        $post = Post::with(['user', 'comments.user'])->where('slug', $slug)->firstOrFail();

        return Inertia::render('PostPage', [
            'post' => $post,
        ]);
    }

    public function comment(Request $request, int $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post = Post::findOrFail($id);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back();
    }

}
