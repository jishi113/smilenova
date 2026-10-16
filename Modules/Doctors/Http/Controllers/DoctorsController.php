<?php

namespace Modules\Doctors\Http\Controllers;

use App\Http\Controllers\Controller;

class DoctorsController extends Controller
{
    public function index()    { return view('doctors::coming-soon', ['title' => 'Doctors']); }
    public function create()   { return view('doctors::coming-soon', ['title' => 'Create Doctor']); }
    public function store()    { return back(); }
    public function show($id)  { return view('doctors::coming-soon', ['title' => 'Doctor Detail']); }
    public function edit($id)  { return view('doctors::coming-soon', ['title' => 'Edit Doctor']); }
    public function update($id){ return back(); }
    public function destroy($id){ return back(); }
}