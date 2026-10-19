<?php

namespace Modules\CMS\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\CMS\Models\Page;
use Modules\CMS\Models\Post;
use Modules\CMS\Models\Testimonial;
use Modules\CMS\Models\Gallery;

class CMSController extends Controller
{
    public function index()       { return redirect()->route('admin.cms.pages.index'); }
    public function pages()       { return view('cms::pages.index', ['pages' => Page::latest()->paginate(20)]); }
    public function posts()       { return view('cms::posts.index', ['posts' => Post::latest()->paginate(20)]); }
    public function testimonials(){ return view('cms::testimonials.index', ['testimonials' => Testimonial::orderBy('sort_order')->paginate(20)]); }
    public function gallery()     { return view('cms::gallery.index', ['gallery' => Gallery::orderBy('sort_order')->paginate(20)]); }
}