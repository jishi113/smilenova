<?php

namespace Modules\CMS\Http\Controllers;

use Modules\CMS\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('cms::posts.index', compact('posts'));
    }

    public function create()
    {
        return view('cms::posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'unique:posts'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'tags' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('posts/featured', 'public');
        }

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['author_id'] = auth()->id();
        $validated['is_published'] = $request->has('is_published');
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        Post::create($validated);

        return redirect()->route('cms.posts.index')->with('success', 'Post saved.');
    }

    public function togglePublish(Post $post)
    {
        $post->update([
            'is_published' => !$post->is_published,
            'published_at' => !$post->is_published ? now() : null,
        ]);

        return back()->with('success', 'Post ' . ($post->is_published ? 'published' : 'unpublished') . '.');
    }
}