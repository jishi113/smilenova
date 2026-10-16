<?php

namespace Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index() { return view('settings::coming-soon', ['title' => 'Settings']); }
    public function save()  { return back(); }
}