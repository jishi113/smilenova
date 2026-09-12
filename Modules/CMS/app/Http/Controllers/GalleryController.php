<?php

namespace Modules\CMS\Http\Controllers;

use Modules\CMS\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index()
    {
        $images = Gallery::orderBy('sort_order')->get();
        return view('cms::gallery.index', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['image', 'max:2048'],
            'category' => ['nullable', 'string'],
        ]);

        foreach ($request->file('images') as $file) {
            $path = $file->store('gallery', 'public');
            Gallery::create([
                'image_path' => $path,
                'category' => $request->category ?: 'clinic',
                'is_published' => true,
            ]);
        }

        return back()->with('success', 'Images uploaded.');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return back()->with('success', 'Image removed.');
    }
}