<?php

namespace Modules\CMS\Http\Controllers;

use Modules\CMS\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();
        return view('cms::testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => ['required', 'string', 'max:100'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);
        $validated['is_published'] = $request->has('is_published');

        Testimonial::create($validated);

        return back()->with('success', 'Testimonial added.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted.');
    }
}