@extends('layouts.admin')

@section('title', 'Billing & Invoices')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Billing & Invoices</h2>
            <p class="text-sm text-slate-500">Manage all clinic invoices and payments</p>
        </div>
        @can('billing.create')
            <a href="{{ route('admin.billing.invoices.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Invoice
            </a>
        @endcan
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="kpi-card">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase">Total Invoiced</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">₹{{ number_format($stats['total_invoiced'], 0) }}</p>
                <p class="text-xs text-slate-500 mt-1">{{ $stats['invoice_count'] }} invoices</p>
            </div>
            <div class="kpi-icon bg-primary-100 text-primary-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
        <div class="kpi-card">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase">Collected</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1">₹{{ number_format($stats['total_collected'], 0) }}</p>
                <p class="text-xs text-emerald-600 mt-1">From payments</p>
            </div>
            <div class="kpi-icon bg-emerald-100 text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="kpi-card">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase">Pending</p>
                <p class="text-2xl font-bold text-amber-600 mt-1">₹{{ number_format($stats['total_pending'], 0) }}</p>
                <p class="text-xs text-slate-500 mt-1">Unpaid invoices</p>
            </div>
            <div class="kpi-icon bg-amber-100 text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="kpi-card">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase">Reports</p>
                @can('billing.reports')
                    <a href="{{ route('admin.billing.reports.revenue') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 mt-2 inline-flex items-center gap-1">
                        View Reports →
                    </a>
                @endcan
            </div>
            <div class="kpi-icon bg-purple-100 text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="sm:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search by invoice number or patient name..."
                       class="form-input">
            </div>
            <div class="flex gap-2">
                <select name="status" class="form-input">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
            </div>
        </form>
    </div>

    {{-- Invoices Table --}}
    <div class="card overflow-hidden">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td>
                                <span class="font-mono text-xs font-medium text-primary-600 bg-primary-50 px-2 py-1 rounded">
                                    {{ $invoice->invoice_number }}
                                </span>
                            </td>
                            <td>
                                <p class="font-medium text-slate-800 text-sm">{{ $invoice->patient->full_name ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-500">{{ $invoice->patient->patient_code ?? '' }}</p>
                            </td>
                            <td class="text-sm">{{ $invoice->created_at->format('M d, Y') }}</td>
                            <td class="font-semibold text-slate-800">₹{{ number_format($invoice->total, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $invoice->status === 'paid' ? 'green' : ($invoice->status === 'partial' ? 'yellow' : ($invoice->status === 'overdue' ? 'red' : 'gray')) }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.billing.invoices.show', $invoice) }}" class="btn btn-sm btn-secondary">View</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <p class="text-slate-600 font-medium">No invoices yet</p>
                                    <p class="text-slate-400 text-sm mt-1">Create your first invoice</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($invoices->hasPages())
            <div class="px-4 py-3 border-t border-slate-200">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>

</div>
@endsection