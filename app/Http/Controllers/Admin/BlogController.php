<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;

class BlogController extends Controller
{
    public function index()
    {
        $q = request('q');
        $blogs = Blog::query()
            ->when($q, fn ($qq) => $qq->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%");
            }))
            ->orderByDesc('published_at')
            ->orderByDesc('updated_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedBlog($request);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('blogs/covers', 'public');
        }

        $blog = Blog::create($data);

        return redirect()->route('admin.blogs.edit', $blog)->with('status', 'Post created.');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $this->validatedBlog($request, $blog);

        if ($request->boolean('cover_remove') && $blog->cover_image) {
            Storage::disk('public')->delete($blog->cover_image);
            $data['cover_image'] = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($blog->cover_image) {
                Storage::disk('public')->delete($blog->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('blogs/covers', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.edit', $blog)->with('status', 'Post updated.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('status', 'Post deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedBlog(Request $request, ?Blog $blog = null): array
    {
        if ($request->input('published_at') === '') {
            $request->merge(['published_at' => null]);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blogs', 'slug')->ignore($blog?->id),
            ],
            'excerpt' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'max:6144'],
            'cover_remove' => ['nullable', 'boolean'],
            'body' => ['required', 'string', function (string $attribute, mixed $value, \Closure $fail) {
                $text = trim(html_entity_decode(strip_tags((string) $value), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                if ($text === '') {
                    $fail('Please add some content to the body.');
                }
            }],
            'published_at' => ['nullable', 'date'],
        ]);

        unset($data['cover_image'], $data['cover_remove']);

        $data['body'] = Purify::clean((string) $data['body']);

        return $data;
    }
}
