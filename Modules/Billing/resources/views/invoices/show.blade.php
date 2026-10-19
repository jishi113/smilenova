@extends('layouts.admin')

@section('title', 'Invoice ' . $invoice->invoice_number)

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.billing.invoices.index') }}" class="p-2 rounded-lg hover:bg-slate-100">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-xl font-semibold text-slate-800">Invoice {{ $invoice->invoice_number }}</h2>
                <p class="text-sm text-slate-500">Created {{ $invoice->created_at->format('M d, Y') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="#" onclick="window.print(); return false;" class="btn btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Invoice Card --}}
        <div class="lg:col-span-2">
            <div class="card">
                {{-- Header --}}
                <div class="flex justify-between items-start pb-6 border-b border-slate-200">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold">SN</div>
                            <div>
                                <p class="font-bold text-slate-800">SmileNova Dental Care</p>
                                <p class="text-xs text-slate-500">Dental Clinic</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-500 uppercase">Invoice Number</p>
                        <p class="font-mono font-bold text-primary-600">{{ $invoice->invoice_number }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $invoice->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                {{-- Bill To --}}
                <div class="py-4 border-b border-slate-200">
                    <p class="text-xs text-slate-500 uppercase mb-1">Bill To</p>
                    <p class="font-semibold text-slate-800">{{ $invoice->patient->full_name ?? 'N/A' }}</p>
                    <p class="text-sm text-slate-600">{{ $invoice->patient->phone ?? '' }}</p>
                    <p class="text-sm text-slate-600">{{ $invoice->patient->email ?? '' }}</p>
                    <p class="text-sm text-slate-600">{{ $invoice->patient->address ?? '' }}</p>
                </div>

                {{-- Items Table --}}
                <div class="py-4">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="text-left py-2 font-semibold text-slate-700">Description</th>
                                <th class="text-center py-2 font-semibold text-slate-700 w-16">Qty</th>
                                <th class="text-right py-2 font-semibold text-slate-700 w-24">Rate</th>
                                <th class="text-right py-2 font-semibold text-slate-700 w-24">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                                <tr class="border-b border-slate-100">
                                    <td class="py-2 text-slate-800">{{ $item->description }}</td>
                                    <td class="text-center py-2 text-slate-600">{{ $item->quantity }}</td>
                                    <td class="text-right py-2 text-slate-600">₹{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-right py-2 text-slate-800 font-medium">₹{{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Totals --}}
                <div class="pt-4 border-t border-slate-200 flex justify-end">
                    <div class="w-64 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Subtotal</span>
                            <span class="font-medium">₹{{ number_format($invoice->subtotal, 2) }}</span>
                        </div>
                        @if($invoice->discount > 0)
                            <div class="flex justify-between">
                                <span class="text-slate-600">Discount</span>
                                <span class="font-medium text-red-600">- ₹{{ number_format($invoice->discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-slate-600">GST ({{ $invoice->tax_rate }}%)</span>
                            <span class="font-medium">₹{{ number_format($invoice->tax_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between border-t border-slate-200 pt-2">
                            <span class="font-semibold text-slate-800">Total</span>
                            <span class="font-bold text-lg text-primary-600">₹{{ number_format($invoice->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Payment Summary --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Status Card --}}
            <div class="card">
                <p class="text-xs text-slate-500 uppercase mb-2">Invoice Status</p>
                <span class="badge badge-{{ $invoice->status === 'paid' ? 'green' : ($invoice->status === 'partial' ? 'yellow' : ($invoice->status === 'overdue' ? 'red' : 'gray')) }} text-sm px-3 py-1">
                    {{ ucfirst($invoice->status) }}
                </span>

                <div class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Due Date</span>
                        <span class="font-medium">{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') : '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Total</span>
                        <span class="font-medium">₹{{ number_format($invoice->total, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Paid</span>
                        <span class="font-medium text-emerald-600">₹{{ number_format($totalPaid, 2) }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-slate-200">
                        <span class="font-semibold text-slate-800">Balance Due</span>
                        <span class="font-bold text-lg {{ $balanceDue > 0 ? 'text-red-600' : 'text-emerald-600' }}">₹{{ number_format($balanceDue, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Record Payment --}}
            @can('billing.payments')
                @if($balanceDue > 0)
                    <div class="card">
                        <h3 class="font-semibold text-slate-800 mb-3">Record Payment</h3>
                        <form action="{{ route('admin.billing.invoices.payment', $invoice) }}" method="POST">
                            @csrf
                            <div class="space-y-3">
                                <div>
                                    <label class="form-label text-xs">Amount (₹)</label>
                                    <input type="number" name="amount" value="{{ $balanceDue }}" min="1" max="{{ $balanceDue }}" step="0.01" required class="form-input text-sm">
                                </div>
                                <div>
                                    <label class="form-label text-xs">Payment Method</label>
                                    <select name="payment_method" required class="form-input text-sm">
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="upi">UPI</option>
                                        <option value="net_banking">Net Banking</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label text-xs">Reference No.</label>
                                    <input type="text" name="reference_no" class="form-input text-sm" placeholder="Optional">
                                </div>
                                <button type="submit" class="btn btn-primary w-full justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Record Payment
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            @endcan

            {{-- Payment History --}}
            @if($invoice->payments->count() > 0)
                <div class="card">
                    <h3 class="font-semibold text-slate-800 mb-3">Payment History</h3>
                    <div class="space-y-2">
                        @foreach($invoice->payments as $payment)
                            <div class="flex justify-between items-start text-sm py-2 border-b border-slate-100 last:border-0">
                                <div>
                                    <p class="font-medium text-slate-800">₹{{ number_format($payment->amount, 2) }}</p>
                                    <p class="text-xs text-slate-500">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                                    @if($payment->reference_no)
                                        <p class="text-xs text-slate-400">Ref: {{ $payment->reference_no }}</p>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-500">{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('M d') : '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection