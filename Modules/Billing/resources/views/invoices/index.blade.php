@extends('layouts.admin')
@section('title', 'Invoices')
@section('content')
<div class="card">
    <h2>Invoices</h2>
    <table>
        <thead><tr><th>Number</th><th>Patient</th><th>Total</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($invoices as $inv)
                <tr>
                    <td>{{ $inv->invoice_number }}</td>
                    <td>{{ $inv->patient->full_name }}</td>
                    <td>₹{{ number_format($inv->total, 2) }}</td>
                    <td><span class="badge">{{ ucfirst($inv->status) }}</span></td>
                    <td><a href="{{ route('billing.invoices.show', $inv) }}" class="btn btn-sm">View</a></td>
                </tr>
            @empty
                <tr><td colspan="5">No invoices yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $invoices->links() }}</div>
</div>
@endsection