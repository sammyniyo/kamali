<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = Blog::query()
            ->published()
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('pages.blog.index', compact('posts'));
    }

    public function show(string $slug): View
    {
        $blog = Blog::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.blog.show', compact('blog'));
    }
}
