@extends('layouts.admin')
@section('title', 'Invoice ' . $invoice->invoice_number)
@section('content')
<div class="card">
    <h2>{{ $invoice->invoice_number }} <span class="badge">{{ ucfirst($invoice->status) }}</span></h2>
    <p><strong>Patient:</strong> {{ $invoice->patient->full_name }}</p>
    <p><strong>Due Date:</strong> {{ $invoice->due_date }}</p>
    <table>
        <thead><tr><th>Description</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead>
        <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format($item->unit_price, 2) }}</td>
                    <td>₹{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p style="margin-top:1rem;"><strong>Subtotal:</strong> ₹{{ number_format($invoice->subtotal, 2) }}</p>
    <p><strong>GST ({{ $invoice->tax_rate }}%):</strong> ₹{{ number_format($invoice->tax_amount, 2) }}</p>
    <p><strong>Total:</strong> ₹{{ number_format($invoice->total, 2) }}</p>
    <p><strong>Paid:</strong> ₹{{ number_format($totalPaid, 2) }}</p>
    <p><strong>Balance Due:</strong> ₹{{ number_format($balanceDue, 2) }}</p>
</div>

@can('billing.payments')
    @if($balanceDue > 0)
        <div class="card">
            <h3>Record Payment</h3>
            <form method="POST" action="{{ route('billing.payments.store', $invoice) }}">
                @csrf
                <label>Amount</label>
                <input type="number" step="0.01" name="amount" max="{{ $balanceDue }}" required>
                <label>Payment Method</label>
                <select name="payment_method" required>
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="upi">UPI</option>
                    <option value="net_banking">Net Banking</option>
                    <option value="cheque">Cheque</option>
                </select>
                <label>Reference No.</label>
                <input name="reference_no">
                <button class="btn" style="margin-top:1rem;" type="submit">Record Payment</button>
            </form>
        </div>
    @endif
@endcan

<div class="card">
    <h3>Payment History</h3>
    @forelse($invoice->payments as $p)
        <p>₹{{ number_format($p->amount, 2) }} — {{ ucfirst($p->payment_method) }} — {{ $p->paid_at }}</p>
    @empty
        <p style="color:#94a3b8;">No payments recorded yet.</p>
    @endforelse
</div>
@endsection