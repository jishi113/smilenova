<?php

namespace Modules\CMS\Http\Controllers;

use App\Http\Controllers\Controller;

class CMSController extends Controller
{
    public function index()       { return view('cms::coming-soon', ['title' => 'CMS']); }
    public function pages()       { return view('cms::coming-soon', ['title' => 'Pages']); }
    public function posts()       { return view('cms::coming-soon', ['title' => 'Blog Posts']); }
    public function testimonials(){ return view('cms::coming-soon', ['title' => 'Testimonials']); }
    public function gallery()     { return view('cms::coming-soon', ['title' => 'Gallery']); }
}