<?php

namespace Modules\Billing\Http\Controllers;

use App\Http\Controllers\Controller;

class BillingController extends Controller
{
    public function index()        { return view('billing::coming-soon', ['title' => 'Invoices']); }
    public function create()       { return view('billing::coming-soon', ['title' => 'Create Invoice']); }
    public function store()        { return back(); }
    public function show($id)      { return view('billing::coming-soon', ['title' => 'Invoice Detail']); }
    public function services()     { return view('billing::coming-soon', ['title' => 'Services']); }
    public function payments()     { return view('billing::coming-soon', ['title' => 'Payments']); }
    public function revenueReport(){ return view('billing::coming-soon', ['title' => 'Revenue Report']); }
}