<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Comment;
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

        $categories = Category::withCount('posts')->get();


        return Inertia::render('PostPage', [
            'post' => $post,
            'comments' => $post->comments,
            'categories' => $categories,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $posts = Post::where('title', 'like', "%{$query}%")
            ->orWhere('body', 'like', "%{$query}%")
            ->with('user')
            ->take(20)
            ->get();

        return response()->json($posts);
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'post_id' => 'required|exists:posts,id',
    //         'body' => 'required|string',
    //     ]);

    //     Comment::create([
    //         'user_id' => auth()->id(),
    //         'post_id' => $validated['post_id'],
    //         'body' => $validated['body'],
    //     ]);

    //     return response()->json(['success' => true]);
    // }


}
