<?php

namespace Modules\Appointments\Http\Controllers;

use App\Http\Controllers\Controller;

class AppointmentsController extends Controller
{
    public function index()    { return view('appointments::coming-soon', ['title' => 'Appointments']); }
    public function create()   { return view('appointments::coming-soon', ['title' => 'Book Appointment']); }
    public function store()    { return back(); }
    public function show($id)  { return view('appointments::coming-soon', ['title' => 'Appointment Detail']); }
    public function edit($id)  { return view('appointments::coming-soon', ['title' => 'Edit Appointment']); }
    public function update($id){ return back(); }
    public function destroy($id){ return back(); }
    public function calendar() { return view('appointments::coming-soon', ['title' => 'Calendar']); }
}