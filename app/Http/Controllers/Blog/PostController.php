<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->published()->paginate(10);
        return view('blog.posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('blog.posts.show', compact('post'));
    }
}
