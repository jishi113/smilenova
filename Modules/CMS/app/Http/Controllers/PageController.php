<?php

namespace Modules\CMS\Http\Controllers;

use Modules\CMS\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('sort_order')->get();
        return view('cms::pages.index', compact('pages'));
    }

    public function create()
    {
        return view('cms::pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200', 'unique:pages'],
            'content' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:200'],
            'meta_desc' => ['nullable', 'string', 'max:500'],
            'template' => ['required', 'in:default,full_width,sidebar,landing'],
            'sort_order' => ['nullable', 'integer'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['created_by'] = auth()->id();
        $validated['is_published'] = $request->has('is_published');

        Page::create($validated);

        return redirect()->route('cms.pages.index')->with('success', 'Page created.');
    }

    public function edit(Page $page)
    {
        return view('cms::pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['required', 'string', 'unique:pages,slug,' . $page->id],
            'content' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string'],
            'meta_desc' => ['nullable', 'string'],
            'template' => ['required', 'in:default,full_width,sidebar,landing'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['is_published'] = $request->has('is_published');
        $page->update($validated);

        return redirect()->route('cms.pages.index')->with('success', 'Page updated.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return back()->with('success', 'Page deleted.');
    }
}