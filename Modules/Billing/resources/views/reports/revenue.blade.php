@extends('layouts.admin')
@section('title', 'Revenue Report')
@section('content')
<div class="card">
    <h2>Revenue Report</h2>
    <form method="GET" style="margin-bottom:1rem;">
        <select name="period" onchange="this.form.submit()">
            <option value="week" @selected($period=='week')>This Week</option>
            <option value="month" @selected($period=='month')>This Month</option>
            <option value="year" @selected($period=='year')>This Year</option>
        </select>
    </form>
    <div class="grid" style="grid-template-columns:repeat(4,1fr);">
        <div class="card"><strong>Total Invoiced</strong><p>₹{{ number_format($stats['total_invoiced'],2) }}</p></div>
        <div class="card"><strong>Total Collected</strong><p>₹{{ number_format($stats['total_collected'],2) }}</p></div>
        <div class="card"><strong>Invoices</strong><p>{{ $stats['invoice_count'] }}</p></div>
        <div class="card"><strong>Paid</strong><p>{{ $stats['paid_count'] }}</p></div>
    </div>
    <h3 style="margin-top:1rem;">Revenue by Service</h3>
    <table>
        <thead><tr><th>Service</th><th>Units</th><th>Revenue</th></tr></thead>
        <tbody>
            @forelse($byService as $s)
                <tr><td>{{ $s->description }}</td><td>{{ $s->units }}</td><td>₹{{ number_format($s->revenue,2) }}</td></tr>
            @empty
                <tr><td colspan="3">No data for this period.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection