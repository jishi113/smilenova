@extends('layouts.admin')

@section('title', 'Revenue Report')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Revenue Report</h2>
            <p class="text-sm text-slate-500">Period: {{ ucfirst($period) }}</p>
        </div>
        <form method="GET" class="flex gap-2">
            <select name="period" onchange="this.form.submit()" class="form-input">
                <option value="week" {{ $period == 'week' ? 'selected' : '' }}>This Week</option>
                <option value="month" {{ $period == 'month' ? 'selected' : '' }}>This Month</option>
                <option value="year" {{ $period == 'year' ? 'selected' : '' }}>This Year</option>
            </select>
        </form>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="kpi-card">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase">Total Invoiced</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">₹{{ number_format($stats['total_invoiced'], 0) }}</p>
            </div>
            <div class="kpi-icon bg-primary-100 text-primary-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
        <div class="kpi-card">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase">Collected</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1">₹{{ number_format($stats['total_collected'], 0) }}</p>
            </div>
            <div class="kpi-icon bg-emerald-100 text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="kpi-card">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase">Invoices</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['invoice_count'] }}</p>
            </div>
            <div class="kpi-icon bg-purple-100 text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
        <div class="kpi-card">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase">Paid Invoices</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['paid_count'] }}</p>
            </div>
            <div class="kpi-icon bg-amber-100 text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <div class="card">
        <p class="text-slate-600 text-sm">Detailed revenue report coming soon.</p>
    </div>
</div>
@endsection